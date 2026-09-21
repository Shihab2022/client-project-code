/* =====================================================================
   MAIN.JS — navigation drawer, sticky header, accordion, tabs, counters,
   reveal-on-scroll, contact form UX. Vanilla ES2017, no dependencies.
   ===================================================================== */
(function () {
    'use strict';

    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function $(sel, ctx) { return (ctx || document).querySelector(sel); }
    function $all(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

    /* ------------------------------------------- mobile drawer / menu --- */
    var drawer = $('[data-drawer]');
    var navToggle = $('[data-nav-toggle]');

    function openDrawer() {
        if (!drawer) { return; }
        drawer.hidden = false;
        drawer.classList.add('is-open');
        document.body.classList.add('no-scroll');
        if (navToggle) { navToggle.setAttribute('aria-expanded', 'true'); }
        var close = $('.drawer__close', drawer);
        if (close) { close.focus(); }
    }

    function closeDrawer() {
        if (!drawer) { return; }
        drawer.classList.remove('is-open');
        drawer.hidden = true;
        document.body.classList.remove('no-scroll');
        if (navToggle) {
            navToggle.setAttribute('aria-expanded', 'false');
            navToggle.focus();
        }
    }

    if (navToggle && drawer) {
        navToggle.addEventListener('click', function () {
            if (drawer.hidden) { openDrawer(); } else { closeDrawer(); }
        });
        var closeBtn = $('[data-drawer-close]', drawer);
        if (closeBtn) { closeBtn.addEventListener('click', closeDrawer); }
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !drawer.hidden) { closeDrawer(); }
        });
    }

    /* Drawer sub-menu accordions */
    $all('.drawer__toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var panel = document.getElementById(btn.getAttribute('aria-controls'));
            var open = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', open ? 'false' : 'true');
            if (panel) { panel.hidden = open; }
        });
    });

    /* ------------------------------------------------ sticky header ----- */
    var header = $('[data-header]');
    if (header) {
        var onScroll = function () {
            header.classList.toggle('is-stuck', window.scrollY > 8);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* ------------------------------------------------ floating CTA ------ */
    var floating = $('[data-floating-cta]');
    if (floating) {
        var floatScroll = function () {
            floating.classList.toggle('is-visible', window.scrollY > 420);
        };
        floatScroll();
        window.addEventListener('scroll', floatScroll, { passive: true });
    }

    /* -------------------------------------------------- accordions ------ */
    $all('[data-accordion]').forEach(function (group) {
        $all('.accordion__trigger', group).forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                var panel = document.getElementById(trigger.getAttribute('aria-controls'));
                var item = trigger.closest('.accordion__item');
                var open = trigger.getAttribute('aria-expanded') === 'true';
                trigger.setAttribute('aria-expanded', open ? 'false' : 'true');
                if (panel) { panel.hidden = open; }
                if (item) { item.classList.toggle('is-open', !open); }
            });
        });
    });

    /* ----------------------------------------------- reveal on scroll --- */
    var revealables = $all('.reveal');
    if ('IntersectionObserver' in window && !prefersReduced) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });
        revealables.forEach(function (el) { observer.observe(el); });
    } else {
        revealables.forEach(function (el) { el.classList.add('is-visible'); });
    }

    /* ------------------------------------------------- stat counters ---- */
    var counters = $all('[data-count]');
    function animateCounter(el) {
        var target = parseInt(el.dataset.count, 10) || 0;
        if (prefersReduced || target === 0) {
            el.textContent = target.toLocaleString();
            return;
        }
        var started = null;
        function step(now) {
            if (started === null) { started = now; }
            var progress = Math.min((now - started) / 1300, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(target * eased).toLocaleString();
            if (progress < 1) { window.requestAnimationFrame(step); }
        }
        window.requestAnimationFrame(step);
    }
    if (counters.length && 'IntersectionObserver' in window) {
        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (el) { counterObserver.observe(el); });
    } else {
        counters.forEach(animateCounter);
    }

    /* -------------------------------------------- contact form helper --- */
    var form = $('[data-contact-form]');
    if (form) {
        form.addEventListener('submit', function (event) {
            var button = $('[data-submit]', form);
            var label = $('[data-submit-label]', form);
            if (!form.checkValidity()) {
                event.preventDefault();
                var invalid = $(':invalid', form);
                if (invalid) { invalid.focus(); }
                return;
            }
            if (button && label) {
                button.disabled = true;
                label.dataset.original = label.textContent;
                label.textContent = label.getAttribute('data-busy-label') || '…';
            }
        });
    }
    /* --------------------------------- area coverage map search --------- */
    var areaMap = $('[data-area-map]');
    if (areaMap) {
        var areaSearch = $('[data-area-search]', areaMap);
        var areaClear  = $('[data-area-clear]', areaMap);
        var areaStatus = $('[data-area-status]', areaMap);
        var areaEmpty  = $('[data-area-empty]', areaMap);
        var areaItems  = $all('[data-area-item]', areaMap);
        var areaPins   = $all('[data-area-pin]', areaMap);
        var countLabel = areaMap.getAttribute('data-count-label') || ':count areas shown';
        var totalCount = areaItems.length;

        function normalize(value) {
            return (value || '').toLowerCase().replace(/[\u064B-\u065F\u0670]/g, '').trim();
        }

        function applyAreaFilter() {
            var query   = normalize(areaSearch ? areaSearch.value : '');
            var visible = 0;

            areaItems.forEach(function (item) {
                var haystack = normalize(item.getAttribute('data-search'));
                var match    = query === '' || haystack.indexOf(query) !== -1;
                item.classList.toggle('is-hidden', !match);
                if (match) { visible++; }
            });

            areaPins.forEach(function (pin) {
                var haystack = normalize(pin.getAttribute('data-search'));
                var match    = query === '' || haystack.indexOf(query) !== -1;
                pin.classList.toggle('is-hidden', !match);
                pin.classList.toggle('is-match', query !== '' && match);
            });

            if (areaClear) { areaClear.hidden = query === ''; }
            if (areaEmpty) { areaEmpty.hidden = visible > 0; }
            if (areaStatus) { areaStatus.textContent = countLabel.replace(':count', String(visible || 0)); }

            if (query !== '' && visible === 0 && totalCount === 0) {
                areaMap.classList.add('is-empty');
            } else {
                areaMap.classList.remove('is-empty');
            }
        }

        if (areaSearch) {
            areaSearch.addEventListener('input', applyAreaFilter);
            areaSearch.addEventListener('search', applyAreaFilter);
        }
        if (areaClear) {
            areaClear.addEventListener('click', function () {
                areaSearch.value = '';
                applyAreaFilter();
                areaSearch.focus();
            });
        }
    }
})();
