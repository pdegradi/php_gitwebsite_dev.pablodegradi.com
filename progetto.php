<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

$slug = PHP_SAPI === 'cli' && isset($argv[1]) ? $argv[1] : ($_GET['slug'] ?? '');
$article = null;
foreach (get_public_articles($articles, $article_sort_by, $article_sort_order) as $entry) {
    if ($entry['slug'] === $slug) {
        $article = $entry;
        break;
    }
}
if ($article === null || empty($article['file']) || !is_file(__DIR__ . '/' . $article['file'])) {
    http_response_code(404);
    $page_title = 'Progetto non trovato';
    $seo = ['robots' => 'noindex'];
    $content = '<section class="page-hero wrap-wide"><h1>Progetto non trovato</h1><p>Il progetto che cerchi non è disponibile.</p><a class="text-link" href="/blog-progetti.php">Torna ai progetti</a></section>';
    require __DIR__ . '/includes/layout/layout.php';
    return;
}
$page_title = $article['seo_title'] ?? $article['title'];
$seo = [
    'description' => $article['seo_description'] ?? $article['excerpt'] ?? '',
    'canonical' => $site_url . '/progetto.php?slug=' . rawurlencode($slug),
    'og_title' => $article['title'] . ' · ' . $nome_cognome,
    'og_description' => $article['excerpt'] ?? '',
    'og_type' => 'article',
    'og_image' => !empty($article['featured_image']) ? $site_url . $article['featured_image'] : '',
];
if (($article['status'] ?? '') === 'bozza') {
    $seo['robots'] = 'noindex, follow';
}
$youtube_url = trim((string) ($article['youtube_url'] ?? ''));
$youtube_host = strtolower((string) parse_url($youtube_url, PHP_URL_HOST));
if ($youtube_url === '' || !filter_var($youtube_url, FILTER_VALIDATE_URL)
    || strtolower((string) parse_url($youtube_url, PHP_URL_SCHEME)) !== 'https'
    || !in_array($youtube_host, ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtu.be', 'www.youtu.be'], true)) {
    $youtube_url = '';
}
ob_start();
?>
<article class="project-detail">
    <header class="project-hero wrap-wide">
        <p class="eyebrow"><a class="breadcrumb-back" href="/blog-progetti.php">Tutti i progetti</a> / <?= htmlspecialchars($article['category'] ?? 'Progetto') ?></p>
        <?php if (!empty($article['featured_image'])): ?>
            <div class="project-hero__media">
                <img src="<?= htmlspecialchars($article['featured_image'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($article['image_alt'] ?? $article['title'], ENT_QUOTES) ?>" fetchpriority="high">
                <div class="project-hero__title"><h1><?= htmlspecialchars($article['title']) ?></h1></div>
            </div>
        <?php else: ?>
            <h1><?= htmlspecialchars($article['title']) ?></h1>
        <?php endif; ?>
        <?php if (!empty($article['date'])): ?><p class="project-hero__date"><time datetime="<?= htmlspecialchars($article['date'], ENT_QUOTES) ?>">Pubblicato il <?= htmlspecialchars(format_article_date($article['date'])) ?></time></p><?php endif; ?>
        <p class="project-hero__intro"><?= htmlspecialchars($article['excerpt'] ?? '') ?></p>
        <?php if ($youtube_url !== ''): ?><a class="text-link project-hero__video" href="<?= htmlspecialchars($youtube_url, ENT_QUOTES) ?>" target="_blank" rel="noopener noreferrer">Guarda il video su YouTube</a><?php endif; ?>
        <?php if (($article['status'] ?? '') === 'bozza'): ?><p class="draft-note">Contenuto in preparazione.</p><?php endif; ?>
    </header>
    <div class="article-content wrap-content">
        <?php require __DIR__ . '/' . $article['file']; ?>
    </div>
    <?php require_once __DIR__ . '/includes/components/project-gallery.php'; ?>
    <?= render_project_gallery($article) ?>
</article>
<section class="section"><div class="wrap-wide contact-panel"><p class="eyebrow">Hai un’esigenza simile?</p><h2>Possiamo parlarne partendo dal tuo caso.</h2><p>Ogni attività ha un modo diverso di lavorare. Raccontami cosa vorresti semplificare.</p><?= render_email_link($email, 'Contattami', 'button button--primary', 'Una soluzione per la mia attivita') ?></div></section>
<?php
$content = ob_get_clean();
$page_js = '<script src="/assets/js/project-gallery.js" defer></script>';
require __DIR__ . '/includes/layout/layout.php';
