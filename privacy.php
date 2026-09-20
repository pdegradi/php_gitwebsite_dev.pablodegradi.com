<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$page_title = 'Privacy e cookie';
$seo = ['description' => 'Informazioni sul trattamento dei dati e sull’uso dei cookie di questo sito.', 'canonical' => $site_url . '/privacy.php', 'robots' => 'noindex, follow'];
ob_start();
?>
<section class="page-hero wrap-wide"><p class="eyebrow">Informazioni sul sito</p><h1>Privacy e cookie<span class="accent-dot">.</span></h1><p class="page-hero__intro">Questa pagina descrive come vengono trattati i dati quando visiti il sito o mi scrivi.</p></section>
<div class="legal-content wrap-content">
    <h2>Titolare e contatto</h2><p>Il titolare del trattamento è <?= htmlspecialchars($nome_cognome) ?>, con sede in <?= htmlspecialchars($business_address) ?>. Per richieste sui tuoi dati puoi scrivere a <?= render_email_link($email) ?>.</p>
    <h2>Dati che puoi inviarmi</h2><p>Se mi contatti via email, ricevo l’indirizzo del mittente e le informazioni che scegli di includere nel messaggio. Li uso per rispondere alla richiesta e, se necessario, per seguire il rapporto professionale. La base giuridica è la gestione della tua richiesta e delle eventuali attività precontrattuali o contrattuali.</p>
    <h2>Navigazione e log tecnici</h2><p>Questo sito è pubblicato come pagine statiche su <?= htmlspecialchars($hosting_provider) ?> e non gestisce log propri degli accessi. GitHub Pages registra e conserva l’indirizzo IP dei visitatori per finalità di sicurezza. Per le modalità e i criteri di conservazione applicati da GitHub, consulta la sua <a href="https://docs.github.com/en/site-policy/privacy-policies/github-general-privacy-statement" rel="noopener noreferrer">informativa sulla privacy</a>.</p>
    <h2>Cookie e strumenti di tracciamento</h2><p>Il codice di questo sito non imposta cookie di profilazione, non usa strumenti di analisi delle visite e non carica contenuti esterni incorporati. Non è previsto un banner di consenso. L’eventuale presenza di cookie tecnici dipende dall’infrastruttura usata per pubblicare il sito.</p>
    <h2>Conservazione e destinatari</h2><p>Conservo i messaggi per il tempo necessario a rispondere e a chiudere la richiesta. Se nasce un rapporto professionale, li conservo per la durata del rapporto e successivamente solo quando necessario per obblighi di legge o per la tutela dei miei diritti. Le caselle email sono gestite tramite cPanel presso il fornitore del servizio di posta<?php if ($email_provider !== ''): ?> (<?= htmlspecialchars($email_provider) ?>)<?php endif; ?>. I dati tecnici di navigazione possono essere trattati da <?= htmlspecialchars($hosting_provider) ?>. I dati non vengono venduti.</p>
    <h2>I tuoi diritti</h2><p>Puoi chiedere accesso, rettifica, cancellazione o limitazione del trattamento, e opporti quando previsto dalla legge. Per esercitare i tuoi diritti scrivi a <?= render_email_link($email) ?>. Puoi anche presentare reclamo al Garante per la protezione dei dati personali.</p>
    <p class="legal-updated">Ultimo aggiornamento: 20 settembre 2026.</p>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/includes/layout/layout.php';
