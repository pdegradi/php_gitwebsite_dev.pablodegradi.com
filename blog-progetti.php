<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';

$public_articles = get_public_articles($articles, $article_sort_by, $article_sort_order);
$page = PHP_SAPI === 'cli' && isset($argv[1]) ? (int) $argv[1] : (int) ($_GET['page'] ?? 1);
$total_pages = max(1, (int) ceil(count($public_articles) / $blog_page_size));
$page = max(1, min($page, $total_pages));
$page_articles = array_slice($public_articles, ($page - 1) * $blog_page_size, $blog_page_size);
$page_title = $page > 1 ? 'Progetti · pagina ' . $page : 'Progetti';
$seo = [
    'description' => 'Progetti realizzati: applicazioni web su misura e soluzioni digitali per professionisti e piccole attività.',
    'canonical' => $site_url . ($page > 1 ? '/blog-progetti.php?page=' . $page : '/blog-progetti.php'),
    'og_title' => 'Progetti · ' . $nome_cognome,
    'og_type' => 'website',
];
ob_start();
?>
<section class="page-hero wrap-wide">
    <p class="eyebrow">Lavori realizzati</p>
    <h1>Progetti<span class="accent-dot">.</span></h1>
    <p class="page-hero__intro">Le applicazioni che realizzo, raccontate a partire dai problemi che risolvono.</p>
    <p class="text-muted">Per ogni progetto descrivo le scelte fatte, come funziona la soluzione e in quali contesti può essere utile.</p>
</section>
<section class="section section--border"><div class="wrap-wide">
    <?= render_project_cards($page_articles) ?>
    <?php if ($total_pages > 1): ?>
        <nav class="pagination" aria-label="Pagine dei progetti">
            <?php if ($page > 1): ?><a class="pagination-prev" href="/<?= $page === 2 ? 'blog-progetti.php' : 'blog-progetti.php?page=' . ($page - 1) ?>">Precedente</a><?php endif; ?>
            <span>Pagina <?= $page ?> di <?= $total_pages ?></span>
            <?php if ($page < $total_pages): ?><a class="pagination-next" href="/blog-progetti.php?page=<?= $page + 1 ?>">Successiva</a><?php endif; ?>
        </nav>
    <?php endif; ?>
</div></section>
<section class="section"><div class="wrap-wide contact-panel"><p class="eyebrow">Il tuo progetto</p><h2>Hai un problema simile da risolvere?</h2><p>Scrivimi cosa vorresti semplificare. Possiamo ragionare insieme sulla soluzione più adatta.</p><?= render_email_link($email, 'Contattami', 'button button--primary', 'Parliamo di un progetto') ?></div></section>
<?php
$content = ob_get_clean();
require __DIR__ . '/includes/layout/layout.php';
