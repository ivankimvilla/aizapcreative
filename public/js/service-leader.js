(function () {
    var countEl = document.getElementById('leaderCount');
    if (!countEl) return;

    var total = 6;
    var current = 1;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion) return;

    setInterval(function () {
        countEl.style.transition = 'opacity .2s ease, transform .2s ease';
        countEl.style.opacity = '0';
        countEl.style.transform = 'translateY(-3px)';

        setTimeout(function () {
            current = (current % total) + 1;
            countEl.textContent = String(current).padStart(2, '0');
            countEl.style.transform = 'translateY(3px)';

            requestAnimationFrame(function () {
                countEl.style.opacity = '1';
                countEl.style.transform = 'translateY(0)';
            });
        }, 200);
    }, 2600);
})();
