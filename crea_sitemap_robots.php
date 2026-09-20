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
$excludeDirs = ['includes', 'dist'];

// Specific PHP files to skip (relative to $siteRoot).
$excludeFilesPHP = ["build-static.php"];

// Filename glob patterns to skip (matched against the filename only).
$excludePatternsPHP = ['*.part.php'];

// Full public URL of the live site, no trailing slash (e.g. 'https://example.com').
// Required: without it the URLs in the sitemap/robots.txt would be invalid.
$siteUrl = 'http://dev.pablodegradi.com';

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
        $loc = $prefix . $url;
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

if ($siteUrl === '') {
    fail('Imposta $siteUrl in cima a questo file (es. https://tuosito.it) prima di lanciarlo.');
}

define('FRAMEWORK_ENTRY', true);
require $siteRoot . '/includes/config.php';

$totalBlogPages = 1;
if (isset($articles, $blog_page_size) && $blog_page_size > 0) {
    $totalBlogPages = max(1, (int) ceil(count($articles) / $blog_page_size));
}

$pages = findPublicPages($siteRoot, $excludeDirs, $excludeFilesPHP, $excludePatternsPHP, __FILE__);
if (empty($pages)) {
    fail('Nessuna pagina pubblica trovata.');
}

$urls = $pages;
for ($p = 2; $p <= $totalBlogPages; $p++) {
    $urls[] = 'blog.php?page=' . $p;
}

$articleDates = [];
foreach ($articles as $article) {
    if (!empty($article['file']) && !empty($article['date'])) {
        $articleDates[$article['file']] = $article['date'];
    }
}

generateRobotsTxt($siteRoot, $siteUrl, $basePath);
line('robots.txt generato.');

generateSitemap($siteRoot, $urls, $articleDates, $siteUrl, $basePath);
line('sitemap.xml generato (' . count($urls) . ' URL).');

line();
line('Completato.');
