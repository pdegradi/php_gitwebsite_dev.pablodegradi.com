<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$page_title = 'Chi sono';
$seo = [
    'description' => 'Sono ' . $nome_cognome . ', sviluppatore web freelance con circa 20 anni di esperienza. Realizzo web app, siti e automazioni per professionisti e piccole attività.',
    'canonical' => $site_url . '/chi-sono.php',
    'og_title' => 'Chi sono · ' . $nome_cognome,
    'og_type' => 'profile',
    'og_image' => $site_url . '/assets/images/pablo2.webp',
];
ob_start();
?>
<section class="page-hero page-hero--about wrap-wide">
    <div><p class="eyebrow">Un po’ di contesto</p><h1>Chi sono<span class="accent-dot">.</span></h1><p class="page-hero__intro">Sono <?= htmlspecialchars($nome_cognome) ?>, uno sviluppatore web freelance con circa 20 anni di esperienza.</p><p>Nel corso degli anni ho lavorato principalmente nello sviluppo di applicazioni e soluzioni web, seguendo l’evoluzione degli strumenti utilizzati per costruirle.</p><p>Oggi mi occupo soprattutto di web app custom, siti web, automazioni e integrazioni AI.</p></div>
    <div class="about-portrait"><img src="/assets/images/pablo2.webp" alt="<?= htmlspecialchars($nome_cognome) ?>, sviluppatore web freelance" loading="lazy"></div>
</section>
<section class="section section--border"><div class="wrap-wide split-section"><div><p class="eyebrow">Il mio approccio</p><h2>Prima il problema, poi gli strumenti.</h2></div><div><p>Il mio approccio è pragmatico: cerco di capire il problema, poi scelgo gli strumenti necessari per risolverlo.</p><p>Mi rivolgo principalmente a professionisti, piccoli imprenditori e attività che hanno bisogno di una soluzione concreta, senza complicazioni inutili.</p></div></div></section>
<section class="section"><div class="wrap-wide contact-panel"><p class="eyebrow">Lavoriamo insieme</p><h2>Raccontami la tua esigenza.</h2><p>Puoi scrivermi anche se non hai ancora un progetto definito. Partiamo da ciò che vorresti migliorare.</p><?= render_email_link($email, 'Scrivimi', 'button button--primary', "Vorrei raccontarti un'esigenza") ?></div></section>
<?php
$content = ob_get_clean();
require __DIR__ . '/includes/layout/layout.php';
