(function () {
    'use strict';

    document.querySelectorAll('[data-project-gallery]').forEach(function (gallery) {
        var slides = Array.from(gallery.querySelectorAll('.project-gallery__slide'));
        var controls = gallery.querySelector('[data-gallery-controls]');
        var previous = gallery.querySelector('[data-gallery-prev]');
        var next = gallery.querySelector('[data-gallery-next]');
        var counter = gallery.querySelector('[data-gallery-counter]');
        if (!slides.length || !controls || !previous || !next || !counter) return;

        var current = 0;
        function show(index) {
            current = (index + slides.length) % slides.length;
            slides.forEach(function (slide, slideIndex) {
                slide.hidden = slideIndex !== current;
            });
            counter.textContent = (current + 1) + ' di ' + slides.length;
        }

        show(0);
        controls.hidden = false;
        if (slides.length === 1) {
            previous.disabled = true;
            next.disabled = true;
            return;
        }

        previous.addEventListener('click', function () { show(current - 1); });
        next.addEventListener('click', function () { show(current + 1); });
        gallery.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowLeft') {
                event.preventDefault();
                show(current - 1);
            } else if (event.key === 'ArrowRight') {
                event.preventDefault();
                show(current + 1);
            }
        });
    });
})();
