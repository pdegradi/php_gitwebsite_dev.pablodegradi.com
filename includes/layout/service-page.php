<?php
if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    exit;
}
$page_title = $service['title'];
$seo = [
    'description' => $service['description'],
    'canonical' => $site_url . '/' . basename($_SERVER['SCRIPT_FILENAME']),
    'og_title' => $service['title'] . ' · ' . $nome_cognome,
    'og_description' => $service['description'],
    'og_type' => 'website',
];
ob_start();
?>
<section class="page-hero wrap-wide">
    <p class="eyebrow"><?= htmlspecialchars($service['eyebrow']) ?></p>
    <h1><?= htmlspecialchars($service['title']) ?><span class="accent-dot">.</span></h1>
    <p class="page-hero__intro"><?= htmlspecialchars($service['intro']) ?></p>
    <?= render_email_link($email, 'Raccontami la tua esigenza', 'text-link', 'Informazioni: ' . $service['title']) ?>
</section>
<div class="wrap-wide service-sections">
    <?php foreach ($service['sections'] as $index => $section): ?>
        <section class="service-detail" aria-labelledby="detail-<?= $index ?>">
            <span class="section-index">0<?= $index + 1 ?></span>
            <div><h2 id="detail-<?= $index ?>"><?= htmlspecialchars($section['title']) ?></h2><p><?= htmlspecialchars($section['text']) ?></p>
                <?php if (!empty($section['items'])): ?><ul class="check-list"><?php foreach ($section['items'] as $item): ?><li><?= htmlspecialchars($item) ?></li><?php endforeach; ?></ul><?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
<section class="section"><div class="wrap-wide contact-panel"><p class="eyebrow">Parliamone</p><h2><?= htmlspecialchars($service['cta_title']) ?></h2><p><?= htmlspecialchars($service['cta_text']) ?></p><?= render_email_link($email, $service['cta_label'], 'button button--primary', 'Informazioni: ' . $service['title']) ?></div></section>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
