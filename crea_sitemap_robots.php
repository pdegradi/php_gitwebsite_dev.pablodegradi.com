<?php
/**
 * crea_sitemap_robots.php
 * Generates robots.txt and sitemap.xml directly in the project root,
 * for when you deploy the PHP framework itself (not the dist/ static
 * export) to a normal PHP hosting. Lists the real .php page URLs.
 *
 * Run from the site root:
 *   php crea_sitemap_robots.php
 */

// ============================================================
// CONFIGURATION
// ============================================================

$siteRoot = __DIR__;

// Folders to skip when scanning for public pages (relative to $siteRoot).
$excludeDirs = ['includes', 'dist', 'articles'];

// Specific PHP files to skip (relative to $siteRoot).
$excludeFilesPHP = ["build-static.php", "progetto.php"];

// Filename glob patterns to skip (matched against the filename only).
$excludePatternsPHP = ['*.part.php'];

// Read the public URL from includes/config.php below, so page metadata and
// the generated sitemap always use the same domain.
$siteUrl = '';

// Prefix for every page URL, only if the site lives in a subpath
// (e.g. '/blog'). Empty if it's deployed at the domain root.
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

/**
 * Finds every public *.php page under $root: skips $excludeDirs, hidden
 * folders, this script itself, $excludeFilesPHP and anything matching
 * $excludePatternsPHP. Returns paths relative to $root, forward slashes.
 */
function findPublicPages(string $root, array $excludeDirs, array $excludeFilesPHP, array $excludePatternsPHP, string $selfFile): array
{
    $dirIterator = new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS);
    $filter = new RecursiveCallbackFilterIterator($dirIterator, function ($current) use ($root, $excludeDirs) {
        if (!$current->isDir()) {
            return true;
        }
        if (str_starts_with($current->getFilename(), '.')) {
            return false; // hidden folders always skipped
        }
        $relPath = ltrim(str_replace('\\', '/', substr($current->getPathname(), strlen($root))), '/');
        return !in_array($relPath, $excludeDirs, true);
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

/** Writes robots.txt in $siteRoot, deleting any previous one first. */
function generateRobotsTxt(string $siteRoot, string $siteUrl, string $basePath): void
{
    $path = $siteRoot . DIRECTORY_SEPARATOR . 'robots.txt';
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
 * Writes sitemap.xml in $siteRoot, deleting any previous one first.
 * $urls are page paths relative to the site root (e.g. "blog.php",
 * "blog.php?page=2"). $articleDates maps those same paths to a Y-m-d
 * date, used as <lastmod> where known. Does nothing if $siteUrl is empty.
 */
function generateSitemap(string $siteRoot, array $urls, array $articleDates, string $siteUrl, string $basePath): void
{
    $path = $siteRoot . DIRECTORY_SEPARATOR . 'sitemap.xml';
    if (file_exists($path)) {
        unlink($path);
    }
    if ($siteUrl === '') {
        return;
    }

    $prefix = rtrim($siteUrl, '/') . rtrim($basePath, '/') . '/';

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    sort($urls);
    foreach ($urls as $url) {
        $loc = $url === 'index.php' ? $prefix : $prefix . $url;
        $xml .= "  <url>\n    <loc>" . htmlspecialchars($loc) . "</loc>\n";
        if (isset($articleDates[$url])) {
            $xml .= '    <lastmod>' . htmlspecialchars($articleDates[$url]) . "</lastmod>\n";
        }
        $xml .= "  </url>\n";
    }

    $xml .= '</urlset>' . "\n";
    file_put_contents($path, $xml);
}

// ============================================================
// RUN
// ============================================================

line('== Generazione robots.txt e sitemap.xml (deploy PHP live) ==');
line();

define('FRAMEWORK_ENTRY', true);
require $siteRoot . '/includes/config.php';
$siteUrl = rtrim($site_url, '/');
if ($siteUrl === '') {
    fail('Imposta $site_url in includes/config.php prima di lanciare lo script.');
}

$publicArticles = get_public_articles($articles, $article_sort_by, $article_sort_order);
$totalBlogPages = max(1, (int) ceil(count($publicArticles) / $blog_page_size));

$pages = findPublicPages($siteRoot, $excludeDirs, $excludeFilesPHP, $excludePatternsPHP, __FILE__);
if (empty($pages)) {
    fail('Nessuna pagina pubblica trovata.');
}

$urls = array_values(array_diff($pages, ['404.php', 'privacy.php', 'note-legali.php']));
for ($p = 2; $p <= $totalBlogPages; $p++) {
    $urls[] = 'blog-progetti.php?page=' . $p;
}

$articleDates = [];
foreach ($publicArticles as $article) {
    if (($article['status'] ?? '') === 'bozza') {
        continue;
    }
    $url = 'progetto.php?slug=' . rawurlencode($article['slug']);
    $urls[] = $url;
    if (!empty($article['date'])) {
        $articleDates[$url] = $article['date'];
    }
}

generateRobotsTxt($siteRoot, $siteUrl, $basePath);
line('robots.txt generato.');

generateSitemap($siteRoot, $urls, $articleDates, $siteUrl, $basePath);
line('sitemap.xml generato (' . count($urls) . ' URL).');

line();
line('Completato.');
