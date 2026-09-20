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
            <div>
                <h2>Contatti</h2>
                <?= render_email_link($email) ?>
                <?php if ($linkedin_url !== '' || $youtube_channel_url !== ''): ?>
                <nav class="footer-social" aria-label="Canali social">
                    <?php if ($linkedin_url !== ''): ?>
                    <a href="<?= htmlspecialchars($linkedin_url, ENT_QUOTES, 'UTF-8') ?>" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.211c.837 0 1.358-.554 1.358-1.248-.015-.71-.521-1.248-1.342-1.248S2.4 3.225 2.4 3.935c0 .694.521 1.248 1.327 1.248zm9.65 8.211V9.359c0-2.161-1.153-3.165-2.69-3.165-1.24 0-1.796.682-2.105 1.16v-1.01H6.197c.032.67 0 7.05 0 7.05h2.401V9.457c0-.211.016-.422.077-.573.169-.422.553-.86 1.2-.86.845 0 1.183.649 1.183 1.6v3.77z"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php if ($youtube_channel_url !== ''): ?>
                    <a href="<?= htmlspecialchars($youtube_channel_url, ENT_QUOTES, 'UTF-8') ?>" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M8.051 1.999h-.102c-.969 0-4.329.029-5.694.396-.69.185-1.232.726-1.416 1.416C.472 5.177.443 8 .443 8s.029 2.823.396 4.189c.184.69.726 1.231 1.416 1.416 1.365.367 4.725.396 5.694.396h.102c.969 0 4.329-.029 5.694-.396a2.01 2.01 0 0 0 1.416-1.416c.367-1.366.396-4.189.396-4.189s-.029-2.823-.396-4.189a2.01 2.01 0 0 0-1.416-1.416C12.38 2.028 9.02 2 8.051 1.999M6.4 10.8V5.2L10.8 8z"/></svg>
                    </a>
                    <?php endif; ?>
                </nav>
                <?php endif; ?>
                <p>Hai un’idea o un processo da semplificare? Scrivimi.</p>
            </div>
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
