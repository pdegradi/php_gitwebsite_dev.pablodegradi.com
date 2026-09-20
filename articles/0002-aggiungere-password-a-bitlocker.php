<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/../includes/config.php';

[
    'title'          => $article_title,
    'date'           => $article_date,
    'featured_image' => $featured_image
] = get_current_article_data($articles);

ob_start();
?>

<p>Aprire group policies</p>

<div class="code-block">
<pre><code>gpedit.msc</code></pre>
</div>

<p>Navigare dentro</p>

<div class="code-block">
<pre><code>Computer Configuration –> Administrative Templates –> Windows Components –> BitLocker Drive Encryption –> Operating System Drives</code></pre>
</div>

<p>e aprire</p>

<div class="code-block">
<pre><code>Require additional authentication at startup</code></pre>
</div>

<p>settare le seguenti opzioni come da immagini</p>

<img class="zoomable" src="/assets/images/0002/devblog_Kh61AHv1J1.webp" alt=""> 
<img class="zoomable" src="/assets/images/0002/devblog_1ndRcwkHpT.webp" alt=""> 

<p>By default, only numbers can be used as a PIN. If you want to use a real password with 
    letters and other characters, you must activate the option “Allow enhanced PINs for startup”.</p>

<img class="zoomable" src="/assets/images/0002/devblog_pRMIj4fdKB.webp" alt=""> 

<p>Aprire un terminale con diritti di admin e lanciare il seguente comando per settare la password</p>

<div class="code-block">
<pre><code>manage-bde -protectors -add c: -TPMAndPIN</code></pre>
</div>

<p>per controllare lo status lanciare il seguente comando</p>

<div class="code-block">
<pre><code>manage-bde -status</code></pre>
</div>

<?php
$article_body = ob_get_clean();

$seo = [
    'description' => "Come aggiungere una password o PIN a BitLocker su Windows: attivazione delle policy corrette, uso degli enhanced PIN e comandi manage-bde per configurare e verificare la protezione del disco.",
    'og_title'     => "{$article_title} · {$site_name}",
    'og_type'      => 'article',
    'og_image'     => $featured_image,
];

require __DIR__ . '/../includes/layout/layout-article.php';
