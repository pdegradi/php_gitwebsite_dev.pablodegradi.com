/**
 * assets/js/main.js
 * Global site JS.
 *
 * Organized as independent, self-contained components. Each component is
 * an IIFE that looks for its own markers (a specific CSS class) in the
 * page and does nothing if that marker is not present, so it is always
 * safe to load this single file on every page.
 *
 * Components:
 *   1. TableOfContents - builds the article TOC from h2/h3 headings
 *   2. CodeBlockCopy   - adds a "copy to clipboard" button to code blocks
 *   3. Lightbox        - image zoom, used by both single images and galleries
 */

/* =========================================================
   Component: TableOfContents
   Looks for a <nav class="toc"> and a <div class="article-content">.
   Lists every h2/h3 found in the content, indenting h3 under h2.
   ========================================================= */
(function TableOfContents() {
    'use strict';

    function slugify(text, usedSlugs) {
        var base = text
            .toLowerCase()
            .trim()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // strip accents
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');

        if (!base) {
            base = 'section';
        }

        var slug = base;
        var i = 2;
        while (usedSlugs.has(slug)) {
            slug = base + '-' + i;
            i++;
        }
        usedSlugs.add(slug);
        return slug;
    }

    function init() {
        var tocEl = document.querySelector('.toc');
        var contentEl = document.querySelector('.article-content');

        if (!tocEl || !contentEl) {
            return;
        }

        var headings = contentEl.querySelectorAll('h2, h3');
        if (headings.length === 0) {
            return;
        }

        var usedSlugs = new Set();
        var list = document.createElement('ul');

        headings.forEach(function (heading) {
            if (!heading.id) {
                heading.id = slugify(heading.textContent, usedSlugs);
            } else {
                usedSlugs.add(heading.id);
            }

            var item = document.createElement('li');
            item.className = heading.tagName === 'H3' ? 'toc-h3' : 'toc-h2';

            var link = document.createElement('a');
            link.href = '#' + heading.id;
            link.textContent = heading.textContent;

            item.appendChild(link);
            list.appendChild(item);
        });

        var title = document.createElement('p');
        title.className = 'toc-title';
        title.textContent = 'In questo articolo';

        tocEl.appendChild(title);
        tocEl.appendChild(list);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

/* =========================================================
   Component: CodeBlockCopy
   Looks for <div class="code-block"><pre><code>...</code></pre></div>.
   Injects a copy-to-clipboard button in the top-right corner.
   ========================================================= */
(function CodeBlockCopy() {
    'use strict';

    var COPY_ICON = '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true">' +
        '<path fill="currentColor" d="M16 1H4a2 2 0 0 0-2 2v14h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>' +
        '</svg>';

    var CHECK_ICON = '<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true">' +
        '<path fill="currentColor" d="M9 16.2 4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/>' +
        '</svg>';

    function addCopyButton(block) {
        var codeEl = block.querySelector('code');
        if (!codeEl) {
            return;
        }

        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'code-block__copy';
        button.setAttribute('aria-label', 'Copia il codice');
        button.innerHTML = COPY_ICON;

        button.addEventListener('click', function () {
            navigator.clipboard.writeText(codeEl.textContent).then(function () {
                button.innerHTML = CHECK_ICON;
                button.classList.add('code-block__copy--done');
                setTimeout(function () {
                    button.innerHTML = COPY_ICON;
                    button.classList.remove('code-block__copy--done');
                }, 1500);
            }).catch(function (err) {
                console.error('Copy to clipboard failed:', err);
            });
        });

        block.appendChild(button);
    }

    function init() {
        document.querySelectorAll('.code-block').forEach(addCopyButton);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

/* =========================================================
   Component: Lightbox
   Handles two cases:
   - standalone images with class "zoomable" (single image, no navigation)
   - groups of images inside "div.gallery" (thumbnails with prev/next navigation)
   Both cases share one overlay, built once and reused.
   ========================================================= */
(function Lightbox() {
    'use strict';

    var overlay, imageEl, prevBtn, nextBtn, captionEl;
    var currentGroup = [];
    var currentIndex = 0;

    function buildOverlay() {
        overlay = document.createElement('div');
        overlay.className = 'lightbox-overlay';
        overlay.setAttribute('role', 'dialog');
        overlay.setAttribute('aria-modal', 'true');

        overlay.innerHTML =
            '<button type="button" class="lightbox-overlay__close" aria-label="Chiudi">&times;</button>' +
            '<button type="button" class="lightbox-overlay__prev" aria-label="Immagine precedente">&#8249;</button>' +
            '<img class="lightbox-overlay__image" alt="">' +
            '<button type="button" class="lightbox-overlay__next" aria-label="Immagine successiva">&#8250;</button>' +
            '<p class="lightbox-overlay__caption"></p>';

        document.body.appendChild(overlay);

        imageEl   = overlay.querySelector('.lightbox-overlay__image');
        prevBtn   = overlay.querySelector('.lightbox-overlay__prev');
        nextBtn   = overlay.querySelector('.lightbox-overlay__next');
        captionEl = overlay.querySelector('.lightbox-overlay__caption');

        overlay.querySelector('.lightbox-overlay__close').addEventListener('click', close);
        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                close();
            }
        });
        prevBtn.addEventListener('click', function () { show(currentIndex - 1); });
        nextBtn.addEventListener('click', function () { show(currentIndex + 1); });

        document.addEventListener('keydown', function (event) {
            if (!overlay.classList.contains('is-open')) {
                return;
            }
            if (event.key === 'Escape') close();
            if (event.key === 'ArrowLeft') show(currentIndex - 1);
            if (event.key === 'ArrowRight') show(currentIndex + 1);
        });
    }

    function show(index) {
        var total = currentGroup.length;
        currentIndex = (index + total) % total;

        var source = currentGroup[currentIndex];
        imageEl.src = source.src;
        imageEl.alt = source.alt || '';
        captionEl.textContent = source.alt || '';

        var hasMultiple = total > 1;
        prevBtn.style.display = hasMultiple ? '' : 'none';
        nextBtn.style.display = hasMultiple ? '' : 'none';
    }

    function open(group, startIndex) {
        if (!overlay) {
            buildOverlay();
        }
        currentGroup = group;
        show(startIndex);
        overlay.classList.add('is-open');
        document.body.classList.add('lightbox-lock-scroll');
    }

    function close() {
        overlay.classList.remove('is-open');
        document.body.classList.remove('lightbox-lock-scroll');
    }

    function imageSource(img) {
        return { src: img.getAttribute('src'), alt: img.getAttribute('alt') || '' };
    }

    function init() {
        // Galleries: thumbnails side by side (flex-wrap, see style.css),
        // clicking one opens the lightbox with navigation across the group.
        document.querySelectorAll('.gallery').forEach(function (gallery) {
            var images = Array.prototype.slice.call(gallery.querySelectorAll('img'));
            var group = images.map(imageSource);

            images.forEach(function (img, index) {
                img.classList.add('gallery__thumb');
                img.setAttribute('tabindex', '0');
                img.setAttribute('role', 'button');
                img.addEventListener('click', function () { open(group, index); });
                img.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        open(group, index);
                    }
                });
            });
        });

        // Standalone zoomable images: a single-image group, no navigation needed.
        document.querySelectorAll('img.zoomable').forEach(function (img) {
            if (img.closest('.gallery')) {
                return; // already handled as part of a gallery
            }
            img.setAttribute('tabindex', '0');
            img.setAttribute('role', 'button');
            var group = [imageSource(img)];
            img.addEventListener('click', function () { open(group, 0); });
            img.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    open(group, 0);
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

/* =========================================================
   Component: MathBlocks
   Looks for <div class="math-block">LaTeX source</div> and renders it
   with KaTeX (loaded separately as a vendor library, see layout.php).
   ========================================================= */
(function MathBlocks() {
    'use strict';

    function init() {
        if (typeof katex === 'undefined') {
            return;
        }

        document.querySelectorAll('.math-block').forEach(function (block) {
            var source = block.textContent.trim();
            try {
                katex.render(source, block, { displayMode: true, throwOnError: false });
            } catch (err) {
                console.error('KaTeX render error:', err);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();


/* =========================================================
   Component: MobileNav
   ========================================================= */

(function MobileNav() {
    'use strict';

    function init() {
        var toggle = document.querySelector('.nav-toggle');
        var nav = document.querySelector('.site-nav');
        if (!toggle || !nav) {
            return;
        }

        var backdrop = document.createElement('div');
        backdrop.className = 'nav-backdrop';
        document.body.appendChild(backdrop);

        function open() {
            nav.classList.add('is-open');
            backdrop.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
        }

        function close() {
            nav.classList.remove('is-open');
            backdrop.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        toggle.addEventListener('click', function () {
            nav.classList.contains('is-open') ? close() : open();
        });

        backdrop.addEventListener('click', close);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') close();
        });

        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', close);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

