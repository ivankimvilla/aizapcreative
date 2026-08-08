(function () {
    function getRecaptchaSiteKey() {
        var input = document.getElementById('g-recaptcha-response');
        return input ? input.dataset.sitekey : '';
    }

    function executeRecaptcha(action) {
        return new Promise(function (resolve, reject) {
            var siteKey = getRecaptchaSiteKey();
            if (!siteKey) {
                return reject(new Error('reCAPTCHA site key is missing.'));
            }

            if (typeof grecaptcha === 'undefined' || !grecaptcha.enterprise || !grecaptcha.enterprise.execute) {
                return reject(new Error('reCAPTCHA is not loaded.'));
            }

            try {
                grecaptcha.enterprise.ready(function () {
                    grecaptcha.enterprise.execute(siteKey, { action: action }).then(function (token) {
                        resolve(token);
                    }).catch(function (error) {
                        reject(error || new Error('reCAPTCHA execution failed.'));
                    });
                });
            } catch (e) {
                reject(e);
            }
        });
    }

    function resetRecaptcha() {
        try {
            var input = document.getElementById('g-recaptcha-response');
            if (input) {
                input.value = '';
            }
            if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && grecaptcha.enterprise.reset) {
                grecaptcha.enterprise.reset();
            }
        } catch (e) { }
    }

    function clearAlerts(form) {
        var alerts = form.querySelectorAll('.form-alert, .recaptcha-error');
        Array.prototype.forEach.call(alerts, function (a) { a.remove(); });
    }

    function showRecaptchaError(form) {
        var wrapper = form.querySelector('.field--recaptcha');
        if (!wrapper) return;
        var el = document.createElement('div');
        el.className = 'recaptcha-error';
        el.setAttribute('role', 'alert');
        el.innerHTML = '<strong>reCAPTCHA required</strong><span>Please complete the reCAPTCHA<br>before sending your message.</span>';
        wrapper.appendChild(el);
    }

    function showGeneralError(form, messages) {
        var container = form.querySelector('.form-footer__left') || form;
        var el = document.createElement('div');
        el.className = 'form-alert form-alert--error';
        el.setAttribute('role', 'alert');
        var ul = document.createElement('ul');
        messages.forEach(function (msg) {
            var li = document.createElement('li');
            li.textContent = msg;
            ul.appendChild(li);
        });
        el.appendChild(ul);
        container.insertBefore(el, container.firstChild);
    }

    function createHeaderStatus(titleText, messageText) {
        var headerStatus = document.createElement('div');
        headerStatus.className = 'site-header__status';
        headerStatus.setAttribute('role', 'status');

        var icon = document.createElement('span');
        icon.className = 'site-header__status-icon';
        icon.setAttribute('aria-hidden', 'true');
        icon.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        headerStatus.appendChild(icon);

        var body = document.createElement('div');
        var title = document.createElement('div');
        title.className = 'site-header__status-title';
        title.textContent = titleText;

        var text = document.createElement('p');
        text.textContent = messageText;

        body.appendChild(title);
        body.appendChild(text);
        headerStatus.appendChild(body);

        return headerStatus;
    }

    function showSuccess(message) {
        var header = document.querySelector('.site-header');
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

            return;
        }

        var el = document.createElement('div');
        el.className = 'form-alert form-alert--success form-alert--toast';
        el.setAttribute('role', 'alert');

        var icon = document.createElement('span');
        icon.className = 'form-alert--success__icon';
        icon.innerHTML = '<svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 12 10 18 20 6"></polyline></svg>';

        var body = document.createElement('div');
        body.className = 'form-alert--success__body';

        var title = document.createElement('div');
        title.className = 'form-alert--success__title';
        title.textContent = 'Message sent';

        var text = document.createElement('div');
        text.className = 'form-alert--success__text';
        text.textContent = message;

        body.appendChild(title);
        body.appendChild(text);
        el.appendChild(icon);
        el.appendChild(body);
        document.body.appendChild(el);

        window.setTimeout(function () { if (el.parentNode) el.parentNode.removeChild(el); }, 6000);
    }

    var form = document.getElementById('contactForm');
    if (!form) return;

    var isSubmitting = false;

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (isSubmitting) return;

        clearAlerts(form);

        executeRecaptcha('contact').then(function (token) {
            var input = document.getElementById('g-recaptcha-response');
            if (input) {
                input.value = token || '';
            }

            isSubmitting = true;
            var submitButton = form.querySelector('.contact-submit');
            if (submitButton) submitButton.disabled = true;

            var fd = new FormData(form);
            var action = form.getAttribute('action') || window.location.href;

            fetch(action, {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
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
                    showSuccess(data.message || 'Thank you for your message. We will be in touch soon.');
                    form.reset();
                    resetRecaptcha();
                    isSubmitting = false;
                    if (submitButton) submitButton.disabled = false;
                })
                .catch(function (error) {
                    var messages = [];
                    if (error.data && error.data.errors) {
                        Object.keys(error.data.errors).forEach(function (key) {
                            if (key === 'g-recaptcha-response') {
                                showRecaptchaError(form);
                            } else {
                                messages = messages.concat(error.data.errors[key]);
                            }
                        });
                    } else if (error.data && error.data.message) {
                        messages = [error.data.message];
                    } else if (error.message) {
                        messages = [error.message];
                    }

                    if (messages.length) showGeneralError(form, messages);

                    resetRecaptcha();
                    isSubmitting = false;
                    if (submitButton) submitButton.disabled = false;
                });
        });
    })();