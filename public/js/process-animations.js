(function () {
    var heading = document.querySelector('.process-section .section-heading');
    var iconsRow = document.querySelector('.process-icons-row');
    var cards = document.querySelectorAll('.process-step-card');

    var targets = [];
    if (heading) targets.push(heading);
    if (iconsRow) targets.push(iconsRow);
    cards.forEach(function (card) { targets.push(card); });

    // No targets, or no IntersectionObserver support (very old browser):
    // do nothing and leave everything in its normal, visible state.
    if (!targets.length || !('IntersectionObserver' in window)) {
        return;
    }

    // Only NOW do we hide elements ahead of the reveal — we know the
    // observer exists and will bring them back, so nothing gets stuck.
    targets.forEach(function (el) { el.classList.add('reveal-init'); });

    // Stagger the cards a little per index for a cinematic cascade as they enter.
    cards.forEach(function (card, i) {
        card.style.transitionDelay = (i * 90) + 'ms';
    });

    var observer = new IntersectionObserver(
        function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                } else {
                    // Leaving the viewport resets it, so it plays again on re-entry
                    // whether the user scrolls down past it or back up to it.
                    entry.target.classList.remove('is-visible');
                }
            });
        },
        { threshold: 0.2, rootMargin: '0px 0px -60px 0px' }
    );

    targets.forEach(function (el) { observer.observe(el); });
})();