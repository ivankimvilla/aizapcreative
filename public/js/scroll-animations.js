/* ==========================================================================
   Aizap Creatives — Cinematic Animation & Interaction Layer (JS)
   Pairs with css/animations.css. Load after your other page scripts.
   Vanilla JS, no dependencies.
   ========================================================================== */
(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ----------------------------------------------------------------
       0. Reveal the app shell once the preloader is done (or immediately
          if no preloader is present / it's already hidden).
       ---------------------------------------------------------------- */
    function revealApp() {
        var app = document.getElementById('app-content');
        if (app) app.classList.add('az-app-ready');
    }
    var preloader = document.getElementById('preloader');
    if (preloader) {
        // If preloader.js removes/hides itself, watch for that; otherwise fall back to a timer.
        var mo = new MutationObserver(function () {
            var hidden = preloader.classList.contains('is-hidden') ||
                preloader.classList.contains('hidden') ||
                preloader.style.display === 'none' ||
                preloader.style.opacity === '0';
            if (hidden) { revealApp(); mo.disconnect(); }
        });
        mo.observe(preloader, { attributes: true, attributeFilter: ['class', 'style'] });
        // Safety net in case the preloader never toggles a watched attribute.
        setTimeout(revealApp, 2500);
    } else {
        revealApp();
    }

    /* ----------------------------------------------------------------
       1. Auto-tag reveal targets that don't already opt in with
          data-reveal, so existing markup gets motion for free.
       ---------------------------------------------------------------- */
    function autoTag(selector, direction) {
        document.querySelectorAll(selector).forEach(function (el) {
            if (!el.hasAttribute('data-reveal')) el.setAttribute('data-reveal', direction || 'up');
        });
    }

    autoTag('.hero-copy', 'left');
    autoTag('.hero-panels', 'right');
    autoTag('.formats-ticker', 'fade');
    autoTag('.projects-header', 'up');
    autoTag('.projects-grid .project-card', 'up');
    autoTag('.tools-header', 'up');
    autoTag('.process-icons-row', 'fade');
    autoTag('.section-heading', 'up');
    autoTag('.process-steps .process-step-card', 'up');
    autoTag('.process-cta', 'zoom');
    autoTag('.feedback-header', 'left');
    autoTag('.rating-summary--panel', 'up');
    autoTag('.feedback-panel', 'right');
    autoTag('#feedbackBody .review-card', 'up');
    autoTag('.aizap-contact__left', 'left');
    autoTag('.aizap-contact__right', 'right');

    /* Stagger siblings inside common containers so cards cascade in. */
    function stagger(containerSelector, itemSelector, stepMs) {
        document.querySelectorAll(containerSelector).forEach(function (container) {
            var items = container.querySelectorAll(itemSelector);
            items.forEach(function (el, i) {
                el.style.setProperty('--az-delay', Math.min(i * stepMs, stepMs * 8) + 'ms');
            });
        });
    }
    stagger('.projects-grid', '.project-card', 90);
    stagger('.process-steps', '.process-step-card', 90);
    stagger('#feedbackBody', '.review-card', 70);

    /* ----------------------------------------------------------------
       2. IntersectionObserver — reveal on scroll
       Two flavors:
       - "once" (default): most sections play their entrance once and stay put.
       - "repeat": the feedback section replays its entrance every time it
         crosses into/out of view, so scrolling back up re-triggers it too.
         Mark any element with data-reveal-repeat to opt into this.
       ---------------------------------------------------------------- */
    var REPEAT_SELECTOR = '.hero-copy, .hero-panels, .feedback-header, .rating-summary--panel, .feedback-panel, #feedbackBody .review-card, .process-icons-row, .rating-summary';
    document.querySelectorAll(REPEAT_SELECTOR).forEach(function (el) {
        el.setAttribute('data-reveal-repeat', '');
    });

    if (reduceMotion) {
        document.querySelectorAll('[data-reveal]').forEach(function (el) {
            el.classList.add('is-visible');
        });
    } else if ('IntersectionObserver' in window) {
        // One-time reveal for general page sections.
        var revealObserver = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });

        // Repeatable reveal — toggles both ways, so it replays on scroll up too.
        var repeatObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                entry.target.classList.toggle('is-visible', entry.isIntersecting);
            });
        }, { threshold: 0.18, rootMargin: '0px 0px -6% 0px' });

        document.querySelectorAll('[data-reveal]').forEach(function (el) {
            if (el.hasAttribute('data-reveal-repeat')) {
                repeatObserver.observe(el);
            } else {
                revealObserver.observe(el);
            }
        });

        // Elements without data-reveal that still need the repeat behaviour.
        document.querySelectorAll('[data-reveal-repeat]:not([data-reveal])').forEach(function (el) {
            repeatObserver.observe(el);
        });
    } else {
        document.querySelectorAll('[data-reveal]').forEach(function (el) {
            el.classList.add('is-visible');
        });
    }

    /* ----------------------------------------------------------------
       3. Animated rating number + bar widths, once visible
       ---------------------------------------------------------------- */
    function animateCount(el, target, duration) {
        var start = 0;
        var startTime = null;
        var decimals = (String(target).split('.')[1] || '').length;
        function step(ts) {
            if (!startTime) startTime = ts;
            var progress = Math.min((ts - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var value = start + (target - start) * eased;
            el.textContent = value.toFixed(decimals);
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target.toFixed(decimals);
        }
        requestAnimationFrame(step);
    }

    var ratingPanel = document.querySelector('.rating-summary--panel');
    if (ratingPanel) {
        var numberEl = ratingPanel.querySelector('.rating-summary__number');
        var targetRating = numberEl ? (parseFloat(numberEl.getAttribute('data-target') || numberEl.textContent) || 0) : 0;
        if (numberEl && !numberEl.getAttribute('data-target')) numberEl.setAttribute('data-target', targetRating);
        var barFills = ratingPanel.querySelectorAll('.rating-bar-row__fill');
        var isCounted = false;

        if (reduceMotion) {
            barFills.forEach(function (fill) {
                fill.style.setProperty('--az-target-width', fill.style.width || '0%');
            });
        } else if ('IntersectionObserver' in window) {
            // Replays every time the panel scrolls back into view (down or up).
            var countObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting && !isCounted) {
                        isCounted = true;
                        if (numberEl) animateCount(numberEl, targetRating, 900);
                        barFills.forEach(function (fill) {
                            fill.style.setProperty('--az-target-width', fill.style.width || '0%');
                        });
                    } else if (!entry.isIntersecting && isCounted) {
                        // Reset so the count-up and bar fill play again next time it appears.
                        isCounted = false;
                        if (numberEl) numberEl.textContent = (0).toFixed((String(targetRating).split('.')[1] || '').length);
                        barFills.forEach(function (fill) {
                            fill.style.setProperty('--az-target-width', '0%');
                        });
                    }
                });
            }, { threshold: 0.4 });
            countObserver.observe(ratingPanel);
        }
    }

    /* ----------------------------------------------------------------
       4. Subtle hero parallax on scroll
       ---------------------------------------------------------------- */
    var heroMedia = document.querySelector('.hero-panel-media');
    if (heroMedia && !reduceMotion) {
        var ticking = false;
        window.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            requestAnimationFrame(function () {
                var y = window.scrollY || window.pageYOffset;
                var offset = Math.min(y * 0.15, 80);
                heroMedia.style.transform = 'translateY(' + offset + 'px)';
                ticking = false;
            });
        }, { passive: true });
    }

    /* ----------------------------------------------------------------
       5. Hover-to-play video previews on project cards
       ---------------------------------------------------------------- */
    document.querySelectorAll('.project-card').forEach(function (card) {
        var video = card.querySelector('video');
        if (!video) return;
        video.muted = true;
        video.loop = true;
        video.playsInline = true;

        card.addEventListener('mouseenter', function () {
            var playPromise = video.play();
            if (playPromise && playPromise.catch) playPromise.catch(function () { });
        });
        card.addEventListener('mouseleave', function () {
            video.pause();
            try { video.currentTime = 0; } catch (e) { }
        });
        // Touch devices: tap toggles play/pause instead of relying on hover.
        card.addEventListener('touchstart', function () {
            if (video.paused) {
                var p = video.play();
                if (p && p.catch) p.catch(function () { });
            } else {
                video.pause();
            }
        }, { passive: true });
    });

    /* ----------------------------------------------------------------
       6. Review modal — "buskag" burst reveal from the clicked button,
          smooth reverse-close, safe alongside any existing listeners.
       ---------------------------------------------------------------- */
    var reviewBackdrop = document.getElementById('reviewModalBackdrop');
    var openReviewBtn = document.getElementById('openReviewModalBtn');
    var closeReviewBtn = document.getElementById('closeReviewModalBtn');
    var reviewModalPanel = reviewBackdrop ? reviewBackdrop.querySelector('.review-modal') : null;

    function setBurstOrigin(fromEl) {
        if (!reviewModalPanel || !fromEl) return;
        var btnRect = fromEl.getBoundingClientRect();
        var modalRect = reviewModalPanel.getBoundingClientRect();

        // If the modal has no size yet (e.g. display:none in the site's own
        // CSS rather than opacity/visibility), fall back to the button's
        // position relative to the viewport so it still feels intentional.
        var w = modalRect.width || window.innerWidth;
        var h = modalRect.height || window.innerHeight;
        var left = modalRect.width ? modalRect.left : 0;
        var top = modalRect.width ? modalRect.top : 0;

        var originX = btnRect.left + btnRect.width / 2;
        var originY = btnRect.top + btnRect.height / 2;

        var relX = ((originX - left) / w) * 100;
        var relY = ((originY - top) / h) * 100;

        reviewModalPanel.style.setProperty('--az-origin-x', relX + '%');
        reviewModalPanel.style.setProperty('--az-origin-y', relY + '%');
    }

    function openReviewModal(e) {
        if (!reviewBackdrop) return;
        if (e && e.currentTarget) setBurstOrigin(e.currentTarget);
        reviewBackdrop.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function closeReviewModal() {
        if (!reviewBackdrop) return;
        reviewBackdrop.classList.remove('is-open');
        document.body.style.overflow = '';
    }
    if (openReviewBtn) openReviewBtn.addEventListener('click', openReviewModal);
    if (closeReviewBtn) closeReviewBtn.addEventListener('click', closeReviewModal);
    if (reviewBackdrop) {
        reviewBackdrop.addEventListener('click', function (e) {
            if (e.target === reviewBackdrop) closeReviewModal();
        });
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeReviewModal();
    });

    /* ----------------------------------------------------------------
       7. Ripple effect on primary buttons
       ---------------------------------------------------------------- */
    var rippleSelectors = '.btn, .process-cta__button, .aizap-form__submit, .feedback-submit, .rating-summary__cta';
    document.querySelectorAll(rippleSelectors).forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (reduceMotion) return;
            var rect = btn.getBoundingClientRect();
            var ripple = document.createElement('span');
            var size = Math.max(rect.width, rect.height);
            ripple.className = 'az-ripple';
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
            btn.appendChild(ripple);
            setTimeout(function () { ripple.remove(); }, 650);
        });
    });

    /* ----------------------------------------------------------------
       8. Premium 3D tilt-on-hover for review cards & project cards
       ---------------------------------------------------------------- */
    function enableTilt(selector, strength) {
        if (reduceMotion) return;
        var isCoarse = window.matchMedia('(pointer: coarse)').matches;
        if (isCoarse) return; // skip on touch devices

        document.querySelectorAll(selector).forEach(function (card) {
            card.style.transformStyle = 'preserve-3d';
            card.style.willChange = 'transform';

            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var px = (e.clientX - rect.left) / rect.width - 0.5;
                var py = (e.clientY - rect.top) / rect.height - 0.5;
                var rotX = (py * -strength).toFixed(2);
                var rotY = (px * strength).toFixed(2);
                card.style.transform =
                    'translateY(-6px) perspective(900px) rotateX(' + rotX + 'deg) rotateY(' + rotY + 'deg)';
            });
            card.addEventListener('mouseleave', function () {
                card.style.transform = '';
            });
        });
    }
    enableTilt('#feedbackBody .review-card', 6);
    enableTilt('.projects-grid .project-card', 4);

    /* ----------------------------------------------------------------
       10. Instant "sending" feedback on form submit. The native POST
           still happens (page navigates/reloads as normal) — this just
           gives the button an immediate animated response so it never
           feels like a dead click while the request is in flight.
       ---------------------------------------------------------------- */
    ['feedbackForm', 'contactForm'].forEach(function (formId) {
        var form = document.getElementById(formId);
        if (!form) return;
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type="submit"]');
            if (btn) btn.classList.add('is-sending');
            // If validation fails server-side the browser will navigate back
            // here anyway, so there's no need to manually clear the class.
        });
    });

    /* ----------------------------------------------------------------
       11. Success celebration toast. Purely opt-in: it only fires if an
           element with id="reviewSuccessToast" exists AND carries the
           "is-active" class server-side (i.e. your controller flashed a
           success flag and the blade template rendered the class). See
           the accompanying blade snippet for how that flag is read.
       ---------------------------------------------------------------- */
    var successToast = document.getElementById('reviewSuccessToast');
    if (successToast && successToast.classList.contains('is-active')) {
        var closeToast = function () {
            successToast.classList.remove('is-active');
        };
        var autoDismiss = setTimeout(closeToast, 4000);
        successToast.addEventListener('click', function () {
            clearTimeout(autoDismiss);
            closeToast();
        });
    }

    /* ----------------------------------------------------------------
       12. Contact slideshow crossfade
       ---------------------------------------------------------------- */
    var slides = document.querySelectorAll('.aizap-contact__slide');
    if (slides.length > 1) {
        var current = 0;
        slides.forEach(function (s, i) { s.classList.toggle('is-active', i === 0); });
        if (!reduceMotion) {
            setInterval(function () {
                slides[current].classList.remove('is-active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('is-active');
            }, 3200);
        }
    }
})();