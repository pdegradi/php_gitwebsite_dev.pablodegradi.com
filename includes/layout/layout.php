<?php
/**
 * layout.php
 * Template shared by every page. Internal file, not meant to be requested directly.
 *
 * Before including this file, a page must have defined:
 *   $content     (string, required) - body HTML, built via output buffering
 *   $page_title  (string, optional) - page title
 *
 * A page can also optionally define:
 *   $page_css    (string, optional) - HTML added AFTER the global stylesheet
 *   $page_js     (string, optional) - HTML added AFTER the global script
 *   $seo         (array,  optional) - SEO meta tags, see includes/functions.php.
 *                                     If omitted (or empty), no SEO tags are rendered.
 */

if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

require_once __DIR__ . '/../functions.php';

$page_title = $page_title ?? $site_name;
$page_css   = $page_css   ?? '';
$page_js    = $page_js    ?? '';
$seo        = $seo        ?? [];
?>
<!DOCTYPE html>
<html lang="<?= $site_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> · <?= htmlspecialchars($site_name) ?></title>
    <meta name="description" content="<?= htmlspecialchars($site_description) ?>">
<?php if (!empty($seo)): ?>
<?= render_seo_tags($seo) ?>
<?php endif; ?>
    <!-- <link rel="stylesheet" href="/assets/vendor/katex/katex.min.css"> -->
    <link rel="stylesheet" href="/assets/css/helper-class.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?= $page_css ?>
</head>
<body>
    <header class="site-header">
        <div class="wrap-wide">
            <a class="site-brand" href="/index.php"><?= htmlspecialchars($site_name) ?></a>
            <button class="nav-toggle" type="button" aria-label="Apri il menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <nav class="site-nav" id="site-nav">
                <a href="/servizi-web.php">Servizi Web</a>
                <a href="/servizi-ai.php">Servizi AI</a>
                <a href="/blog.php">Blog</a>
                <a href="/progetti.php">Progetti</a>
            </nav>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer class="site-footer">
        <div class="wrap-wide">
            <p class="text-center">&copy; <?= date('Y') ?> <?= htmlspecialchars($site_name) ?></p>
        </div>
    </footer>

    <!-- <script src="/assets/vendor/katex/katex.min.js" defer></script> -->
    <script src="/assets/js/main.js" defer></script>
    <?= $page_js ?>
</body>
</html>
