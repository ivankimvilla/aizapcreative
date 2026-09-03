(function () {
    "use strict";

    var reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    var revealTargets = document.querySelectorAll(".about-hero-block, .value-strip, .impact-strip");

    if ("IntersectionObserver" in window && !reduceMotion) {
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("in-view");
                } else {
                    entry.target.classList.remove("in-view");
                }
            });
        }, { threshold: 0.2, rootMargin: "0px 0px -60px 0px" });

        revealTargets.forEach(function (el) {
            revealObserver.observe(el);
        });
    } else {
        revealTargets.forEach(function (el) {
            el.classList.add("in-view");
        });
    }

    if (reduceMotion) {
        return;
    }

    var counters = document.querySelectorAll(".impact-number");
    var originalValues = new WeakMap();

    counters.forEach(function (el) {
        originalValues.set(el, el.textContent.trim());
    });

    function animateCount(el) {
        var raw = originalValues.get(el) || el.textContent.trim();
        var match = raw.match(/^([\d.]+)(.*)$/);

        if (!match) {
            return;
        }

        var end = parseFloat(match[1]);
        var suffix = match[2];
        var duration = 1400;
        var start = null;

        function tick(timestamp) {
            if (start === null) start = timestamp;
            var progress = Math.min((timestamp - start) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var current = Math.round(end * eased);

            el.textContent = current + suffix;

            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                el.textContent = raw;
            }
        }

        requestAnimationFrame(tick);
    }

    if ("IntersectionObserver" in window) {
        var countObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                }
            });
        }, { threshold: 0.6 });

        counters.forEach(function (el) {
            countObserver.observe(el);
        });
    }
})();