<?php
/**
 * build-static.php
 * Generates a static HTML export by running every public PHP page
 * through the PHP CLI and capturing its output. No web server, no
 * network involved.
 *
 * Run from the site root:
 *   php build-static.php
 */

// ============================================================
// CONFIGURATION
// ============================================================

$siteRoot = __DIR__;

// Folders to skip when scanning for public pages (relative to $siteRoot).
$excludeDirs = ['includes'];

// Specific PHP files to skip (relative to $siteRoot).
$excludeFilesPHP = ["crea_sitemap_robots.php"];

// Filename glob patterns to skip (matched against the filename only).
$excludePatternsPHP = ['*.part.php'];

// Folders copied as-is into the output (relative to $siteRoot).
$copyDirs = ['assets'];

// Output folder for the static export, created inside $siteRoot.
$outputDir = 'dist';

// Folders inside $outputDir never deleted during cleanup.
$preserveDirsDist = ['.git', 'node_modules'];

// Files inside $outputDir never deleted during cleanup. robots.txt/
// sitemap.xml are still rewritten fresh on every build regardless (see
// below); .nojekyll/CNAME are only created once, if missing.
$preserveFilesDist = ['.git', '.gitignore', 'robots.txt', 'CNAME', '.nojekyll'];

// Full public URL for sitemap.xml / the robots.txt Sitemap line, no
// trailing slash (e.g. 'https://example.com'). Empty = skip both.
$siteUrl = 'https://dev.pablodegradi.com';

// Prefix for every root-absolute link/asset path. Empty = deploy at
// domain root. Set e.g. '/my-repo' for a subpath deploy.
$basePath = '';

// ============================================================
// END CONFIGURATION
// ============================================================

error_reporting(E_ALL);

function line(string $text = ''): void
{
    echo $text . PHP_EOL;
}

function fail(string $message): void
{
    line('ERRORE: ' . $message);
    exit(1);
}

/** Removes a directory and everything inside it. */
function removeDirRecursive(string $path): void
{
    if (is_link($path)) {
        unlink($path);
        return;
    }
    foreach (scandir($path) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $full = $path . DIRECTORY_SEPARATOR . $entry;
        is_dir($full) ? removeDirRecursive($full) : unlink($full);
    }
    rmdir($path);
}

/**
 * Empties $dir except for entries in $preserveDirs/$preserveFiles
 * (paths relative to $baseDir). A folder containing a preserved entry
 * is kept and cleaned recursively instead of being wiped outright.
 */
function cleanOutputDir(string $dir, string $baseDir, array $preserveDirs, array $preserveFiles): void
{
    if (!is_dir($dir)) {
        return;
    }

    $allPreserve = array_merge($preserveDirs, $preserveFiles);

    foreach (scandir($dir) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }

        $path = $dir . DIRECTORY_SEPARATOR . $entry;
        $relPath = ltrim(str_replace('\\', '/', substr($path, strlen($baseDir))), '/');
        $isDir = is_dir($path);

        if (in_array($relPath, $isDir ? $preserveDirs : $preserveFiles, true)) {
            continue;
        }

        $hasPreservedDescendant = false;
        foreach ($allPreserve as $p) {
            if (strpos($p, $relPath . '/') === 0) {
                $hasPreservedDescendant = true;
                break;
            }
        }

        if ($isDir) {
            $hasPreservedDescendant
                ? cleanOutputDir($path, $baseDir, $preserveDirs, $preserveFiles)
                : removeDirRecursive($path);
        } elseif (!$hasPreservedDescendant) {
            unlink($path);
        }
    }
}

/** Copies a directory into another, creating destination folders as needed. */
function copyDirRecursive(string $src, string $dst): void
{
    if (!is_dir($dst)) {
        mkdir($dst, 0777, true);
    }
    foreach (scandir($src) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        $srcPath = $src . DIRECTORY_SEPARATOR . $entry;
        $dstPath = $dst . DIRECTORY_SEPARATOR . $entry;
        is_dir($srcPath) ? copyDirRecursive($srcPath, $dstPath) : copy($srcPath, $dstPath);
    }
}

/** Creates an empty file only if it doesn't already exist. Returns true if created. */
function ensureEmptyFileExists(string $path): bool
{
    if (file_exists($path)) {
        return false;
    }
    file_put_contents($path, '');
    return true;
}

/**
 * Finds every public *.php page under $root: skips $excludeDirs,
 * $copyDirs, $outputDir, hidden folders, the build script itself,
 * $excludeFilesPHP and anything matching $excludePatternsPHP.
 * Returns paths relative to $root, forward slashes.
 */
