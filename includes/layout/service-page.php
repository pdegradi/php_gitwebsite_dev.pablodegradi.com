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
    <?= render_google_form_link($google_form_url, 'Contattami', 'text-link') ?>
</section>
<div class="wrap-wide service-sections">
    <?php foreach ($service['sections'] as $index => $section): ?>
        <section class="service-detail" aria-labelledby="detail-<?= $index ?>">
            <span class="section-index"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <div><h2 id="detail-<?= $index ?>"><?= htmlspecialchars($section['title']) ?></h2><p><?= htmlspecialchars($section['text']) ?></p>
                <?php if (!empty($section['items'])): ?><ul class="check-list"><?php foreach ($section['items'] as $item): ?><li><?= htmlspecialchars($item) ?></li><?php endforeach; ?></ul><?php endif; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>
<?php if (!empty($service['projects_title'])): ?>
<section class="section section--border"><div class="wrap-wide split-section">
    <div><p class="eyebrow">Esempi</p><h2><?= htmlspecialchars($service['projects_title']) ?></h2></div>
    <div><p class="text-muted"><?= htmlspecialchars($service['projects_text']) ?></p><a class="text-link" href="/blog-progetti.php">Scopri i prototipi</a></div>
</div></section>
<?php endif; ?>
<?php if (!empty($service['faqs'])): ?>
<section class="section service-faq" aria-labelledby="service-faq-title"><div class="wrap-wide">
    <div class="section-heading"><p class="eyebrow">Domande frequenti</p><h2 id="service-faq-title">Dubbi comuni prima di iniziare.</h2></div>
    <div class="faq-list">
        <?php foreach ($service['faqs'] as $faq): ?>
        <details><summary><?= htmlspecialchars($faq['question']) ?></summary><p><?= htmlspecialchars($faq['answer']) ?></p></details>
        <?php endforeach; ?>
    </div>
</div></section>
<?php endif; ?>
<section class="section"><div class="wrap-wide contact-panel"><p class="eyebrow">Parliamone</p><h2><?= htmlspecialchars($service['cta_title']) ?></h2><p><?= htmlspecialchars($service['cta_text']) ?></p><?= render_contact_actions($google_form_url, $email, 'Compila il modulo', 'Scrivimi via email', 'Informazioni: ' . $service['title']) ?></div></section>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';