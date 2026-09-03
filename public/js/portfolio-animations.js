(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function initCurtain() {
        var curtain = document.querySelector('[data-intro-curtain]');
        if (!curtain) return;

        var alreadyPlayed = false;
        try {
            alreadyPlayed = sessionStorage.getItem('aizapIntroPlayed') === '1';
        } catch (e) {

        }

        if (alreadyPlayed || reduceMotion) {
            curtain.classList.add('is-done');
            return;
        }

        var rightPanel = curtain.querySelector('.intro-curtain__panel--r');

        requestAnimationFrame(function () {
            setTimeout(function () {
                curtain.classList.add('is-open');
            }, 180);
        });

        function onDone(e) {
            if (rightPanel && e.target !== rightPanel) return;
            curtain.classList.add('is-done');
            try {
                sessionStorage.setItem('aizapIntroPlayed', '1');
            } catch (e2) { }
            curtain.removeEventListener('animationend', onDone);
        }

        curtain.addEventListener('animationend', onDone);

        setTimeout(function () {
            curtain.classList.add('is-done');
        }, 2500);
    }

    function initReveal() {
        var items = document.querySelectorAll('[data-reveal]');
        if (!items.length) return;

        if (!('IntersectionObserver' in window) || reduceMotion) {
            items.forEach(function (el) {
                el.classList.add('in-view');
            });
            return;
        }

        var io = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    } else {
                        entry.target.classList.remove('in-view');
                    }
                });
            },
            { threshold: 0.16, rootMargin: '0px 0px -8% 0px' }
        );

        items.forEach(function (el) {
            io.observe(el);
        });
    }

    function initParallax() {
        if (reduceMotion) return;

        var layer = document.querySelector('[data-parallax-layer]');
        var hero = document.querySelector('[data-parallax]');
        if (!layer || !hero) return;

        var ticking = false;

        function update() {
            var rect = hero.getBoundingClientRect();
            var progress = -rect.top / (rect.height || 1);
            var clamped = Math.max(-1, Math.min(1, progress));
            layer.style.transform = 'translateY(' + (clamped * 26).toFixed(1) + 'px)';
            ticking = false;
        }

        window.addEventListener(
            'scroll',
            function () {
                if (!ticking) {
                    requestAnimationFrame(update);
                    ticking = true;
                }
            },
            { passive: true }
        );

        update();
    }

    function initThumbLoading() {
        document.querySelectorAll('.project-tile.is-loading').forEach(function (tile) {
            var video = tile.querySelector('video');

            if (!video) {
                tile.classList.remove('is-loading');
                return;
            }

            if (video.readyState >= 2) {
                tile.classList.remove('is-loading');
                return;
            }

            var clear = function () {
                tile.classList.remove('is-loading');
            };

            video.addEventListener('loadeddata', clear, { once: true });
            video.addEventListener('error', clear, { once: true });

            setTimeout(clear, 4000);
        });
    }

    function initMagnetic() {
        if (reduceMotion) return;

        document.querySelectorAll('[data-magnetic]').forEach(function (btn) {
            btn.addEventListener('mousemove', function (e) {
                var rect = btn.getBoundingClientRect();
                var x = e.clientX - rect.left - rect.width / 2;
                var y = e.clientY - rect.top - rect.height / 2;
                btn.style.transform = 'translate(' + (x * 0.18).toFixed(1) + 'px, ' + (y * 0.28).toFixed(1) + 'px)';
            });

            btn.addEventListener('mouseleave', function () {
                btn.style.transform = 'translate(0, 0)';
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initCurtain();
        initReveal();
        initParallax();
        initThumbLoading();
        initMagnetic();
    });
})();