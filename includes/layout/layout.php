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

$page_title = $page_title ?? $nome_cognome;
$page_css   = $page_css   ?? '';
$page_js    = $page_js    ?? '';
$seo        = $seo        ?? [];
$current_file = basename($_SERVER['SCRIPT_FILENAME'] ?? '');
?>
<!DOCTYPE html>
<html lang="<?= $site_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title === $nome_cognome ? $nome_cognome : $page_title . ' · ' . $nome_cognome) ?></title>
<?php if (!empty($seo)): ?>
<?= render_seo_tags($seo) ?>
<?php else: ?>
    <meta name="description" content="<?= htmlspecialchars($site_description) ?>">
<?php endif; ?>
    <link rel="stylesheet" href="/assets/css/helper-class.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?= $page_css ?>
</head>
<body>
    <a class="skip-link" href="#main-content">Vai al contenuto</a>
    <header class="site-header">
        <div class="wrap-wide">
            <a class="site-brand" href="/index.php" aria-label="<?= htmlspecialchars($nome_cognome) ?>, home"><?= htmlspecialchars($nome) ?><span class="accent-dot">.</span><small>Web developer</small></a>
            <button class="nav-toggle" type="button" aria-label="Apri il menu" aria-controls="site-nav" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
            <nav class="site-nav" id="site-nav" aria-label="Navigazione principale">
                <a href="/servizi-web-app-custom.php"<?= $current_file === 'servizi-web-app-custom.php' ? ' aria-current="page"' : '' ?>>Web App</a>
                <a href="/servizi-siti-web.php"<?= $current_file === 'servizi-siti-web.php' ? ' aria-current="page"' : '' ?>>Siti Web</a>
                <a href="/servizi-automazioni-ai.php"<?= $current_file === 'servizi-automazioni-ai.php' ? ' aria-current="page"' : '' ?>>Automazioni e AI</a>
                <a href="/servizi-consulenza-formazione.php"<?= $current_file === 'servizi-consulenza-formazione.php' ? ' aria-current="page"' : '' ?>>Consulenza</a>
                <a href="/blog-progetti.php"<?= $current_file === 'blog-progetti.php' ? ' aria-current="page"' : '' ?>>Progetti</a>
                <a href="/chi-sono.php"<?= $current_file === 'chi-sono.php' ? ' aria-current="page"' : '' ?>>Chi sono</a>
            </nav>
            <?= render_email_link($email, 'Scrivimi', 'header-contact') ?>
        </div>
    </header>

    <main id="main-content">
        <?= $content ?>
    </main>

    <footer class="site-footer">
        <div class="wrap-wide footer-main">
            <div><a class="footer-brand" href="/index.php"><?= htmlspecialchars($nome) ?><span class="accent-dot">.</span></a><p>Soluzioni web su misura per professionisti e piccole imprese.</p></div>
            <div><h2>Esplora</h2><a href="/servizi-web-app-custom.php">Web App Custom</a><a href="/servizi-siti-web.php">Siti Web</a><a href="/servizi-automazioni-ai.php">Automazioni e AI</a><a href="/servizi-consulenza-formazione.php">Consulenza e Formazione</a><a href="/blog-progetti.php">Progetti</a><a href="/chi-sono.php">Chi sono</a></div>
            <div><h2>Contatti</h2><?= render_email_link($email) ?><?php if ($linkedin_url !== ''): ?><a class="footer-external" href="<?= htmlspecialchars($linkedin_url, ENT_QUOTES) ?>" rel="noopener noreferrer">LinkedIn</a><?php endif; ?><p>Hai un’idea o un processo da semplificare? Scrivimi.</p></div>
        </div>
        <div class="wrap-wide footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($nome_cognome) ?></p>
            <nav aria-label="Informazioni legali"><a href="/privacy.php">Privacy e cookie</a><a href="/note-legali.php">Note legali</a></nav>
        </div>
    </footer>

    <script src="/assets/js/main.js" defer></script>
    <?= $page_js ?>
</body>
</html>
