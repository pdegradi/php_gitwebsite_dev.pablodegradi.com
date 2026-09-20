<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
$page_title = 'Note legali';
$seo = ['description' => 'Informazioni legali e condizioni d’uso del sito di ' . $nome_cognome . '.', 'canonical' => $site_url . '/note-legali.php', 'robots' => 'noindex, follow'];
ob_start();
?>
<section class="page-hero wrap-wide"><p class="eyebrow">Informazioni sul sito</p><h1>Note legali<span class="accent-dot">.</span></h1><p class="page-hero__intro">Contenuti e modalità di contatto di questo sito professionale.</p></section>
<div class="legal-content wrap-content">
    <h2>Responsabile del sito</h2><p><?= htmlspecialchars($nome_cognome) ?><?php if ($vat_number !== ''): ?> · P. IVA <?= htmlspecialchars($vat_number) ?><?php endif; ?><?php if ($business_address !== ''): ?> · <?= htmlspecialchars($business_address) ?><?php endif; ?> · <?= render_email_link($email) ?>.</p>
    <h2>Contenuti</h2><p>I testi e le immagini del sito sono pubblicati a scopo informativo. Gli articoli sui progetti descrivono le applicazioni realizzate e mostrano schermate esemplificative del loro funzionamento.</p>
    <h2>Collegamenti esterni</h2><p>Gli eventuali link a siti esterni rimandano a contenuti gestiti dai rispettivi titolari.</p>
    <h2>Contatti</h2><p>Per informazioni sui servizi o sui contenuti, scrivi a <?= render_email_link($email) ?>.</p>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/includes/layout/layout.php';
