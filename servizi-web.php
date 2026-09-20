<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

ob_start();
?>
<section class="service-page wrap-wide">
    <p class="service-page__eyebrow text-uppercase fw-semibold mb-2">Servizi web custom</p>
    <h1>Sviluppo applicazioni web su misura</h1>
    <p class="service-page__lead">
        Progetto e sviluppo soluzioni web pensate per obiettivi concreti: presenza online, gestione dei contenuti,
        strumenti interni e piattaforme scalabili accessibili da browser.
    </p>

    <div class="service-page__grid d-grid grid-cols-1 grid-cols-md-2 gap-4 mt-5">
        <article class="service-card border rounded-lg p-4">
            <h2>Siti web vetrina</h2>
            <p>
                Siti rapidi, curati nel design e orientati alla conversione, costruiti con un approccio mobile-first
                e attenzione a SEO, performance e gestione autonoma dei contenuti.
            </p>
            <ul>
                <li>Design custom</li>
                <li>SEO &amp; performance</li>
                <li>CMS integrato</li>
            </ul>
        </article>

        <article class="service-card border rounded-lg p-4">
            <h2>Web app &amp; SaaS</h2>
            <p>
                Applicazioni web scalabili per gestionali interni, dashboard operative e piattaforme SaaS,
                con architettura definita per crescere senza dover ripartire da zero.
            </p>
            <ul>
                <li>Architettura scalabile</li>
                <li>UI/UX funzionale</li>
                <li>API REST</li>
            </ul>
        </article>
    </div>
</section>

<section class="service-process wrap-wide" style="margin-top:6rem;">
    <h2 class=>Metodo di lavoro</h2>
    <div class="d-grid grid-cols-1 grid-cols-md-2 gap-3">
        <div class="service-step p-3 rounded border">
            <strong>Analisi</strong>
            <p>Obiettivi, vincoli, utenti e priorità vengono chiariti prima dello sviluppo.</p>
        </div>
        <div class="service-step p-3 rounded border">
            <strong>Architettura</strong>
            <p>Definisco tecnologie, tempi, costi e struttura tecnica della soluzione.</p>
        </div>
        <div class="service-step p-3 rounded border">
            <strong>Sviluppo iterativo</strong>
            <p>Procedo per step verificabili, con feedback continui e rilasci progressivi.</p>
        </div>
        <div class="service-step p-3 rounded border">
            <strong>Consegna</strong>
            <p>Deploy, documentazione essenziale e supporto post-lancio completano il lavoro.</p>
        </div>
    </div>
</section>

<p class="wrap-wide mt-5">
    <a class="btn btn-primary" href="mailto:<?php echo $email; ?>">Contattami</a>
    <a class="btn btn-outline-secondary ms-2" href="/servizi-ai.php">Scopri i servizi AI</a>
</p>

<?php
$content = ob_get_clean();

ob_start();
?>
<style>
    .service-page__eyebrow {color: var(--accent);font-size: 0.85rem;letter-spacing: 0.12em;}
    .service-page__lead {color: var(--text-muted);font-size: 1.35rem;}
    .service-card,.service-step {background: var(--bg-elevated);}
    h2 {margin-top: 0;border-top: 0;padding-top: 0;}
    .service-card ul {margin-bottom: 0;}
    .service-step p {margin: 0.35rem 0 0;color: var(--text-muted);font-size: 1rem;}

    @media (width < 576px) {
        .service-page .btn {
            display: block;
            width: 100%;
            margin-left: 0 !important;
            margin-top: 0.75rem;
        }
    }
</style>
<?php
$page_css = ob_get_clean();

$page_title = 'Servizi web custom';

$seo = [
    'description' => 'Servizi di sviluppo web custom: siti vetrina, web app, SaaS, API e piattaforme su misura.',
    'og_title'     => 'Servizi web custom · ' . $site_name,
    'og_type'      => 'website',
];

require __DIR__ . '/includes/layout/layout.php';
