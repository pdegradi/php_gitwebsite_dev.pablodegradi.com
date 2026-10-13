<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$page_title = 'Privacy e cookie';
$seo = ['description' => 'Informazioni sul trattamento dei dati, sul modulo Google e sull’uso dei cookie di questo sito.', 'canonical' => $site_url . '/privacy.php', 'robots' => 'noindex, follow'];
ob_start();
?>
<section class="page-hero wrap-wide"><p class="eyebrow">Informazioni sul sito</p><h1>Privacy e cookie<span class="accent-dot">.</span></h1><p class="page-hero__intro">Questa pagina descrive come vengono trattati i dati quando visiti il sito, compili il modulo di contatto o mi scrivi.</p></section>
<div class="legal-content wrap-content">
    <h2>Titolare e contatto</h2>
    <p>Il titolare del trattamento è <?= htmlspecialchars($nome_cognome) ?>, con sede in <?= htmlspecialchars($business_address) ?>. Per richieste sui tuoi dati puoi scrivere a <?= render_email_link($email) ?>.</p>

    <h2>Modulo di contatto Google</h2>
    <p>Il sito contiene un collegamento esterno a un modulo ospitato su Google Forms; il modulo non è incorporato nelle pagine del sito. Se scegli di compilarlo, vengono raccolti:</p>
    <ul>
        <li>nome e indirizzo email;</li>
        <li>attività svolta e numero di persone che lavorano con te;</li>
        <li>tipo di aiuto richiesto;</li>
        <li>esigenza o problema che vuoi affrontare;</li>
        <li>come hai conosciuto il sito.</li>
    </ul>
    <p>I dati servono esclusivamente a leggere la richiesta, risponderti, comprenderne il contesto e valutare un eventuale seguito professionale. La base giuridica è l’esecuzione di misure precontrattuali adottate su tua richiesta. Il conferimento è facoltativo, ma i campi indicati come obbligatori sono necessari per inviare il modulo. Non inserire password, dati particolari o informazioni riservate dei tuoi clienti.</p>

    <h2>Google come fornitore</h2>
    <p>Google fornisce il servizio Google Forms. Quando apri o invii il modulo, i dati inseriti e i dati tecnici necessari al funzionamento del servizio, come indirizzo IP, tipo di browser, dispositivo, data e ora della richiesta, vengono trasmessi a Google. Le risposte sono rese disponibili al titolare tramite i servizi Google. Google può trattare dati anche su server situati fuori dallo Spazio economico europeo, applicando le garanzie descritte nella propria <a href="https://policies.google.com/privacy?hl=it" target="_blank" rel="noopener noreferrer">informativa sulla privacy</a>.</p>

    <h2>Conservazione dei dati di contatto</h2>
    <p>Le richieste ricevute tramite modulo o email che non portano a un rapporto professionale vengono conservate per un massimo di <?= htmlspecialchars($contact_request_retention) ?> e poi cancellate dagli strumenti sotto il mio controllo. Se nasce un rapporto professionale, conservo le informazioni necessarie per gestirlo e, successivamente, per adempiere agli obblighi di legge o tutelare i miei diritti. Google può conservare copie residue per i tempi tecnici e secondo i criteri descritti nella propria informativa.</p>

    <h2>Contatti via email</h2>
    <p>Se mi scrivi via email, ricevo l’indirizzo del mittente e le informazioni contenute nel messaggio. Le caselle email sono gestite tramite cPanel presso il fornitore del servizio di posta<?php if ($email_provider !== ''): ?> (<?= htmlspecialchars($email_provider) ?>)<?php endif; ?>. I dati vengono usati per rispondere e gestire l’eventuale rapporto professionale, con gli stessi criteri di conservazione indicati sopra.</p>

    <h2>Navigazione e log tecnici</h2>
    <p>Questo sito è pubblicato come pagine statiche su <?= htmlspecialchars($hosting_provider) ?> e non gestisce log propri degli accessi. GitHub Pages registra e conserva l’indirizzo IP dei visitatori per finalità di sicurezza. Per le modalità e i criteri di conservazione applicati da GitHub, consulta la sua <a href="https://docs.github.com/en/site-policy/privacy-policies/github-general-privacy-statement" target="_blank" rel="noopener noreferrer">informativa sulla privacy</a>.</p>

    <h2>Cookie e strumenti di tracciamento</h2>
    <p>Il codice di questo sito non imposta cookie di profilazione e non usa strumenti di analisi delle visite. Alcuni articoli mostrano un’anteprima locale dei video YouTube: il lettore esterno viene caricato solo quando scegli di riprodurre il video. Da quel momento il browser si collega a YouTube, che può trattare dati tecnici e usare cookie secondo la propria <a href="https://policies.google.com/privacy?hl=it" target="_blank" rel="noopener noreferrer">informativa sulla privacy</a>. L’eventuale presenza di cookie tecnici dipende anche dall’infrastruttura usata per pubblicare il sito.</p>

    <h2>Destinatari e diritti</h2>
    <p>I dati possono essere trattati dai fornitori tecnici necessari a erogare i servizi descritti, in particolare Google per il modulo, il fornitore della posta elettronica e <?= htmlspecialchars($hosting_provider) ?> per i dati tecnici di navigazione. I dati non vengono venduti né usati per finalità di marketing.</p>
    <p>Puoi chiedere accesso, rettifica, cancellazione o limitazione del trattamento, e opporti quando previsto dalla legge. Per esercitare i tuoi diritti scrivi a <?= render_email_link($email) ?>. Puoi anche presentare reclamo al Garante per la protezione dei dati personali.</p>

    <p class="legal-updated">Ultimo aggiornamento: 13 ottobre 2026.</p>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/includes/layout/layout.php';
