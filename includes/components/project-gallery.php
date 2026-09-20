<?php
/** Reusable image gallery for a project's folder in assets/images/. */
if (!defined('FRAMEWORK_ENTRY')) {
    http_response_code(403);
    die('Direct access is not permitted.');
}

function render_project_gallery(array $article): string
{
    $folder = trim((string) ($article['gallery_folder'] ?? ''));
    if ($folder === '') {
        return '';
    }

    $imagesRoot = realpath(__DIR__ . '/../../assets/images');
    $folderPath = $imagesRoot === false ? false : realpath($imagesRoot . DIRECTORY_SEPARATOR . $folder);
    if ($folderPath === false || dirname($folderPath) !== $imagesRoot || !is_dir($folderPath)) {
        return '';
    }

    $files = [];
    foreach (scandir($folderPath) ?: [] as $name) {
        if (!preg_match('/\.(?:avif|gif|jpe?g|png|svg|webp)$/i', $name)) {
            continue;
        }
        $filePath = realpath($folderPath . DIRECTORY_SEPARATOR . $name);
        if ($filePath !== false && dirname($filePath) === $folderPath && is_file($filePath)) {
            $files[] = $name;
        }
    }
    if ($files === []) {
        return '';
    }
    natcasesort($files);
    $files = array_values($files);
    $count = count($files);
    $headingId = 'project-gallery-' . preg_replace('/[^a-z0-9-]+/', '-', strtolower((string) ($article['slug'] ?? 'images')));

    ob_start();
    ?>
    <section class="project-gallery wrap-wide" aria-labelledby="<?= htmlspecialchars($headingId, ENT_QUOTES, 'UTF-8') ?>">
        <div class="project-gallery__heading">
            <p class="eyebrow">Galleria</p>
            <h2 id="<?= htmlspecialchars($headingId, ENT_QUOTES, 'UTF-8') ?>">Immagini del progetto</h2>
        </div>
        <div class="project-gallery__carousel" data-project-gallery tabindex="0" aria-label="Galleria immagini del progetto">
            <div class="project-gallery__slides">
                <?php foreach ($files as $name):
                    $url = '/assets/images/' . rawurlencode(basename($folderPath)) . '/' . rawurlencode($name);
                    $label = trim((string) ($article['gallery_captions'][$name] ?? ''));
                    if ($label === '') {
                        $label = pathinfo($name, PATHINFO_FILENAME);
                        $label = preg_replace('/^\d+[\s._-]*/', '', $label);
                        $label = ucfirst(str_replace(['_', '-'], ' ', $label));
                    }
                    $alt = $url === ($article['featured_image'] ?? '')
                        ? ($article['image_alt'] ?? $label)
                        : 'Schermata del progetto: ' . $label;
                ?>
                    <figure class="project-gallery__slide">
                        <div class="project-gallery__frame"><img src="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($alt, ENT_QUOTES, 'UTF-8') ?>" loading="lazy"></div>
                        <figcaption><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
            <div class="project-gallery__controls" data-gallery-controls hidden>
                <button class="project-gallery__button project-gallery__button--prev" type="button" data-gallery-prev>Precedente</button>
                <span class="project-gallery__counter" data-gallery-counter aria-live="polite" aria-atomic="true">1 di <?= $count ?></span>
                <button class="project-gallery__button project-gallery__button--next" type="button" data-gallery-next>Successiva</button>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
