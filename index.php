<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

ob_start();
?>
<section class="hero wrap-wide d-grid grid-cols-1 grid-cols-md-2 align-items-center gap-5">
    <div class="hero__image-wrap">
        <img class="hero__image" src="/assets/images/pablo1.webp" alt="Pablo Dev">
    </div>

    <div class="hero__content">
        <p class="hero__eyebrow text-uppercase fw-semibold mb-2">Sviluppo Web &amp; AI Integration</p>
        <h1>Soluzioni web e integrazioni AI per far crescere progetti digitali.</h1>
        <p class="hero__text mb-4">
            Realizzo siti, web app e strumenti digitali pensati per essere chiari, scalabili e orientati al risultato.
            Integro anche modelli AI nei processi aziendali per automatizzare attività, analizzare dati e creare nuove funzionalità.
        </p>

        <nav class="hero__links d-flex flex-column flex-sm-row gap-3" aria-label="Link principali">
            <a class="btn btn-primary" href="/servizi-web.php">Pagina Servizi</a>
            <!-- <a class="btn btn-primary" href="/servizi-ai.php">Soluzioni AI</a> -->
            <!-- <a class="btn btn-outline-secondary" href="/blog.php">Blog</a> -->
        </nav>
    </div>
</section>
<?php
$content = ob_get_clean();

ob_start();
?>
<style>
    .hero {
        min-height: calc(100dvh - 180px);
        padding-top: 2rem;
        padding-bottom: 3rem;
    }

    .hero__image-wrap {
        max-width: 460px;
        margin: 0 auto;
        border: 1px solid var(--border);
        border-radius: 22px;
        background: linear-gradient(145deg, var(--bg-elevated), var(--bg));
        overflow: hidden;
    }

    .hero__image {
        display: block;
        width: 100%;
        aspect-ratio: 4 / 5;
        object-fit: cover;
    }

    .hero__eyebrow {
        color: var(--accent);
        font-size: 0.85rem;
        letter-spacing: 0.12em;
    }

    .hero__text {
        color: var(--text-muted);
        max-width: 620px;
    }

    .hero__links .btn {
        white-space: nowrap;
    }

    @media (width < 768px) {
        .hero {
            min-height: auto;
            text-align: center;
        }

        .hero__image-wrap {
            max-width: 320px;
        }

        .hero__text {
            margin-left: auto;
            margin-right: auto;
        }

        .hero__links {
            align-items: stretch;
        }
    }
</style>
<?php
$page_css = ob_get_clean();

$page_title = $site_name;

$seo = [
    'description' => $site_description,
    'og_title'     => $site_name,
    'og_type'      => 'website',
    'og_image'     => '/assets/images/og-cover.svg',
];

require __DIR__ . '/includes/layout/layout.php';
