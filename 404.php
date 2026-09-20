<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

ob_start();
?>
<section class="wrap-content">
    <h1>Pagina non trovata</h1>
    <p>La pagina che cercavi non esiste o è stata spostata.</p>
    <p><a class="button" href="/index.php">Torna alla home &rarr;</a></p>
</section>
<?php
$content = ob_get_clean();

$page_title = "Pagina non trovata";

require __DIR__ . '/includes/layout/layout.php';