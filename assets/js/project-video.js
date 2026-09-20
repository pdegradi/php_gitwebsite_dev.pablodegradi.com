(function () {
    'use strict';

    document.querySelectorAll('[data-youtube-embed]').forEach(function (preview) {
        preview.addEventListener('click', function (event) {
            var embedUrl = preview.getAttribute('data-youtube-embed');
            if (!/^https:\/\/www\.youtube-nocookie\.com\/embed\/[A-Za-z0-9_-]{11}$/.test(embedUrl || '')) return;

            event.preventDefault();
            var iframe = document.createElement('iframe');
            iframe.className = 'project-video__iframe';
            iframe.src = embedUrl + '?autoplay=1';
            iframe.title = preview.getAttribute('data-youtube-title') || 'Video YouTube';
            iframe.allow = 'autoplay; encrypted-media; picture-in-picture; fullscreen';
            iframe.allowFullscreen = true;
            iframe.referrerPolicy = 'strict-origin-when-cross-origin';
            preview.replaceWith(iframe);
            iframe.focus();
        });
    });
})();
