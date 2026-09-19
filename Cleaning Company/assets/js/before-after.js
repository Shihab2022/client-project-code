/* =====================================================================
   BEFORE-AFTER.JS — accessible before/after comparison slider.
   Works with the mouse, touch, keyboard (range input) and RTL layouts.
   ===================================================================== */
(function () {
    'use strict';

    var widgets = document.querySelectorAll('[data-before-after]');
    if (!widgets.length) { return; }

    var isRtl = document.documentElement.getAttribute('dir') === 'rtl';

    widgets.forEach(function (widget) {
        var frame = widget.querySelector('.ba__frame');
        var afterWrap = widget.querySelector('[data-ba-after]');
        var handle = widget.querySelector('.ba__handle');
        var range = widget.querySelector('[data-ba-range]');
        var afterImg = afterWrap ? afterWrap.querySelector('img') : null;
        if (!frame || !afterWrap || !range) { return; }

        /* Keep the clipped "after" image aligned with the full frame width */
        function syncImageWidth() {
            if (!afterImg) { return; }
            afterImg.style.setProperty('--ba-img-width', frame.clientWidth + 'px');
        }

        function setRatio(value, updateHandle) {
            var percent = Math.max(0, Math.min(100, Number(value)));
            afterWrap.style.width = percent + '%';
            frame.style.setProperty('--ba-percent', percent + '%');
            if (afterImg) {
                afterImg.style.setProperty('--ba-img-width', frame.clientWidth + 'px');
            }
            if (updateHandle && handle) {
                handle.style.left = (isRtl ? (100 - percent) : percent) + '%';
            }
            range.setAttribute('aria-valuenow', String(Math.round(percent)));
        }

        range.addEventListener('input', function () {
            setRatio(range.value, true);
        });

        /* Pointer drag support for touch devices without a visible range */
        var dragging = false;
        function positionFromEvent(event) {
            var rect = frame.getBoundingClientRect();
            var clientX = event.touches ? event.touches[0].clientX : event.clientX;
            var percent = ((clientX - rect.left) / rect.width) * 100;
            return isRtl ? 100 - percent : percent;
        }
        frame.addEventListener('pointerdown', function (event) {
            dragging = true;
            setRatio(positionFromEvent(event), true);
            range.value = String(Math.round(Number(afterWrap.style.width.replace('%', '')) || 50));
        });
        window.addEventListener('pointermove', function (event) {
            if (!dragging) { return; }
            setRatio(positionFromEvent(event), true);
            range.value = String(Math.round(Number(afterWrap.style.width.replace('%', '')) || 50));
        });
        window.addEventListener('pointerup', function () {
            dragging = false;
        });

        window.addEventListener('resize', syncImageWidth);
        syncImageWidth();
        setRatio(50, true);
    });
})();