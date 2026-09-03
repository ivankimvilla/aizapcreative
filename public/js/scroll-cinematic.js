(function () {
    'use strict';

    document.documentElement.classList.remove('no-js');

    var prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    var canHoverFine = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    function initLoader() {
        var loader = document.getElementById('pageLoader');
        if (!loader) return;
        var mark = loader.querySelector('.page-loader__mark');
        var bar = loader.querySelector('.page-loader__bar span');
        var progress = 0;
        var tick;

        function setProgress(value) {
            progress = Math.min(value, 100);
            if (mark) mark.setAttribute('data-progress', Math.round(progress));
            if (bar) bar.style.setProperty('--progress', progress + '%');
        }

        function hide() {
            clearInterval(tick);
            setProgress(100);
            setTimeout(function () {
                loader.classList.add('is-hidden');
            }, 150);
        }

        if (prefersReducedMotion) {
            hide();
            return;
        }

        tick = setInterval(function () {
            setProgress(progress + (100 - progress) * 0.18 + 1);
        }, 90);

        if (document.readyState === 'complete') {
            hide();
        } else {
            window.addEventListener('load', hide);
            setTimeout(hide, 1400);
        }
    }

    function initHeroReveal() {
        var masthead = document.querySelector('.service-masthead');
        if (!masthead) return;
        var heading = masthead.querySelector('.service-masthead__title h1');
        if (!heading) {
            requestAnimationFrame(function () {
                masthead.classList.add('is-revealed');
            });
            return;
        }

        if (!heading.dataset.heroSplit) {
            var words = heading.textContent.trim().split(/\s+/);
            heading.innerHTML = words
                .map(function (word, i) {
                    return '<span class="hero-line"><span style="--w:' + i + '">' +
                        word + '</span></span>';
                })
                .join(' ');
            heading.dataset.heroSplit = 'true';
        }

        requestAnimationFrame(function () {
            requestAnimationFrame(function () {
                masthead.classList.add('is-revealed');
            });
        });
    }

    function initReveal() {
        var fadeItems = document.querySelectorAll('[data-reveal-fade]');
        var wipeItems = document.querySelectorAll(
            '.projects-grid > *, .video-grid > *, [data-reveal-wipe]'
        );

        fadeItems.forEach(function (el) { el.classList.add('reveal-fade'); });
        wipeItems.forEach(function (el) { el.classList.add('reveal-wipe'); });

        var items = Array.prototype.slice.call(fadeItems).concat(Array.prototype.slice.call(wipeItems));
        if (!items.length) return;

        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            items.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        items.forEach(function (el, i) {
            if (!el.style.getPropertyValue('--reveal-order')) {
                el.style.setProperty('--i', i % 8);
            }
        });

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    } else {
                        entry.target.classList.remove('is-visible');
                    }
                });
            },
            { threshold: 0.15, rootMargin: '0px 0px -8% 0px' }
        );

        items.forEach(function (el) { observer.observe(el); });
    }

    function initCategoryNav() {
        var items = document.querySelectorAll('.service-marquee__item');
        if (!items.length) return;

        var path = window.location.pathname.replace(/\/$/, '');

        items.forEach(function (item) {
            var href = item.getAttribute('href');
            if (!href) return;
            var normalized = href.replace(/\/$/, '');
            if (normalized && path.endsWith(normalized)) {
                item.classList.add('service-marquee__item--active');
            }
        });
    }

    function initMarqueeTouchPause() {
        var marquees = document.querySelectorAll('.service-marquee');
        if (!marquees.length) return;

        marquees.forEach(function (marquee) {
            var resumeTimer;

            function pause() {
                clearTimeout(resumeTimer);
                marquee.classList.add('is-paused');
            }

            function scheduleResume() {
                clearTimeout(resumeTimer);
                resumeTimer = setTimeout(function () {
                    marquee.classList.remove('is-paused');
                }, 1600);
            }

            marquee.addEventListener('touchstart', pause, { passive: true });
            marquee.addEventListener('touchend', scheduleResume, { passive: true });
        });
    }

    function initVideoHoverPreview() {
        if (!canHoverFine) return;

        var cards = document.querySelectorAll('.video-card');
        cards.forEach(function (card) {
            var video = card.querySelector('.video-card__thumb video');
            if (!video) return;

            card.addEventListener('mouseenter', function () {
                video.muted = true;
                var playPromise = video.play();
                if (playPromise && playPromise.catch) {
                    playPromise.catch(function () { });
                }
            });

            card.addEventListener('mouseleave', function () {
                video.pause();
                video.currentTime = 0;
            });
        });
    }

    function initVideoInViewPreview() {
        if (canHoverFine || !('IntersectionObserver' in window)) return;

        var videos = document.querySelectorAll('.video-card__thumb video');
        if (!videos.length) return;

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    var video = entry.target;
                    if (entry.isIntersecting) {
                        video.muted = true;
                        var playPromise = video.play();
                        if (playPromise && playPromise.catch) {
                            playPromise.catch(function () { });
                        }
                    } else {
                        video.pause();
                    }
                });
            },
            { threshold: 0.6 }
        );

        videos.forEach(function (video) { observer.observe(video); });
    }

    function initCardTilt() {
        if (!canHoverFine || prefersReducedMotion) return;

        var cards = document.querySelectorAll('.video-card');
        cards.forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var px = (e.clientX - rect.left) / rect.width - 0.5;
                var py = (e.clientY - rect.top) / rect.height - 0.5;
                card.style.setProperty('--tilt-y', (px * 5).toFixed(2) + 'deg');
                card.style.setProperty('--tilt-x', (py * -5).toFixed(2) + 'deg');
            });

            card.addEventListener('mouseleave', function () {
                card.style.setProperty('--tilt-x', '0deg');
                card.style.setProperty('--tilt-y', '0deg');
            });
        });
    }

    function initMagneticButtons() {
        if (!canHoverFine || prefersReducedMotion) return;

        var buttons = document.querySelectorAll('.btn-primary:not(.unified-service-card__cta)');
        buttons.forEach(function (btn) {
            btn.setAttribute('data-magnetic', '');

            btn.addEventListener('mousemove', function (e) {
                var rect = btn.getBoundingClientRect();
                var x = e.clientX - rect.left - rect.width / 2;
                var y = e.clientY - rect.top - rect.height / 2;
                btn.style.transform = 'translate(' + (x * 0.18).toFixed(1) + 'px,' + (y * 0.28).toFixed(1) + 'px)';
            });

            btn.addEventListener('mouseleave', function () {
                btn.style.transform = '';
            });
        });
    }

    function initAmbientParallax() {
        var glow = document.querySelector('.ambient-glow');
        if (!glow || prefersReducedMotion) return;

        var ticking = false;

        function update() {
            var shift = Math.min(window.scrollY * 0.15, 220);
            glow.style.setProperty('--glow-shift', shift + 'px');
            ticking = false;
        }

        window.addEventListener('scroll', function () {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        }, { passive: true });

        update();
    }

    function initFilters() {
        var grid = document.getElementById('sampleReelGrid');
        var buttons = document.querySelectorAll('.sample-reel-filter');
        if (!grid || !buttons.length) return;

        var cards = Array.prototype.slice.call(grid.children);

        function applyFilter(filter) {
            cards.forEach(function (card) {
                var matches = filter === 'all' || card.dataset.category === filter;

                if (matches) {
                    card.hidden = false;
                    requestAnimationFrame(function () {
                        card.classList.remove('is-filtered-out');
                    });
                } else {
                    card.classList.add('is-filtered-out');
                    window.setTimeout(function () {
                        if (card.classList.contains('is-filtered-out')) {
                            card.hidden = true;
                        }
                    }, 380);
                }
            });
        }

        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                buttons.forEach(function (b) {
                    b.classList.remove('sample-reel-filter--active');
                    b.setAttribute('aria-selected', 'false');
                });
                button.classList.add('sample-reel-filter--active');
                button.setAttribute('aria-selected', 'true');
                applyFilter(button.dataset.filter);
            });
        });
    }

    function initPageTransitions() {
        var veil = document.getElementById('pageTransitionVeil');
        if (!veil || prefersReducedMotion) return;

        document.addEventListener('click', function (e) {
            var link = e.target.closest('a[href]');
            if (!link) return;

            var href = link.getAttribute('href');
            if (
                !href ||
                href.charAt(0) === '#' ||
                link.target === '_blank' ||
                link.hasAttribute('download') ||
                href.indexOf('mailto:') === 0 ||
                href.indexOf('tel:') === 0 ||
                link.origin !== window.location.origin ||
                e.metaKey || e.ctrlKey || e.shiftKey || e.altKey
            ) {
                return;
            }

            e.preventDefault();
            veil.classList.add('is-active');
            setTimeout(function () {
                window.location.href = href;
            }, 500);
        });
    }

    function init() {
        initLoader();
        initHeroReveal();
        initReveal();
        initCategoryNav();
        initMarqueeTouchPause();
        initVideoHoverPreview();
        initVideoInViewPreview();
        initCardTilt();
        initMagneticButtons();
        initAmbientParallax();
        initFilters();
        initPageTransitions();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();