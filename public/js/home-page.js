(function () {
    var backdrop = document.getElementById('reviewModalBackdrop');
    var openBtn = document.getElementById('openReviewModalBtn');
    var closeBtn = document.getElementById('closeReviewModalBtn');

    function openModal() {
        if (backdrop) backdrop.classList.add('is-open');
    }

    function closeModal() {
        if (backdrop) backdrop.classList.remove('is-open');
    }

    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    if (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closeModal();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
})();

// Show roughly the first 10 feedback cards (rounded up to full rows,
// since the list is a responsive grid) before it becomes scrollable.
// Card height varies (message length isn't clamped), so the cutoff
// is measured from real rendered heights rather than a fixed px value.
(function () {
    var VISIBLE_COUNT = 10;
    var body = document.querySelector('.feedback-table__body');
    if (!body) return;

    function getColumnCount() {
        var template = window.getComputedStyle(body).gridTemplateColumns;
        if (!template || template === 'none') return 1;
        return template.split(' ').filter(Boolean).length || 1;
    }

    function recalcFeedbackHeight() {
        var cards = Array.prototype.filter.call(
            body.querySelectorAll('.review-card'),
            function (el) { return !el.classList.contains('review-card--empty'); }
        );

        if (cards.length <= VISIBLE_COUNT) {
            body.style.maxHeight = 'none';
            body.style.overflowY = 'visible';
            return;
        }

        var columns = getColumnCount();
        var rowsNeeded = Math.ceil(VISIBLE_COUNT / columns);
        var lastVisibleIndex = Math.min((rowsNeeded * columns) - 1, cards.length - 1);

        var containerTop = body.getBoundingClientRect().top;
        var lastVisibleCard = cards[lastVisibleIndex];
        var lastVisibleBottom = lastVisibleCard.getBoundingClientRect().bottom;
        var paddingBottom = parseFloat(window.getComputedStyle(body).paddingBottom) || 0;

        body.style.maxHeight = Math.ceil(lastVisibleBottom - containerTop + paddingBottom) + 'px';
        body.style.overflowY = 'auto';
    }

    recalcFeedbackHeight();
    window.addEventListener('load', recalcFeedbackHeight);

    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(recalcFeedbackHeight, 150);
    });
})();