function findPublicPages(
    string $root,
    array $excludeDirs,
    array $copyDirs,
    string $outputDir,
    array $excludeFilesPHP,
    array $excludePatternsPHP,
    string $selfFile
): array {
    $skipDirs = array_merge($excludeDirs, $copyDirs, [$outputDir]);

    $dirIterator = new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS);
    $filter = new RecursiveCallbackFilterIterator($dirIterator, function ($current) use ($root, $skipDirs) {
        if (!$current->isDir()) {
            return true;
        }
        if (str_starts_with($current->getFilename(), '.')) {
            return false; // hidden folders always skipped
        }
        $relPath = ltrim(str_replace('\\', '/', substr($current->getPathname(), strlen($root))), '/');
        return !in_array($relPath, $skipDirs, true);
    });

    $iterator = new RecursiveIteratorIterator($filter);
    $selfRealPath = realpath($selfFile);

    $pages = [];
    foreach ($iterator as $file) {
        if (strtolower($file->getExtension()) !== 'php') {
            continue;
        }
        if (realpath($file->getPathname()) === $selfRealPath) {
            continue;
        }

        $relPath = ltrim(str_replace('\\', '/', substr($file->getPathname(), strlen($root))), '/');

        if (in_array($relPath, $excludeFilesPHP, true)) {
            continue;
        }

        $skip = false;
        foreach ($excludePatternsPHP as $pattern) {
            if (fnmatch($pattern, $file->getFilename())) {
                $skip = true;
                break;
            }
        }
        if ($skip) {
            continue;
        }

        $pages[] = $relPath;
    }

    sort($pages);
    return $pages;
}

/**
 * Runs a PHP file through the CLI and captures its output. Always uses
 * PHP_BINARY. Extra $args become $argv in the page (used for blog
 * pagination pages).
 */
function runPhpPage(string $absolutePath, string $cwd, array $args = []): array
{
    $descriptors = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $command = array_merge([PHP_BINARY, $absolutePath], $args);
    $process = proc_open($command, $descriptors, $pipes, $cwd);

    if (!is_resource($process)) {
        return ['exitCode' => -1, 'stdout' => '', 'stderr' => 'Impossibile avviare il processo PHP.'];
    }

    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $exitCode = proc_close($process);

    return ['exitCode' => $exitCode, 'stdout' => $stdout, 'stderr' => $stderr];
}

/**
 * Rewrites root-absolute href/src refs: known pages get remapped via
 * $pageMap (.php -> .html), everything root-absolute gets $basePath prepended.
 */
function rewriteLinks(string $html, array $pageMap, string $basePath): string
{
    $basePath = rtrim($basePath, '/');

    return preg_replace_callback('/(href|src)="(\/[^"]*)"/', function (array $m) use ($pageMap, $basePath) {
        $path = $pageMap[$m[2]] ?? $m[2];
        return $m[1] . '="' . $basePath . $path . '"';
    }, $html);
}

/** Writes robots.txt, deleting any previous one first. */
function generateRobotsTxt(string $outputPath, string $siteUrl, string $basePath): void
{
    $path = $outputPath . DIRECTORY_SEPARATOR . 'robots.txt';
    if (file_exists($path)) {
        unlink($path);
    }

    $content = "User-agent: *\nAllow: /\n";
    if ($siteUrl !== '') {
        $content .= "\nSitemap: " . rtrim($siteUrl, '/') . rtrim($basePath, '/') . "/sitemap.xml\n";
    }

    file_put_contents($path, $content);
}

/**
 * Writes sitemap.xml, deleting any previous one first. $articleDates
 * maps html paths (e.g. "/articles/foo.html") to a Y-m-d date, used as
 * <lastmod> where known. Does nothing if $siteUrl is empty.
 */
