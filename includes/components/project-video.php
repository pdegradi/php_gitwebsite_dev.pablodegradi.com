<?php
/** Large video preview; the YouTube player loads only after activation. */
if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

function render_project_video(array $article, string $youtubeUrl, string $videoId): string
{
    $title = (string) ($article['title'] ?? 'progetto');
    $poster = (string) ($article['featured_image'] ?? '');
    $embedUrl = 'https://www.youtube-nocookie.com/embed/' . $videoId;

    ob_start();
    ?>
    <section class="project-video wrap-wide" id="video-progetto" aria-label="Video del progetto">
        <div class="project-video__player">
            <a class="project-video__preview" href="<?= htmlspecialchars($youtubeUrl, ENT_QUOTES, 'UTF-8') ?>" aria-label="Riproduci il video del progetto" target="_blank" rel="noopener noreferrer" data-youtube-embed="<?= htmlspecialchars($embedUrl, ENT_QUOTES, 'UTF-8') ?>" data-youtube-title="<?= htmlspecialchars('Video del progetto: ' . $title, ENT_QUOTES, 'UTF-8') ?>">
                <span class="project-video__poster">
                    <?php if ($poster !== ''): ?><img src="<?= htmlspecialchars($poster, ENT_QUOTES, 'UTF-8') ?>" alt="" loading="lazy"><?php endif; ?>
                    <span class="project-video__play" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l10-6.5z"/></svg></span>
                </span>
            </a>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
