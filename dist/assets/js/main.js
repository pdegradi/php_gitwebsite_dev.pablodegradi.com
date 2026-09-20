(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    ready(function () {
        var toggle = document.querySelector('.nav-toggle');
        var nav = document.querySelector('.site-nav');
        if (toggle && nav) {
            var backdrop = document.createElement('div');
            backdrop.className = 'nav-backdrop';
            document.body.appendChild(backdrop);

            function syncNavAccessibility() {
                nav.inert = window.innerWidth <= 930 && !nav.classList.contains('is-open');
            }
            function closeMenu() {
                nav.classList.remove('is-open');
                backdrop.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Apri il menu');
                document.body.classList.remove('menu-open');
                syncNavAccessibility();
            }
            function openMenu() {
                nav.classList.add('is-open');
                backdrop.classList.add('is-open');
                toggle.setAttribute('aria-expanded', 'true');
                toggle.setAttribute('aria-label', 'Chiudi il menu');
                document.body.classList.add('menu-open');
                syncNavAccessibility();
                nav.querySelector('a').focus();
            }
            toggle.addEventListener('click', function () {
                nav.classList.contains('is-open') ? closeMenu() : openMenu();
            });
            backdrop.addEventListener('click', closeMenu);
            nav.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', closeMenu);
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && nav.classList.contains('is-open')) {
                    closeMenu();
                    toggle.focus();
                }
            });
            window.addEventListener('resize', function () {
                if (window.innerWidth > 930) closeMenu();
                syncNavAccessibility();
            });
            syncNavAccessibility();
        }

        var toc = document.querySelector('.toc');
        var article = document.querySelector('.article-content');
        if (toc && article) {
            var headings = article.querySelectorAll('h2, h3');
            if (headings.length) {
                var used = new Set();
                var list = document.createElement('ul');
                headings.forEach(function (heading) {
                    if (!heading.id) {
                        var base = heading.textContent.toLowerCase().normalize('NFD')
                            .replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '') || 'sezione';
                        var id = base;
                        var index = 2;
                        while (used.has(id)) id = base + '-' + index++;
                        heading.id = id;
                    }
                    used.add(heading.id);
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
                toc.appendChild(title);
                toc.appendChild(list);
            }
        }

        document.querySelectorAll('.code-block').forEach(function (block) {
            var code = block.querySelector('code');
            if (!code) return;
            var button = document.createElement('button');
            button.type = 'button';
            button.className = 'code-block__copy';
            button.setAttribute('aria-label', 'Copia il codice');
            button.textContent = '⧉';
            button.addEventListener('click', function () {
                navigator.clipboard.writeText(code.textContent).then(function () {
                    button.textContent = '✓';
                    button.setAttribute('aria-label', 'Codice copiato');
                    window.setTimeout(function () {
                        button.textContent = '⧉';
                        button.setAttribute('aria-label', 'Copia il codice');
                    }, 1500);
                });
            });
            block.appendChild(button);
        });

        var zoomable = document.querySelectorAll('img.zoomable');
        if (zoomable.length) {
            var overlay = document.createElement('div');
            overlay.className = 'lightbox-overlay';
            overlay.setAttribute('role', 'dialog');
            overlay.setAttribute('aria-modal', 'true');
            overlay.innerHTML = '<button type="button" class="lightbox-overlay__close" aria-label="Chiudi">×</button><img class="lightbox-overlay__image" alt=""><p class="lightbox-overlay__caption"></p>';
            document.body.appendChild(overlay);
            var image = overlay.querySelector('img');
            var caption = overlay.querySelector('p');
            var closeButton = overlay.querySelector('button');
            var previousFocus = null;
            function close() {
                overlay.classList.remove('is-open');
                document.body.classList.remove('lightbox-lock-scroll');
                if (previousFocus) previousFocus.focus();
            }
            closeButton.addEventListener('click', close);
            overlay.addEventListener('click', function (event) {
                if (event.target === overlay) close();
            });
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && overlay.classList.contains('is-open')) close();
            });
            zoomable.forEach(function (thumb) {
                thumb.setAttribute('tabindex', '0');
                thumb.setAttribute('role', 'button');
                function open() {
                    previousFocus = thumb;
                    image.src = thumb.src;
                    image.alt = thumb.alt;
                    caption.textContent = thumb.alt;
                    overlay.classList.add('is-open');
                    document.body.classList.add('lightbox-lock-scroll');
                    closeButton.focus();
                }
                thumb.addEventListener('click', open);
                thumb.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        open();
                    }
                });
            });
        }
    });
})();