function generateSitemap(string $outputPath, array $htmlPaths, array $articleDates, string $siteUrl, string $basePath): void
{
    $path = $outputPath . DIRECTORY_SEPARATOR . 'sitemap.xml';
    if (file_exists($path)) {
        unlink($path);
    }
    if ($siteUrl === '') {
        return;
    }

    $prefix = rtrim($siteUrl, '/') . rtrim($basePath, '/');

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    sort($htmlPaths);
    foreach ($htmlPaths as $htmlPath) {
        $loc = $prefix . ($htmlPath === '/index.html' ? '/' : $htmlPath);
        $xml .= "  <url>\n    <loc>" . htmlspecialchars($loc) . "</loc>\n";
        if (isset($articleDates[$htmlPath])) {
            $xml .= '    <lastmod>' . htmlspecialchars($articleDates[$htmlPath]) . "</lastmod>\n";
        }
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>' . "\n";
    file_put_contents($path, $xml);
}

// ============================================================
// BUILD
// ============================================================

line('== Generazione sito statico ==');
line();

// Load the framework's own config.php (fixed path, not configurable)
// to read $articles and $blog_page_size for the pagination pages below.
define('FRAMEWORK_ENTRY', true);
require $siteRoot . '/includes/config.php';

$totalBlogPages = 1;
if (isset($articles, $blog_page_size) && $blog_page_size > 0) {
    $totalBlogPages = max(1, (int) ceil(count($articles) / $blog_page_size));
}

$outputPath = $siteRoot . DIRECTORY_SEPARATOR . $outputDir;

if (!is_dir($outputPath)) {
    mkdir($outputPath, 0777, true);
    line("Creata la cartella di output: $outputDir/");
} else {
    line("Pulizia di $outputDir/, preservando: " . implode(', ', array_unique(array_merge($preserveDirsDist, $preserveFilesDist))));
    cleanOutputDir($outputPath, $outputPath, $preserveDirsDist, $preserveFilesDist);
}

foreach (['.nojekyll', 'CNAME'] as $f) {
    if (ensureEmptyFileExists($outputPath . DIRECTORY_SEPARATOR . $f)) {
        line("$f creato (vuoto).");
    }
}
line();

$pages = findPublicPages($siteRoot, $excludeDirs, $copyDirs, $outputDir, $excludeFilesPHP, $excludePatternsPHP, __FILE__);
if (empty($pages)) {
    fail('Nessuna pagina pubblica trovata.');
}
line('Pagine trovate: ' . count($pages));


$pageMap = [];
foreach ($pages as $relPath) {
    $pageMap['/' . $relPath] = '/' . preg_replace('/\.php$/', '.html', $relPath);
}
for ($p = 2; $p <= $totalBlogPages; $p++) {
    $pageMap['/blog.php?page=' . $p] = '/blog-' . $p . '.html';
}


line();
$failures = [];
$generated = 0;

// print_r($pages);
// die();

foreach ($pages as $relPath) {
    $absolutePath = $siteRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relPath);
    $result = runPhpPage($absolutePath, $siteRoot);

    if ($result['exitCode'] !== 0) {
        $failures[] = $relPath;
        line("  [ERRORE] $relPath");
        line('    ' . trim($result['stderr']));
        continue;
    }
    if (trim($result['stderr']) !== '') {
        line("  [AVVISO] $relPath");
        line('    ' . trim($result['stderr']));
    }

    $html = rewriteLinks($result['stdout'], $pageMap, $basePath);
    $htmlRelPath = $pageMap['/' . $relPath];
    $destPath = $outputPath . str_replace('/', DIRECTORY_SEPARATOR, $htmlRelPath);
    $destDir = dirname($destPath);
    if (!is_dir($destDir)) {
        mkdir($destDir, 0777, true);
    }
    file_put_contents($destPath, $html);

    $generated++;
    line("  [OK] $relPath -> $outputDir$htmlRelPath");
}

line();

if ($totalBlogPages > 1) {
    line('Generazione pagine aggiuntive del blog (paginazione):');
    $blogAbsolutePath = $siteRoot . DIRECTORY_SEPARATOR . 'blog.php';

    for ($p = 2; $p <= $totalBlogPages; $p++) {
        $result = runPhpPage($blogAbsolutePath, $siteRoot, [(string) $p]);

        if ($result['exitCode'] !== 0) {
            $failures[] = "blog.php (pagina $p)";
            line("  [ERRORE] blog.php pagina $p");
            line('    ' . trim($result['stderr']));
            continue;
        }
        if (trim($result['stderr']) !== '') {
            line("  [AVVISO] blog.php pagina $p");
            line('    ' . trim($result['stderr']));
        }

        $html = rewriteLinks($result['stdout'], $pageMap, $basePath);
        file_put_contents($outputPath . DIRECTORY_SEPARATOR . "blog-$p.html", $html);

        $generated++;
        line("  [OK] blog.php?page=$p -> $outputDir/blog-$p.html");
    }
    line();
}

foreach ($copyDirs as $dir) {
    $srcPath = $siteRoot . DIRECTORY_SEPARATOR . $dir;
    if (is_dir($srcPath)) {
        copyDirRecursive($srcPath, $outputPath . DIRECTORY_SEPARATOR . $dir);
        line("Cartella $dir/ copiata in $outputDir/$dir/");
    } else {
        line("Attenzione: cartella $dir/ non trovata, saltata.");
    }
}

line();

$articleDates = [];
foreach ($articles as $article) {
    if (!empty($article['file']) && !empty($article['date'])) {
        $articleDates['/' . preg_replace('/\.php$/', '.html', $article['file'])] = $article['date'];
    }
}

generateRobotsTxt($outputPath, $siteUrl, $basePath);
line('robots.txt generato.');

if ($siteUrl === '') {
    line('sitemap.xml NON generata: imposta $siteUrl in cima a questo file per attivarla.');
} else {
    generateSitemap($outputPath, array_values($pageMap), $articleDates, $siteUrl, $basePath);
    line('sitemap.xml generata.');
}

line();
line('== Riepilogo ==');
line("Pagine generate: $generated / " . (count($pages) + max(0, $totalBlogPages - 1)));
if (!empty($failures)) {
    line('Pagine con errori (NON esportate): ' . implode(', ', $failures));
    exit(1);
}
line('Completato senza errori.');