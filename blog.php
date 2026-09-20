<?php
define('FRAMEWORK_ENTRY', true);
require __DIR__ . '/includes/config.php';
// functions.php is already loaded by config.php, no need to require it again here.

// Current page number: from a CLI argument when invoked by build-static.php
// (e.g. "php blog.php 2"), otherwise from ?page= when browsing the site
// (works both under php -S and, if you ever host the PHP version, live).
$page = 1;
if (PHP_SAPI === 'cli' && isset($argv[1])) {
    $page = (int) $argv[1];
} elseif (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
}
if ($page < 1) {
    $page = 1;
}

$sorted_articles = get_sorted_articles($articles, $article_sort_by, $article_sort_order);

$total_pages = max(1, (int) ceil(count($sorted_articles) / $blog_page_size));
if ($page > $total_pages) {
    $page = $total_pages;
}

$page_articles = array_slice($sorted_articles, ($page - 1) * $blog_page_size, $blog_page_size);

// Pagination nav markup, built once so it can be reused both above and
// below the article list (see the commented copy near the top of the page).
ob_start();
if ($total_pages > 1):
    ?>
    <nav class="pagination" aria-label="Paginazione">
        <?php if ($page > 1): ?>
            <a class="pagination__prev" href="/<?= $page === 2 ? 'blog.php' : 'blog.php?page=' . ($page - 1) ?>">&laquo; Precedente</a>
        <?php endif; ?>

        <span class="pagination__pages">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i === $page): ?>
                    <span class="pagination__current" aria-current="page"><?= $i ?></span>
                <?php else: ?>
                    <a href="/<?= $i === 1 ? 'blog.php' : 'blog.php?page=' . $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </span>

        <?php if ($page < $total_pages): ?>
            <a class="pagination__next" href="/blog.php?page=<?= $page + 1 ?>">Successiva &raquo;</a>
        <?php endif; ?>
    </nav>
    <?php
endif;
$pagination_nav = ob_get_clean();

ob_start();
?>



<section class="wrap-content">
    
    <h1>Blog</h1>
    
    <!--
    Uncomment to also show the pagination nav above the list, not just below it:
    <?= $pagination_nav ?>
    -->

    <?php if (empty($page_articles)): ?>
        <p>Nessun articolo pubblicato per ora.</p>
    <?php else: ?>
        <ul class="article-list">
            <?php foreach ($page_articles as $article): ?>
                <li>
                    <a href="/<?= $articles_folder ?>/<?= htmlspecialchars($article['slug']) ?>.php">
                        <div>
                            <img src="<?= $article['featured_image'] ?>" alt="" />
                        </div>
                        <div>
                            <h4><?= htmlspecialchars($article['title']) ?></h4>
                            <?php if (!empty($article['date'])): ?>
                                <span class="article-list__date"><?= htmlspecialchars(format_article_date($article['date'])) ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?= $pagination_nav ?>

</section>


<?php
$content = ob_get_clean();

$page_title = $page > 1 ? "Blog · pagina {$page}" : "Blog";

$seo = [
    'description' => "Tutti gli articoli di {$site_name}.",
    'og_title'     => "Blog · {$site_name}",
    'og_type'      => 'website',
];

require __DIR__ . '/includes/layout/layout.php';
