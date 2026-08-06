(function () {
    'use strict';

    // Small DOM helper to create the consistent alert nodes used across forms
    function createAlert(type, title, message, items) {
        var alert = document.createElement('div');
        alert.className = 'form-alert form-alert--' + type;
        alert.setAttribute('role', 'alert');

        var icon = document.createElement('div');
        icon.className = 'form-alert__icon';
        icon.setAttribute('aria-hidden', 'true');
        icon.innerHTML = type === 'success'
            ? '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="12" fill="#16a34a"/><path d="M7 12.5l3 3 7-7.5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none"><path d="M12 2.5L23 21H1L12 2.5Z" fill="#ef4444"/><rect x="11" y="9" width="2" height="6" rx="1" fill="#fff"/><rect x="11" y="16.5" width="2" height="2" rx="1" fill="#fff"/></svg>';
        alert.appendChild(icon);

        var content = document.createElement('div');
        var titleEl = document.createElement('div');
        titleEl.className = 'form-alert__title';
        titleEl.textContent = title;
        content.appendChild(titleEl);

        if (message) {
            var msgEl = document.createElement('p');
            msgEl.textContent = message;
            content.appendChild(msgEl);
        }

        if (items && items.length) {
            var list = document.createElement('ul');
            items.forEach(function (item) { var li = document.createElement('li'); li.textContent = item; list.appendChild(li); });
            content.appendChild(list);
        }

        alert.appendChild(content);
        return alert;
    }

    // ------------------ Review modal & feedback submission (graceful noop if not present) ------------------
    (function () {
        var backdrop = document.getElementById('reviewModalBackdrop');
        var openBtn = document.getElementById('openReviewModalBtn');
        var closeBtn = document.getElementById('closeReviewModalBtn');
        var modalCard = document.querySelector('.review-modal__card');
        var feedbackBody = document.querySelector('.feedback-table__body');
        var feedbackCount = document.querySelector('.feedback-count');
        var feedbackSummaryCount = document.querySelector('.feedback-summary-count');

        function closeModal() {
            if (!backdrop) return;
            backdrop.classList.add('closing');
            backdrop.classList.remove('is-open');
            window.setTimeout(function () { backdrop.classList.remove('closing'); }, 260);
        }

        function appendFeedbackCard(feedback) {
            if (!feedbackBody) return;
            var card = document.createElement('div');
            card.className = 'review-card';
            card.setAttribute('data-search', (feedback.name + ' ' + feedback.message).toLowerCase());

            var top = document.createElement('div'); top.className = 'review-card__top';
            var avatar = document.createElement('span'); avatar.className = 'review-card__avatar'; avatar.textContent = feedback.name.slice(0, 2).toUpperCase();
            var nameEl = document.createElement('strong'); nameEl.className = 'review-card__name'; nameEl.textContent = feedback.name;
            top.appendChild(avatar); top.appendChild(nameEl);

            var starsDate = document.createElement('div'); starsDate.className = 'review-card__stars-date';
            var starsWrap = document.createElement('span'); starsWrap.className = 'review-card__stars';
            for (var i = 1; i <= 5; i++) {
                var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.setAttribute('width', '13'); svg.setAttribute('height', '13'); svg.setAttribute('viewBox', '0 0 24 24');
                svg.setAttribute('fill', 'currentColor'); svg.style.opacity = (i <= feedback.rating ? '1' : '0.25');
                var path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('d', 'M12 2l3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2Z');
                svg.appendChild(path);
                starsWrap.appendChild(svg);
            }
            var dateEl = document.createElement('span'); dateEl.className = 'review-card__date'; dateEl.textContent = feedback.created_at;
            starsDate.appendChild(starsWrap); starsDate.appendChild(dateEl);

            var msgP = document.createElement('p'); msgP.className = 'review-card__message'; msgP.textContent = feedback.message;

            card.appendChild(top);
            card.appendChild(starsDate);
            card.appendChild(msgP);

            var emptyCard = feedbackBody.querySelector('.review-card--empty');
            if (emptyCard) emptyCard.remove();
            feedbackBody.insertBefore(card, feedbackBody.firstChild);
        }

        function updateCounts() {
            if (feedbackCount) {
                var current = parseInt(feedbackCount.textContent, 10) || 0;
                feedbackCount.textContent = current + 1;
            }
            if (feedbackSummaryCount) {
                var current = parseInt(feedbackSummaryCount.textContent, 10) || 0;
                var label = current + 1 === 1 ? 'review' : 'reviews';
                feedbackSummaryCount.textContent = (current + 1) + ' ' + label;
            }
        }

        // wire open/close safely
        if (openBtn) openBtn.addEventListener('click', function () { if (backdrop) backdrop.classList.add('is-open'); });
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        // If there is a feedback form inside the modal, wire basic AJAX submit
        var fbForm = document.querySelector('.review-form');
        if (!fbForm) return;

        var isSubmitting = false;
        fbForm.addEventListener('submit', function (ev) {
            ev.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;
            var submitButton = fbForm.querySelector('button[type="submit"]');
            if (submitButton) submitButton.disabled = true;

            // basic submit via fetch
            var fd = new FormData(fbForm);
            var action = fbForm.getAttribute('action') || window.location.href;
            fetch(action, { method: 'POST', body: fd, credentials: 'same-origin' })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    var successAlert = createAlert('success', 'Feedback submitted', 'Thanks for sharing your experience.');
                    fbForm.insertBefore(successAlert, fbForm.firstChild);
                    fbForm.reset();
                    if (!data.duplicate && data.feedback) {
                        appendFeedbackCard(data.feedback);
                        updateCounts();
                    }
                    if (submitButton) submitButton.disabled = false;
                    isSubmitting = false;
                    setTimeout(closeModal, 1400);
                })
                .catch(function (err) {
                    var errAlert = createAlert('error', "Couldn't submit feedback", err && err.message ? [err.message] : null);
                    fbForm.insertBefore(errAlert, fbForm.firstChild);
                    if (submitButton) submitButton.disabled = false;
                    isSubmitting = false;
                });
        });
    })();

    // ------------------ Contact form: reCAPTCHA Enterprise v3 + AJAX submit ------------------
    (function () {
        var form = document.getElementById('contactForm');
        if (!form) return;

        function clearFormAlerts() {
            var alerts = form.querySelectorAll('.form-alert');
            Array.prototype.forEach.call(alerts, function (a) { a.remove(); });
        }

        var emailInput = document.getElementById('cf-email');
        var recaptchaTokenField = document.getElementById('g-recaptcha-response');
        var isSubmitting = false;

        window.onRecaptchaSuccess = function (token) {
            if (recaptchaTokenField) {
                recaptchaTokenField.value = token || '';
            }
        };

        window.onRecaptchaExpired = function () {
            if (recaptchaTokenField) {
                recaptchaTokenField.value = '';
            }
        };

        function submitFormData() {
            clearFormAlerts();
            var submitButton = form.querySelector('button[type="submit"]'); if (submitButton) submitButton.disabled = true;
            var email = emailInput && emailInput.value ? emailInput.value.trim() : '';
            if (!email) { form.insertBefore(createAlert('error', 'Missing email', 'Please enter your email address.'), form.firstChild); if (submitButton) submitButton.disabled = false; isSubmitting = false; return; }

            var fd = new FormData(form);
            var action = form.getAttribute('action') || window.location.href;
            fetch(action, { method: 'POST', body: fd, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
                .then(function (res) { return res.json().then(function (data) { if (!res.ok) { var err = new Error('Submission failed'); err.data = data; throw err; } return data; }); })
                .then(function (data) {
                    var successAlert = createAlert('success', 'Message sent', data.message || 'Thank you for your message. We will be in touch soon.');
                    successAlert.classList.add('aizap-alert--floating');
                    var card = form.closest('.aizap-contact__card'); if (card) card.insertBefore(successAlert, card.firstChild); else form.insertBefore(successAlert, form.firstChild);
                    var contactSection = document.getElementById('contact');
                    if (contactSection && contactSection.scrollIntoView) {
                        contactSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                    form.reset(); if (submitButton) submitButton.disabled = false;
                    if (recaptchaTokenField) recaptchaTokenField.value = '';
                    isSubmitting = false;
                    window.setTimeout(function () { if (successAlert.parentNode) successAlert.parentNode.removeChild(successAlert); }, 6000);
                })
                .catch(function (error) {
                    var messages = [];
                    if (error.data && error.data.errors) { Object.keys(error.data.errors).forEach(function (k) { messages = messages.concat(error.data.errors[k]); }); }
                    else if (error.data && error.data.message) messages = [error.data.message]; else if (error.message) messages = [error.message];
                    var errAlert = createAlert('error', "Couldn't send message", null, messages);
                    form.insertBefore(errAlert, form.firstChild); if (submitButton) submitButton.disabled = false; isSubmitting = false;
                });
        }

        form.addEventListener('submit', function (ev) {
            ev.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;
            clearFormAlerts();
            var submitButton = form.querySelector('button[type="submit"]'); if (submitButton) submitButton.disabled = true;
            var email = emailInput && emailInput.value ? emailInput.value.trim() : '';
            if (!email) { form.insertBefore(createAlert('error', 'Missing email', 'Please enter your email address.'), form.firstChild); if (submitButton) submitButton.disabled = false; isSubmitting = false; return; }

            var currentToken = recaptchaTokenField ? (recaptchaTokenField.value || '').trim() : '';
            if (!currentToken) {
                form.insertBefore(createAlert('error', 'reCAPTCHA required', 'Please complete the reCAPTCHA before sending your message.'), form.firstChild);
                if (submitButton) submitButton.disabled = false;
                isSubmitting = false;
                return;
            }

            submitFormData();
        });

    })();

    // ------------------ Feedback list sizing helper ------------------
    (function () {
        var VISIBLE_COUNT = 6;
        var body = document.querySelector('.feedback-table__body');
        if (!body) return;

        function recalc() {
            var cards = Array.prototype.filter.call(body.querySelectorAll('.review-card'), function (el) { return !el.classList.contains('review-card--empty'); });
            if (cards.length <= VISIBLE_COUNT) { body.style.maxHeight = 'none'; body.style.overflowY = 'visible'; return; }
            var cutoffIndex = Math.min(VISIBLE_COUNT, cards.length) - 1;
            var firstRect = cards[0].getBoundingClientRect();
            var cutoffRect = cards[cutoffIndex].getBoundingClientRect();
            var height = Math.ceil(cutoffRect.bottom - firstRect.top) + 8;
            body.style.maxHeight = height + 'px'; body.style.overflowY = 'auto';
        }

        recalc();
        window.addEventListener('resize', recalc);
    })();

})();
