(function () {
    function createSuccessToast(message) {
        if (typeof window.showToast === 'function') {
            window.showToast(message, 'success');
            return;
        }

        var toast = document.createElement('div');
        toast.className = 'toast toast--success';
        toast.setAttribute('role', 'status');
        toast.textContent = message;
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(8px)';
        toast.style.transition = 'opacity 0.25s ease, transform 0.25s ease';

        var container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.style.position = 'fixed';
            container.style.right = '20px';
            container.style.bottom = '20px';
            container.style.zIndex = '9999';
            container.style.display = 'flex';
            container.style.flexDirection = 'column';
            container.style.gap = '12px';
            document.body.appendChild(container);
        }

        container.appendChild(toast);

        requestAnimationFrame(function () {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });

        setTimeout(function () {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(8px)';
            setTimeout(function () {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 220);
        }, 4200);
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

    function showQuoteSuccessState(message) {
        var header = document.querySelector('.site-header');
        if (header) {
            var existingStatus = header.querySelector('.site-header__status');
            if (existingStatus) {
                existingStatus.remove();
            }

            var headerStatus = createHeaderStatus('Request sent', message);
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

        createSuccessToast(message);
    }

    function getRecaptchaInput() {
        return document.querySelector('input[name="g-recaptcha-response"]');
    }

    function getRecaptchaSiteKey() {
        var input = getRecaptchaInput();
        return input ? input.dataset.sitekey : '';
    }

    function executeRecaptcha(action, retryCount) {
        retryCount = retryCount || 0;

        return new Promise(function (resolve, reject) {
            var siteKey = getRecaptchaSiteKey();
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

            if (retryCount < 2) {
                window.setTimeout(function () {
                    executeRecaptcha(action, retryCount + 1).then(resolve).catch(reject);
                }, 120);
                return;
            }

            reject(new Error('reCAPTCHA is not loaded.'));
        });
    }

    var quoteSection = document.querySelector('.quote-section');
    var closeBtn = quoteSection ? quoteSection.querySelector('.quote-section__close') : null;
    var quotePackageName = document.getElementById('quotePackageName');
    var quotePackageDescription = document.getElementById('quotePackageDescription');
    var quotePackageFeatures = document.getElementById('quotePackageFeatures');
    var serviceSelect = document.getElementById('quote_service');

    var serviceDetails = {
        'AI Commercial Ads': {
            packageName: 'AI Commercial Ads',
            description: 'High-converting cinematic advertisements for brands.',
            features: [
                '30-60 sec AI commercial',
                'Script assistance',
                'Cinematic quality',
                'Fast turnaround',
                'Multiple formats',
                'Commercial use'
            ]
        },
        'Product Advertising': {
            packageName: 'Product Advertising',
            description: 'Showcase your product with premium AI visuals.',
            features: [
                'Product-focused videos',
                'Social media ready',
                'Multiple aspect ratios',
                'High-quality visuals',
                'Engaging storytelling',
                'Commercial use'
            ]
        },
        'Storytelling & Short Films': {
            packageName: 'Storytelling & Short Films',
            description: 'Emotional AI films that connect with audiences.',
            features: [
                'Story development',
                'Cinematic scenes',
                'Character consistency',
                'Creative direction',
                'Background score',
                'Multiple revisions'
            ]
        },
        'Custom Projects': {
            packageName: 'Custom Projects',
            description: "Need something unique? We'll build it together.",
            features: [
                'Brand campaigns',
                'Music videos',
                'Explainer videos',
                'Social media content',
                'Creative concepts',
                'And more'
            ]
        }
    };

    function updateSelectionDisplay(service) {
        var details = serviceDetails[service] || {
            packageName: 'None selected',
            description: 'Choose a package to see details and pricing.',
            features: []
        };

        if (quotePackageName) {
            quotePackageName.textContent = details.packageName;
        }

        if (quotePackageDescription) {
            quotePackageDescription.textContent = details.description;
        }

        if (quotePackageFeatures) {
            quotePackageFeatures.innerHTML = details.features.map(function (feature) {
                return '<li>' + feature + '</li>';
            }).join('');
        }
    }

    function openQuoteSection(service) {
        if (quoteSection) {
            quoteSection.classList.remove('quote-section--hidden');
            document.body.classList.add('quote-modal-open');
        }

        if (serviceSelect && service) {
            serviceSelect.value = service;
        }

        updateSelectionDisplay(service);
    }

    function initializeQuoteSummary() {
        if (!serviceSelect) {
            return;
        }

        var oldService = quoteSection ? quoteSection.dataset.oldService : '';
        var service = oldService || serviceSelect.value;
        updateSelectionDisplay(service);
    }

    function closeQuoteSection() {
        if (quoteSection) {
            quoteSection.classList.add('quote-section--hidden');
            document.body.classList.remove('quote-modal-open');
        }
    }

    var triggers = document.querySelectorAll('[data-service]');
    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            var service = trigger.getAttribute('data-service');
            openQuoteSection(service);
        });
    });

    if (serviceSelect) {
        serviceSelect.addEventListener('change', function () {
            updateSelectionDisplay(serviceSelect.value);
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            closeQuoteSection();
        });
    }

    if (quoteSection) {
        quoteSection.addEventListener('click', function (event) {
            if (event.target === quoteSection) {
                closeQuoteSection();
            }
        });
    }

    initializeQuoteSummary();

    var quoteForm = document.getElementById('quoteForm');
    if (quoteForm) {
        var quoteSubmitting = false;

        quoteForm.addEventListener('submit', function (event) {
            if (quoteSubmitting) {
                event.preventDefault();
                return;
            }

            event.preventDefault();
            quoteSubmitting = true;

            var submitButton = quoteForm.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.dataset.originalText = submitButton.textContent;
                submitButton.textContent = 'Sending...';
            }

            var recaptchaInput = getRecaptchaInput();
            if (!recaptchaInput) {
                var errorMessage = document.createElement('div');
                errorMessage.className = 'form-alert form-alert--error';
                errorMessage.textContent = 'reCAPTCHA is not configured. Please refresh the page and try again.';
                quoteForm.insertBefore(errorMessage, quoteForm.firstChild);
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = submitButton.dataset.originalText || 'Send Request';
                }
                quoteSubmitting = false;
                return;
            }

            executeRecaptcha('quote').then(function (token) {
                recaptchaInput.value = token || '';

                var fd = new FormData(quoteForm);
                var action = quoteForm.getAttribute('action') || window.location.href;
                var headers = { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
                var csrfToken = document.querySelector('meta[name="csrf-token"]');

                if (csrfToken && csrfToken.getAttribute('content')) {
                    headers['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
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
                        var successMessage = data.message || 'Thank you for your request. We will be in touch soon.';
                        closeQuoteSection();
                        quoteForm.reset();
                        setTimeout(function () {
                            showQuoteSuccessState(successMessage);
                        }, 200);
                        quoteSubmitting = false;
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = submitButton.dataset.originalText || 'Send Request';
                        }
                    })
                    .catch(function (error) {
                        var message = 'Unable to submit quote. Please try again.';
                        if (error.data && error.data.message) {
                            message = error.data.message;
                        } else if (error.message) {
                            message = error.message;
                        }

                        var errorMessage = document.createElement('div');
                        errorMessage.className = 'form-alert form-alert--error';
                        errorMessage.textContent = message;
                        quoteForm.insertBefore(errorMessage, quoteForm.firstChild);
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.textContent = submitButton.dataset.originalText || 'Send Request';
                        }
                        quoteSubmitting = false;
                    });
            }).catch(function (error) {
                var errorMessage = document.createElement('div');
                errorMessage.className = 'form-alert form-alert--error';
                errorMessage.textContent = error && error.message ? error.message : 'Unable to verify reCAPTCHA.';
                quoteForm.insertBefore(errorMessage, quoteForm.firstChild);
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = submitButton.dataset.originalText || 'Send Request';
                }
                quoteSubmitting = false;
            });
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && quoteSection && !quoteSection.classList.contains('quote-section--hidden')) {
            closeQuoteSection();
        }
    });
})();