<?php
/**
 * includes/article-layout.php
 * Shared layout for every article page. Internal file, not meant to be
 * requested directly. It builds the markup common to all articles
 * (title, publish date, featured image, TOC placeholder, content
 * wrapper) and then hands off to includes/layout.php.
 *
 * Before including this file, an article must have defined:
 *   $article_title (string, required) - article heading
 *   $article_body  (string, required) - HTML for the .article-content
 *                                        block, built via output buffering
 *
 * An article can also optionally define:
 *   $article_date   (string, optional) - publish date, Y-m-d
 *   $featured_image (string, optional) - path to a cover image
 *   $page_css, $page_js, $seo - same meaning as in includes/layout.php
 */

if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

$article_date   = $article_date   ?? '';
$featured_image = $featured_image ?? '';

ob_start();
?>
<article>

    <div class="wrap-wide">
        <h1 style="text-align: center;"><?= htmlspecialchars($article_title) ?></h1>
    
        <?php if ($article_date !== ''): ?>
            <p class="article-meta">Pubblicato il <?= htmlspecialchars(format_article_date($article_date)) ?></p>
        <?php endif; ?>

        <?php if ($featured_image !== ''): ?>
            <img class="featured-image" src="<?= htmlspecialchars($featured_image) ?>" alt="Immagine di copertina dell'articolo">
        <?php endif; ?>
    </div>

    <div class="wrap-content">
        <nav class="toc" aria-label="Indice dei contenuti">
            <!-- Generated automatically by JS, see assets/js/main.js -->
        </nav>
    </div>

    <div class="article-content wrap-content">
        <?= $article_body ?>
    </div>
</article>
<?php
$content = ob_get_clean();

$page_title = $page_title ?? $article_title;

require __DIR__ . '/layout.php';
