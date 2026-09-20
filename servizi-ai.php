<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

ob_start();
?>
<section class="service-page wrap-wide">
    <p class="service-page__eyebrow text-uppercase fw-semibold mb-2">Consulenza e sviluppo AI</p>
    <h1>Integro soluzioni AI nei processi digitali e aziendali.</h1>
    <p class="service-page__lead">
        Aiuto a valutare, progettare e sviluppare strumenti basati su modelli AI per automatizzare flussi,
        analizzare dati, generare contenuti e creare funzionalità realmente utili.
    </p>

    <div class="service-page__grid d-grid grid-cols-1 grid-cols-md-2 gap-4 mt-5">
        <article class="service-card border rounded-lg p-4">
            <h2>Integrazione AI</h2>
            <p>
                Integro LLM come Claude, OpenAI e modelli open source dentro prodotti, workflow e strumenti interni,
                trasformando attività ripetitive in processi più rapidi e controllabili.
            </p>
            <ul>
                <li>Chatbot su misura</li>
                <li>Automazione flussi</li>
                <li>LLM integration</li>
            </ul>
        </article>

        <article class="service-card border rounded-lg p-4">
            <h2>Consulenza tecnica</h2>
            <p>
                Valuto la fattibilità dell'idea, definisco architettura e stack tecnologico e preparo una roadmap
                chiara prima di investire nello sviluppo completo.
            </p>
            <ul>
                <li>Analisi fattibilità</li>
                <li>Stack selection</li>
                <li>Roadmap &amp; costi</li>
            </ul>
        </article>
    </div>
</section>

<section class="service-process wrap-wide" style="margin-top:6rem;">
    <h2>Quando può essere utile</h2>
    <div class="d-grid grid-cols-1 grid-cols-md-2 gap-3">
        <div class="service-step p-3 rounded border">
            <strong>Automatizzare attività ripetitive</strong>
            <p>Riduci passaggi manuali e rendi più veloci processi già esistenti.</p>
        </div>
        <div class="service-step p-3 rounded border">
            <strong>Analizzare informazioni</strong>
            <p>Estrai sintesi, classificazioni o insight da testi, documenti e dati aziendali.</p>
        </div>
        <div class="service-step p-3 rounded border">
            <strong>Creare assistenti interni</strong>
            <p>Costruisci chatbot e strumenti su misura collegati alle tue fonti operative.</p>
        </div>
        <div class="service-step p-3 rounded border">
            <strong>Validare un'idea</strong>
            <p>Capisci cosa è realizzabile, con quali limiti tecnici e con quali costi.</p>
        </div>
    </div>
</section>

<p class="wrap-wide mt-5">
    <a class="btn btn-primary" href="mailto:<?php echo $email; ?>">Contattami</a>
    <a class="btn btn-outline-secondary ms-2" href="/servizi-web.php">Scopri i servizi web</a>
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

$page_title = 'Servizi AI';

$seo = [
    'description' => 'Servizi di consulenza e sviluppo soluzioni AI: integrazione LLM, automazioni, chatbot e roadmap tecnica.',
    'og_title'     => 'Servizi AI · ' . $site_name,
    'og_type'      => 'website',
];

require __DIR__ . '/includes/layout/layout.php';
