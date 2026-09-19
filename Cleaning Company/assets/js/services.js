/* =====================================================================
   SERVICES.JS — category filter for the service grid on the home page
   (pure JS, works with or without a server, no database).
   Markup produced by service_card() carries data-category="residential|..."
   ===================================================================== */
(function () {
    'use strict';

    var wrapper = document.querySelector('[data-services-grid]');
    if (!wrapper) { return; }

    var tabs = wrapper.querySelectorAll('[data-filter]');
    var cards = wrapper.querySelectorAll('.service-card[data-category]');
    if (!tabs.length || !cards.length) { return; }

    function applyFilter(value) {
        cards.forEach(function (card) {
            var match = value === 'all' || card.getAttribute('data-category') === value;
            card.hidden = !match;
            if (match && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                card.classList.remove('is-visible');
                void card.offsetWidth;
                card.classList.add('is-visible');
            }
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var value = tab.getAttribute('data-filter');
            tabs.forEach(function (other) {
                var active = other === tab;
                other.classList.toggle('is-active', active);
                other.setAttribute('aria-selected', active ? 'true' : 'false');
            });
            applyFilter(value);
        });
    });

    /* Deep-link support: /?category=commercial pre-filters the grid */
    var params = new URLSearchParams(window.location.search);
    var initial = params.get('category');
    if (initial) {
        tabs.forEach(function (tab) {
            if (tab.getAttribute('data-filter') === initial) { tab.click(); }
        });
    }
})();