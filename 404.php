<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

ob_start();
?>
<section class="page-hero wrap-content">
    <h1>Pagina non trovata</h1>
    <p>La pagina che cercavi non esiste o è stata spostata.</p>
    <p><a class="button button--primary" href="/index.php">Torna alla home</a></p>
</section>
<?php
$content = ob_get_clean();

$page_title = "Pagina non trovata";
$seo = ['robots' => 'noindex, follow'];

require __DIR__ . '/includes/layout/layout.php';
