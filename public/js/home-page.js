(function () {
    'use strict';

    function createAlert(type, title, message, items) {
        var alert = document.createElement('div');
        alert.className = 'form-alert form-alert--' + type;
        alert.setAttribute('role', 'alert');

        var icon = document.createElement('div');
        icon.className = type === 'success' ? 'form-alert--success__icon' : 'form-alert__icon';
        icon.setAttribute('aria-hidden', 'true');
        icon.innerHTML = type === 'success'
            ? '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none"><path d="M12 2.5L23 21H1L12 2.5Z" fill="#ef4444"/><rect x="11" y="9" width="2" height="6" rx="1" fill="#fff"/><rect x="11" y="16.5" width="2" height="2" rx="1" fill="#fff"/></svg>';
        alert.appendChild(icon);

        var body = document.createElement('div');
        if (type === 'success') {
            body.className = 'form-alert--success__body';
        }

        var titleEl = document.createElement('div');
        titleEl.className = type === 'success' ? 'form-alert--success__title' : 'form-alert__title';
        titleEl.textContent = title;
        body.appendChild(titleEl);

        if (message) {
            var text = document.createElement('p');
            text.textContent = message;
            if (type === 'success') {
                text.className = 'form-alert--success__text';
            }
            body.appendChild(text);
        }

        if (items && items.length) {
            var list = document.createElement('ul');
            items.forEach(function (item) { var li = document.createElement('li'); li.textContent = item; list.appendChild(li); });
            body.appendChild(list);
        }

        alert.appendChild(body);
        return alert;
    }

    function createHeaderStatus(title, message) {
        var status = document.createElement('div');
        status.className = 'site-header__status';
        status.setAttribute('role', 'status');

        var icon = document.createElement('span');
        icon.className = 'site-header__status-icon';
        icon.setAttribute('aria-hidden', 'true');
        icon.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        status.appendChild(icon);

        var body = document.createElement('div');
        var titleEl = document.createElement('div');
        titleEl.className = 'site-header__status-title';
        titleEl.textContent = title;
        body.appendChild(titleEl);

        if (message) {
            var messageEl = document.createElement('p');
            messageEl.textContent = message;
            body.appendChild(messageEl);
        }

        status.appendChild(body);
        return status;
    }

    function getCsrfToken(form) {
        if (!form) return '';

        var tokenInput = form.querySelector('input[name="_token"]');
        if (tokenInput && tokenInput.value) {
            return tokenInput.value;
        }

        var metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag && metaTag.getAttribute('content')) {
            return metaTag.getAttribute('content');
        }

        return '';
    }

    (function () {
        var backdrop = document.getElementById('reviewModalBackdrop');
        var openBtn = document.getElementById('openReviewModalBtn');
        var closeBtn = document.getElementById('closeReviewModalBtn');
        var feedbackBody = document.querySelector('.feedback-table__body');
        var feedbackCount = document.getElementById('feedbackCount');
        var feedbackSummaryCount = document.getElementById('feedbackSummaryCount');

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

        if (openBtn) openBtn.addEventListener('click', function () { if (backdrop) backdrop.classList.add('is-open'); });
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        var fbForm = document.getElementById('feedbackForm');
        if (!fbForm) return;

        var isSubmitting = false;
        fbForm.addEventListener('submit', function (ev) {
            ev.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;
            var submitButton = fbForm.querySelector('button[type="submit"]');
            if (submitButton) submitButton.disabled = true;

            var fd = new FormData(fbForm);
            var action = fbForm.getAttribute('action') || window.location.href;
            var headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
            var csrfToken = getCsrfToken(fbForm);
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }
            fetch(action, {
                method: 'POST',
                body: fd,
                headers: headers,
                credentials: 'same-origin'
            })
                .then(function (res) {
                    return res.json().then(function (data) {
                        if (!res.ok) {
                            var err = new Error('Submission failed');
                            err.data = data;
                            throw err;
                        }
                        return data;
                    });
                })
                .then(function (data) {
                    var header = document.querySelector('.site-header');
                    var headerMessage = data.message || 'Thanks for sharing your experience.';

                    if (header) {
                        var existingStatus = header.querySelector('.site-header__status');
                        if (existingStatus) {
                            existingStatus.remove();
                        }

                        var headerStatus = createHeaderStatus('Feedback submitted', headerMessage);
                        header.appendChild(headerStatus);

                        window.setTimeout(function () {
                            headerStatus.style.opacity = '0';
                            headerStatus.style.transform = 'translateX(-50%) translateY(-4px)';
                        }, 4200);

                        window.setTimeout(function () {
                            if (headerStatus && headerStatus.parentNode) {
                                headerStatus.parentNode.removeChild(headerStatus);
                            }
                        }, 4450);
                    }

                    closeModal();
                    fbForm.reset();
                    if (!data.duplicate && data.feedback) {
                        appendFeedbackCard(data.feedback);
                        updateCounts();
                    }
                    if (submitButton) submitButton.disabled = false;
                    isSubmitting = false;
                })
                .catch(function (err) {
                    var errAlert = createAlert('error', "Couldn't submit feedback", err && err.message ? [err.message] : null);
                    fbForm.insertBefore(errAlert, fbForm.firstChild);
                    if (submitButton) submitButton.disabled = false;
                    isSubmitting = false;
                });
        });
    })();

    (function () {
        var form = document.getElementById('contactForm');
        if (!form) return;

        function clearFormAlerts() {
            var alerts = form.querySelectorAll('.form-alert');
            Array.prototype.forEach.call(alerts, function (a) { a.remove(); });
        }

        var emailInput = document.getElementById('cf-email');
        var isSubmitting = false;

        var recaptchaCompleted = false;

        window.onRecaptchaSuccess = function (token) {
            recaptchaCompleted = !!token;
        };

        window.onRecaptchaExpired = function () {
            recaptchaCompleted = false;
        };

        function getWidgetToken() {
            try {
                if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && grecaptcha.enterprise.getResponse) {
                    return (grecaptcha.enterprise.getResponse() || '').trim();
                }
            } catch (e) { }
            return '';
        }

        function submitFormData() {
            clearFormAlerts();
            var submitButton = form.querySelector('button[type="submit"]'); if (submitButton) submitButton.disabled = true;
            var email = emailInput && emailInput.value ? emailInput.value.trim() : '';
            if (!email) { form.insertBefore(createAlert('error', 'Missing email', 'Please enter your email address.'), form.firstChild); if (submitButton) submitButton.disabled = false; isSubmitting = false; return; }

            var fd = new FormData(form);
            var action = form.getAttribute('action') || window.location.href;
            var headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
            var csrfToken = getCsrfToken(form);
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
            }
            fetch(action, { method: 'POST', body: fd, headers: headers, credentials: 'same-origin' })
                .then(function (res) { return res.json().then(function (data) { if (!res.ok) { var err = new Error('Submission failed'); err.data = data; throw err; } return data; }); })
                .then(function (data) {
                    var header = document.querySelector('.site-header');
                    var message = data.message || 'Thank you for your message. We will be in touch soon.';

                    if (header) {
                        var existingStatus = header.querySelector('.site-header__status');
                        if (existingStatus) {
                            existingStatus.remove();
                        }

                        var headerStatus = createHeaderStatus('Message sent', message);
                        header.appendChild(headerStatus);

                        window.setTimeout(function () {
                            headerStatus.style.opacity = '0';
                            headerStatus.style.transform = 'translateX(-50%) translateY(-4px)';
                        }, 4200);

                        window.setTimeout(function () {
                            if (headerStatus && headerStatus.parentNode) {
                                headerStatus.parentNode.removeChild(headerStatus);
                            }
                        }, 4450);
                    } else {
                        var successAlert = createAlert('success', 'Message sent', message);
                        successAlert.classList.add('aizap-alert--floating');
                        var card = form.closest('.aizap-contact__card');
                        if (card) {
                            card.insertBefore(successAlert, card.firstChild);
                        } else {
                            form.insertBefore(successAlert, form.firstChild);
                        }
                        window.setTimeout(function () {
                            if (successAlert.parentNode) {
                                successAlert.parentNode.removeChild(successAlert);
                            }
                        }, 6000);
                    }

                    var contactSection = document.getElementById('contact');
                    if (contactSection && contactSection.scrollIntoView) {
                        contactSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                    form.reset();
                    if (submitButton) submitButton.disabled = false;
                    recaptchaCompleted = false;
                    if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && grecaptcha.enterprise.reset) {
                        grecaptcha.enterprise.reset();
                    }
                    isSubmitting = false;
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

            var hasToken = recaptchaCompleted || !!getWidgetToken();

            if (!hasToken) {
                form.insertBefore(createAlert('error', 'reCAPTCHA required', 'Please complete the reCAPTCHA before sending your message.'), form.firstChild);
                if (submitButton) submitButton.disabled = false;
                isSubmitting = false;
                return;
            }

            submitFormData();
        });

    })();

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