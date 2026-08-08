function getRecaptchaInput() {
    return document.querySelector('input[name="g-recaptcha-response"]');
}

function getRecaptchaSiteKey() {
    var input = getRecaptchaInput();
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

document.addEventListener('DOMContentLoaded', function () {
    var serviceSelect = document.getElementById('quote_service');
    var quotePackageName = document.getElementById('quotePackageName');
    var quotePackageDescription = document.getElementById('quotePackageDescription');
    var quotePackageFeatures = document.getElementById('quotePackageFeatures');
    var quoteSection = document.querySelector('.quote-section');
    var closeBtn = quoteSection ? quoteSection.querySelector('.quote-section__close') : null;

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
                'Commercial use',
            ],
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
                'Commercial use',
            ],
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
                'Multiple revisions',
            ],
        },
        'Custom Project': {
            packageName: 'Custom Project',
            description: 'Need something unique? We’ll build it together.',
            features: [
                'Brand campaigns',
                'Music videos',
                'Explainer videos',
                'Social media content',
                'Creative concepts',
                'And more',
            ],
        },
    };

    function updateSelectionDisplay(service) {
        var details = serviceDetails[service] || {
            packageName: 'None selected',
            description: 'Choose a package to see details and pricing.',
            features: [],
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

    // Keep the "Selected package" display in sync with the Project Type dropdown
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
            }

            var recaptchaInput = getRecaptchaInput();
            if (!recaptchaInput) {
                var errorMessage = document.createElement('div');
                errorMessage.className = 'form-alert form-alert--error';
                errorMessage.textContent = 'reCAPTCHA is not configured. Please refresh the page and try again.';
                quoteForm.insertBefore(errorMessage, quoteForm.firstChild);
                if (submitButton) {
                    submitButton.disabled = false;
                }
                quoteSubmitting = false;
                return;
            }

            executeRecaptcha('quote').then(function (token) {
                recaptchaInput.value = token || '';
                quoteForm.submit();
            }).catch(function (error) {
                var errorMessage = document.createElement('div');
                errorMessage.className = 'form-alert form-alert--error';
                errorMessage.textContent = error && error.message ? error.message : 'Unable to verify reCAPTCHA.';
                quoteForm.insertBefore(errorMessage, quoteForm.firstChild);
                if (submitButton) {
                    submitButton.disabled = false;
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
});