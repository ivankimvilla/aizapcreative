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

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && quoteSection && !quoteSection.classList.contains('quote-section--hidden')) {
            closeQuoteSection();
        }
    });
});