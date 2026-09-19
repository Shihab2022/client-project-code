/* =====================================================================
   GALLERY.JS — filter tabs + lightbox with keyboard navigation & swipe
   ===================================================================== */
(function () {
    'use strict';

    var gallery = document.querySelector('[data-gallery]');
    if (!gallery) { return; }

    var items = Array.prototype.slice.call(gallery.querySelectorAll('.gallery-item'));
    var tabs = Array.prototype.slice.call(gallery.querySelectorAll('[data-filter]'));
    var lightbox = document.querySelector('[data-lightbox]');
    var lastFocused = null;

    /* ------------------------------------------------------- filtering --- */
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var value = tab.getAttribute('data-filter');
            tabs.forEach(function (other) {
                var active = other === tab;
                other.classList.toggle('is-active', active);
                other.setAttribute('aria-selected', active ? 'true' : 'false');
            });
            items.forEach(function (item) {
                item.hidden = value !== 'all' && item.getAttribute('data-category') !== value;
            });
        });
    });

    /* -------------------------------------------------------- lightbox --- */
    function visibleItems() {
        return items.filter(function (item) { return !item.hidden; });
    }

    function openLightbox(index) {
        var list = visibleItems();
        if (!lightbox || !list.length) { return; }
        var item = list[index];
        if (!item) { return; }
        var img = item.querySelector('img');
        var caption = item.querySelector('.gallery-item__caption');

        lightbox.querySelector('img').src = img.currentSrc || img.src;
        lightbox.querySelector('img').alt = img.alt;
        var cap = lightbox.querySelector('[data-lightbox-caption]');
        if (cap) { cap.textContent = caption ? caption.textContent : img.alt; }
        lightbox.setAttribute('data-index', String(index));
        lightbox.classList.add('is-open');
        lightbox.hidden = false;
        document.body.classList.add('no-scroll');
        lastFocused = document.activeElement;
        var close = lightbox.querySelector('[data-lightbox-close]');
        if (close) { close.focus(); }
    }

    function closeLightbox() {
        if (!lightbox) { return; }
        lightbox.classList.remove('is-open');
        lightbox.hidden = true;
        document.body.classList.remove('no-scroll');
        if (lastFocused) { lastFocused.focus(); }
    }

    function step(dir) {
        var list = visibleItems();
        var current = parseInt((lightbox.getAttribute('data-index') || '0'), 10);
        var next = (current + dir + list.length) % list.length;
        openLightbox(next);
    }

    items.forEach(function (item, index) {
        item.addEventListener('click', function () { openLightbox(index); });
        item.setAttribute('tabindex', '0');
        item.setAttribute('role', 'button');
        item.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openLightbox(index);
            }
        });
    });

    if (lightbox) {
        var closeBtn = lightbox.querySelector('[data-lightbox-close]');
        var prevBtn = lightbox.querySelector('[data-lightbox-prev]');
        var nextBtn = lightbox.querySelector('[data-lightbox-next]');
        if (closeBtn) { closeBtn.addEventListener('click', closeLightbox); }
        if (prevBtn) { prevBtn.addEventListener('click', function () { step(-1); }); }
        if (nextBtn) { nextBtn.addEventListener('click', function () { step(1); }); }

        document.addEventListener('keydown', function (event) {
            if (!lightbox.classList.contains('is-open')) { return; }
            if (event.key === 'Escape') { closeLightbox(); }
            if (event.key === 'ArrowRight') { step(1); }
            if (event.key === 'ArrowLeft') { step(-1); }
        });

        /* Simple swipe support on touch devices */
        var startX = null;
        lightbox.addEventListener('touchstart', function (event) {
            startX = event.touches[0].clientX;
        }, { passive: true });
        lightbox.addEventListener('touchend', function (event) {
            if (startX === null) { return; }
            var delta = event.changedTouches[0].clientX - startX;
            if (Math.abs(delta) > 60) { step(delta < 0 ? 1 : -1); }
            startX = null;
        }, { passive: true });

        lightbox.addEventListener('click', function (event) {
            if (event.target === lightbox) { closeLightbox(); }
        });
    }
})();