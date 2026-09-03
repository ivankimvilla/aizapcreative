(function () {
    var backdrop = document.getElementById('contactModalBackdrop');
    var modal = document.getElementById('contactModal');
    var fab = document.getElementById('openContactModalFab');
    var subjectInput = document.getElementById('contactSubject');
    if (!backdrop || !modal) return;

    if (backdrop.parentElement !== document.body) {
        document.body.appendChild(backdrop);
    }

    var openers = [
        document.getElementById('openContactModalBtn'),
        fab
    ].concat(Array.prototype.slice.call(document.querySelectorAll('[data-open-contact-modal]')));
    var closeBtn = document.getElementById('closeContactModalBtn');
    var lastFocused = null;

    function onKeydown(e) {
        if (e.key === 'Escape' || e.key === 'Esc') closeModal();
    }

    function setModalService(button) {
        if (!subjectInput) return;
        var serviceName = button && button.dataset && button.dataset.serviceTitle ? button.dataset.serviceTitle.trim() : '';
        subjectInput.value = serviceName || 'Home page inquiry';
    }

    function openModal(button) {
        if (button) {
            setModalService(button);
        }
        lastFocused = document.activeElement;
        backdrop.classList.add('is-open');
        document.body.classList.add('contact-modal-open');
        if (fab) fab.classList.add('is-active');

        var firstField = modal.querySelector('input, textarea');
        if (firstField) {
            window.requestAnimationFrame(function () {
                firstField.focus();
            });
        }
        document.addEventListener('keydown', onKeydown);
    }

    function closeModal(callback) {
        backdrop.classList.remove('is-open');
        document.body.classList.remove('contact-modal-open');
        if (fab) fab.classList.remove('is-active');
        document.removeEventListener('keydown', onKeydown);

        if (lastFocused && typeof lastFocused.focus === 'function') {
            lastFocused.focus();
        }

        window.setTimeout(function () {
            if (typeof callback === 'function') {
                callback();
            }
        }, 380);
    }

    window.closeHomeContactModal = closeModal;

    openers.forEach(function (btn) {
        if (!btn) return;
        btn.addEventListener('click', function () {
            var isOpen = backdrop.classList.contains('is-open');
            if (btn === fab && isOpen) {
                closeModal();
            } else {
                openModal(btn);
            }
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    backdrop.addEventListener('click', function (e) {
        if (e.target === backdrop) closeModal();
    });

    if (backdrop.classList.contains('is-open')) {
        document.body.classList.add('contact-modal-open');
        if (fab) fab.classList.add('is-active');
    }

    var revealTargets = document.querySelectorAll('[data-brief-reveal]');
    if (revealTargets.length && 'IntersectionObserver' in window) {
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                entry.target.classList.toggle('is-inview', entry.isIntersecting);
            });
        }, {
            threshold: 0.2,
            rootMargin: '0px 0px -8% 0px'
        });

        revealTargets.forEach(function (el) {
            revealObserver.observe(el);
        });
    } else {
        revealTargets.forEach(function (el) {
            el.classList.add('is-inview');
        });
    }

    var briefSection = document.getElementById('contact');
    var glow = briefSection ? briefSection.querySelector('.brief-cta__glow') : null;
    var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (briefSection && glow && !prefersReducedMotion && window.matchMedia && window.matchMedia('(hover: hover)').matches) {
        var rafId = null;
        var targetX = 0;
        var targetY = 0;

        briefSection.addEventListener('mousemove', function (e) {
            var rect = briefSection.getBoundingClientRect();
            var relX = (e.clientX - rect.left) / rect.width - 0.5;
            var relY = (e.clientY - rect.top) / rect.height - 0.5;
            targetX = relX * 24;
            targetY = relY * 16;

            if (rafId === null) {
                rafId = window.requestAnimationFrame(applyParallax);
            }
        });

        briefSection.addEventListener('mouseleave', function () {
            targetX = 0;
            targetY = 0;
            if (rafId === null) {
                rafId = window.requestAnimationFrame(applyParallax);
            }
        });

        function applyParallax() {
            glow.style.transform = 'translate(' + targetX.toFixed(1) + 'px, ' + targetY.toFixed(1) + 'px)';
            rafId = null;
        }
    }

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
            items.forEach(function (item) {
                var li = document.createElement('li');
                li.textContent = item;
                list.appendChild(li);
            });
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

    function getRecaptchaInput(form) {
        return form ? form.querySelector('input[name="g-recaptcha-response"]') : null;
    }

    function getRecaptchaSiteKey(form) {
        var input = getRecaptchaInput(form);
        return input ? input.dataset.sitekey : '';
    }

    function executeRecaptcha(action, form, retryCount) {
        retryCount = typeof retryCount === 'number' ? retryCount : 0;
        return new Promise(function (resolve, reject) {
            var siteKey = getRecaptchaSiteKey(form);
            if (!siteKey) {
                return reject(new Error('reCAPTCHA site key is missing.'));
            }

            function execute() {
                if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && typeof grecaptcha.enterprise.execute === 'function') {
                    grecaptcha.enterprise.execute(siteKey, { action: action }).then(resolve).catch(function (error) {
                        reject(error || new Error('reCAPTCHA execution failed.'));
                    });
                    return;
                }

                if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.execute === 'function') {
                    grecaptcha.execute(siteKey, { action: action }).then(resolve).catch(function (error) {
                        reject(error || new Error('reCAPTCHA execution failed.'));
                    });
                    return;
                }

                reject(new Error('reCAPTCHA is not loaded.'));
            }

            if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && typeof grecaptcha.enterprise.ready === 'function') {
                try {
                    grecaptcha.enterprise.ready(execute);
                } catch (e) {
                    reject(e);
                }
                return;
            }

            if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.ready === 'function') {
                try {
                    grecaptcha.ready(execute);
                } catch (e) {
                    reject(e);
                }
                return;
            }

            if (retryCount < 5) {
                window.setTimeout(function () {
                    executeRecaptcha(action, form, retryCount + 1).then(resolve).catch(reject);
                }, 200);
                return;
            }

            reject(new Error('reCAPTCHA is not loaded.'));
        });
    }

    function extractErrorMessages(error, fallback) {
        var messages = [];
        if (error && error.data && error.data.errors) {
            Object.keys(error.data.errors).forEach(function (k) {
                messages = messages.concat(error.data.errors[k]);
            });
        } else if (error && error.data && error.data.message) {
            messages = [error.data.message];
        } else if (error && error.message) {
            messages = [error.message];
        }
        if (!messages.length && fallback) {
            messages = [fallback];
        }
        return messages;
    }

    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        function clearFormAlerts() {
            var alerts = contactForm.querySelectorAll('.form-alert');
            Array.prototype.forEach.call(alerts, function (a) { a.remove(); });
        }

        var emailInput = document.getElementById('cf-email');
        var isSubmitting = false;

        function resetSubmitButton(button) {
            if (!button) return;
            button.disabled = false;
            button.textContent = button.dataset.originalText || 'Send Message';
        }

        function submitFormData(submitButton) {
            clearFormAlerts();
            if (submitButton) {
                submitButton.disabled = true;
            }

            var email = emailInput && emailInput.value ? emailInput.value.trim() : '';
            if (!email) {
                contactForm.insertBefore(createAlert('error', 'Missing email', 'Please enter your email address.'), contactForm.firstChild);
                resetSubmitButton(submitButton);
                isSubmitting = false;
                return;
            }

            var fd = new FormData(contactForm);
            var action = contactForm.getAttribute('action') || window.location.href;
            var headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
            var csrfToken = getCsrfToken(contactForm);
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
                    var message = data.message || 'Thank you for your message. We will be in touch soon.';

                    function showSuccessState() {
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
                            var card = contactForm.closest('.aizap-contact__card');
                            if (card) {
                                card.insertBefore(successAlert, card.firstChild);
                            } else {
                                contactForm.insertBefore(successAlert, contactForm.firstChild);
                            }
                            window.setTimeout(function () {
                                if (successAlert.parentNode) {
                                    successAlert.parentNode.removeChild(successAlert);
                                }
                            }, 6000);
                        }
                    }

                    function finalizeAfterClose() {
                        var contactSection = document.getElementById('contact');
                        if (contactSection && contactSection.scrollIntoView) {
                            contactSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                        contactForm.reset();
                        resetSubmitButton(submitButton);
                        if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise && grecaptcha.enterprise.reset) {
                            grecaptcha.enterprise.reset();
                        }
                        showSuccessState();
                    }

                    if (typeof window.closeHomeContactModal === 'function') {
                        window.closeHomeContactModal(finalizeAfterClose);
                    } else {
                        finalizeAfterClose();
                    }
                    isSubmitting = false;
                })
                .catch(function (error) {
                    var messages = extractErrorMessages(error, null);
                    var errAlert = createAlert('error', "Couldn't send message", null, messages);
                    contactForm.insertBefore(errAlert, contactForm.firstChild);
                    resetSubmitButton(submitButton);
                    isSubmitting = false;
                });
        }

        contactForm.addEventListener('submit', function (ev) {
            ev.preventDefault();
            if (isSubmitting) return;
            isSubmitting = true;
            clearFormAlerts();

            var submitButton = contactForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.dataset.originalText = submitButton.textContent;
                submitButton.textContent = 'Sending...';
            }

            var email = emailInput && emailInput.value ? emailInput.value.trim() : '';
            if (!email) {
                contactForm.insertBefore(createAlert('error', 'Missing email', 'Please enter your email address.'), contactForm.firstChild);
                resetSubmitButton(submitButton);
                isSubmitting = false;
                return;
            }

            executeRecaptcha('contact', contactForm).then(function (token) {
                var input = getRecaptchaInput(contactForm);
                if (input) {
                    input.value = token || '';
                }
                submitFormData(submitButton);
            }).catch(function (error) {
                contactForm.insertBefore(createAlert('error', 'reCAPTCHA failed', error && error.message ? error.message : 'Unable to verify reCAPTCHA.'), contactForm.firstChild);
                resetSubmitButton(submitButton);
                isSubmitting = false;
            });
        });
    }

    var successAlert = document.getElementById('contactSuccessAlert');
    if (successAlert) {
        var dismissSuccess = function () {
            successAlert.classList.add('is-hiding');
            window.setTimeout(function () {
                successAlert.remove();
            }, 400);
        };
        var autoDismissTimer = window.setTimeout(dismissSuccess, 6000);
        successAlert.addEventListener('click', function () {
            window.clearTimeout(autoDismissTimer);
            dismissSuccess();
        });
    }
})();