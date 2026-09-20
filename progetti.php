<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

$projects = [
    [
        'title' => 'ZAMPGUI',
        'url' => 'https://zampgui.pubcloud.net/',
        'image' => '/assets/images/zampgui_screen.webp',
        'alt' => 'Screenshot di ZAMPGUI',
        'tagline' => 'Apache PHP e MariaDB per Windows 11',
        'description' => 'Ambiente di sviluppo portabile per Windows con Apache, PHP e MariaDB, completo di phpMyAdmin, Xdebug, Git, Node.js, Dart Sass e WP-CLI.',
    ],
    [
        'title' => 'ZampLite',
        'url' => 'https://zamplite.pubcloud.net/',
        'image' => '/assets/images/zamplite_screen.webp',
        'alt' => 'Screenshot di ZampLite',
        'tagline' => 'Portable WAMP Manager per Windows',
        'description' => 'Manager WAMP portabile per gestire server PHP e MariaDB locali tramite interfaccia grafica, senza installazioni globali o servizi di sistema.',
    ],
    [
        'title' => 'PixoGUI',
        'url' => 'https://sourceforge.net/projects/pixogui/',
        'image' => '/assets/images/pixogui_screen.jpg',
        'alt' => 'Screenshot di PixoGUI',
        'tagline' => 'Image Converter per Windows 11',
        'description' => 'Utility per convertire immagini in diversi formati, tra cui JPEG/JPG, PNG, WebP, AVIF, GIF, TIFF e ICO.',
    ],
    [
        'title' => 'Pagine Html Utility',
        'url' => 'https://html.pubcloud.net/',
        'image' => '/assets/images/pagine_html.webp',
        'alt' => 'Screenshot di Pagine Html Utility',
        'tagline' => 'Utilità generiche',
        'description' => 'Raccolta di pagine HTML utili per comprimere CSS, formattare stringhe SQL, generare stringhe casuali e sostituire entità.',
    ],
];

ob_start();
?>
<section class="projects-page wrap-wide">
    <!-- <p class="projects-page__eyebrow text-uppercase fw-semibold mb-2">Progetti</p> -->
    <h1>Progetti</h1>
    <p class="projects-page__lead">Casi Studio e Soluzioni Software</p>

    <div class="projects-list mt-5">
        <?php foreach ($projects as $project): ?>
            <article class="project-card">
                <a class="project-card__image-link" href="<?= htmlspecialchars($project['url']) ?>" target="_blank" rel="noopener noreferrer">
                    <img class="project-card__image" src="<?= htmlspecialchars($project['image']) ?>" alt="<?= htmlspecialchars($project['alt']) ?>" loading="lazy">
                </a>
                <h3>
                    <a href="<?= htmlspecialchars($project['url']) ?>" target="_blank" rel="noopener noreferrer">
                        <?= htmlspecialchars($project['title']) ?>
                    </a>
                </h3>
                <p class="project-card__tagline"><?= htmlspecialchars($project['tagline']) ?></p>
                <hr>
                <p><?= htmlspecialchars($project['description']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php
$content = ob_get_clean();

ob_start();
?>
<style>
    /* .projects-page__eyebrow {color: var(--accent);font-size: 0.85rem;letter-spacing: 0.12em;} */

    .projects-page__lead {color: var(--text-muted);font-size: 1.35rem;}
    .projects-list {display: grid;gap:2rem;grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));}
    .project-card {padding:1rem;background:hsl(0, 0%, 12%);}
    .project-card:last-child {padding-bottom: 0;border-bottom: 0;}
    .project-card__image-link {display: block;}
    .project-card__image-link:hover,.project-card__image-link:focus-visible {text-decoration: none;}
    .project-card__image {display: block;height:220px;width:auto;border: 1px solid var(--border);margin-inline:auto;}
    .project-card h3 {margin-top: 1.4rem;border-top: 0;padding-top: 0;text-align:center;}
    .project-card__tagline {color: var(--text-muted);font-size: 1.1rem;margin-top: -0.35rem;}
    .project-card hr {border: 0;border-top: 1px solid var(--border);margin: 1.25rem 0;}
</style>
<?php
$page_css = ob_get_clean();

$page_title = 'Progetti';

$seo = [
    'description' => 'Progetti software creati: ZAMPGUI, ZampLite, PixoGUI e Pagine Html Utility.',
    'og_title' => 'Progetti · ' . $site_name,
    'og_type' => 'website',
];

require __DIR__ . '/includes/layout/layout.php';
