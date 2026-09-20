<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$frontpage_articles = array_values(array_filter(
    get_public_articles($articles, $article_sort_by, $article_sort_order),
    static fn (array $article): bool => ($article['sn_frontpage'] ?? 'n') === 's'
));
$page_title = 'Sviluppatore web freelance per professionisti e piccole imprese';
$seo = [
    'description' => 'Realizzo web app su misura, siti web, automazioni e integrazioni AI per professionisti e piccole imprese. Partiamo dalla tua esigenza concreta.',
    'canonical' => $site_url . '/',
    'og_title' => 'Soluzioni web su misura per la tua attività · ' . $nome_cognome,
    'og_type' => 'website',
    'og_image' => $site_url . '/assets/images/pablo2.webp',
];
ob_start();
?>
<section class="hero wrap-wide" aria-labelledby="home-title">
    <div class="hero__copy">
        <p class="eyebrow">Sviluppatore web freelance</p>
        <h1 id="home-title">Soluzioni web su misura per la tua attività<span class="accent-dot">.</span></h1>
        <p class="hero__lead">Realizzo web app custom, siti web, automazioni e integrazioni AI per professionisti e piccole imprese.</p>
        <p class="text-muted">Parto da un’esigenza concreta e la trasformo in uno strumento semplice, utile e adatto al modo in cui lavori.</p>
        <div class="button-row">
            <?= render_email_link($email, 'Parliamo del tuo progetto', 'button button--primary', 'Parliamo del tuo progetto') ?>
            <a class="button button--text" href="/blog-progetti.php">Scopri i progetti</a>
        </div>
    </div>
    <div class="hero__portrait">
        <img src="/assets/images/pablo2.webp" alt="<?= htmlspecialchars($nome_cognome) ?>, sviluppatore web freelance" fetchpriority="high">
    </div>
</section>

<section class="section section--border" aria-labelledby="servizi-title"><div class="wrap-wide">
    <div class="section-heading"><p class="eyebrow">Cosa posso fare per te</p><h2 id="servizi-title">Il servizio giusto parte dal problema da risolvere.</h2><p>Un sito per farti trovare, uno strumento per lavorare meglio o un confronto per scegliere da dove iniziare.</p></div>
    <div class="service-grid">
        <a class="service-card" href="/servizi-web-app-custom.php">
            <div class="service-card__top"><span class="card-number">01</span><svg class="service-card__icon bi bi-app-indicator" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><path d="M5.5 2A3.5 3.5 0 0 0 2 5.5v5A3.5 3.5 0 0 0 5.5 14h5a3.5 3.5 0 0 0 3.5-3.5V8a.5.5 0 0 1 1 0v2.5a4.5 4.5 0 0 1-4.5 4.5h-5A4.5 4.5 0 0 1 1 10.5v-5A4.5 4.5 0 0 1 5.5 1H8a.5.5 0 0 1 0 1z"/><path d="M16 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/></svg></div>
            <h3>Web App Custom</h3><p>Applicazioni web su misura per gestire processi, dati e attività che gli strumenti standard non coprono bene.</p><span class="card-link">Scopri il servizio</span>
        </a>
        <a class="service-card" href="/servizi-siti-web.php">
            <div class="service-card__top"><span class="card-number">02</span><svg class="service-card__icon bi bi-window" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><path d="M2.5 4a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1 .5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/><path d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm13 2v2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1M2 14a1 1 0 0 1-1-1V6h14v7a1 1 0 0 1-1 1z"/></svg></div>
            <h3>Siti Web</h3><p>Siti professionali e siti vetrina chiari, veloci e pensati per presentare bene la tua attività online.</p><span class="card-link">Scopri il servizio</span>
        </a>
        <a class="service-card" href="/servizi-automazioni-ai.php">
            <div class="service-card__top"><span class="card-number">03</span><svg class="service-card__icon bi bi-diagram-3" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/></svg></div>
            <h3>Automazioni e AI</h3><p>Automazioni e integrazioni AI per ridurre attività ripetitive e migliorare la gestione di alcuni processi.</p><span class="card-link">Scopri il servizio</span>
        </a>
        <a class="service-card" href="/servizi-consulenza-formazione.php">
            <div class="service-card__top"><span class="card-number">04</span><svg class="service-card__icon bi bi-book" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/></svg></div>
            <h3>Consulenza e Formazione</h3><p>Consulenza per valutare la fattibilità di un progetto e scegliere gli strumenti adatti; formazione pratica su sviluppo web e AI.</p><span class="card-link">Scopri il servizio</span>
        </a>
    </div>
</div></section>

<section class="section" aria-labelledby="problemi-title"><div class="wrap-wide split-section">
    <div><p class="eyebrow">Da dove iniziamo</p><h2 id="problemi-title">Riconosci uno di questi problemi?</h2><p class="text-muted">Non serve avere già una soluzione in mente. Possiamo partire da quello che oggi ti fa perdere tempo o rende più difficile il lavoro.</p></div>
    <ul class="problem-list">
        <li>Processi gestiti ancora a mano o attività che si ripetono ogni giorno</li>
        <li>Fogli Excel diventati difficili da mantenere</li>
        <li>Informazioni sparse tra strumenti che non comunicano</li>
        <li>Un’applicazione specifica che non trovi già pronta</li>
        <li>Un sito vecchio che non spiega bene cosa fai</li>
        <li>Un flusso in cui un’automazione o l’AI potrebbe essere utile</li>
    </ul>
</div></section>

<?php if ($frontpage_articles !== []): ?>
<section class="section section--border" aria-labelledby="progetti-title"><div class="wrap-wide">
    <div class="section-heading section-heading--row"><div><p class="eyebrow">Progetti</p><h2 id="progetti-title">Progetti realizzati</h2><p>Racconto le applicazioni che realizzo, i problemi da cui nascono e le scelte fatte per risolverli.</p></div><a class="text-link" href="/blog-progetti.php">Tutti i progetti</a></div>
    <?= render_project_cards($frontpage_articles) ?>
</div></section>
<?php endif; ?>

<section class="section" aria-labelledby="about-title"><div class="wrap-wide about-strip"><div><p class="eyebrow">Chi sono</p><h2 id="about-title">Un professionista con cui parlare direttamente.</h2></div><div><p>Sono <?= htmlspecialchars($nome_cognome) ?>, sviluppatore web freelance. Da circa 20 anni lavoro su applicazioni e soluzioni web. Oggi aiuto soprattutto professionisti e piccole attività a costruire strumenti adatti alle loro esigenze.</p><a class="text-link" href="/chi-sono.php">Qualche parola su di me</a></div></div></section>

<section class="section section--border"><div class="wrap-wide contact-panel"><p class="eyebrow">Facciamo il primo passo</p><h2>Hai un’esigenza che gli strumenti standard non risolvono?</h2><p>Possiamo partire dal problema e capire insieme se serve una web app custom, un sito, un’automazione o un altro tipo di soluzione.</p><?= render_email_link($email, 'Contattami', 'button button--primary', 'Vorrei parlarti di un progetto') ?></div></section>
<?php
$content = ob_get_clean();
require __DIR__ . '/includes/layout/layout.php';
