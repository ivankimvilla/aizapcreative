(function () {
    var PLAY_ICON_SVG = '<svg viewBox="0 0 24 24"><path d="M5 3v18l15-9z"/></svg>';

    var activeVideos = [];

    function registerVideo(video) {
        if (activeVideos.indexOf(video) === -1) {
            activeVideos.push(video);
        }
        video.addEventListener('play', function () {
            pauseOtherVideos(video);
        });
    }

    function clickShowLessButton() {
        var toggles = Array.prototype.slice.call(document.querySelectorAll('.video-grid__toggle'));
        for (var i = 0; i < toggles.length; i++) {
            var t = toggles[i];
            var expanded = t.getAttribute('aria-expanded') === 'true' || t.dataset.expanded === 'true';
            if (expanded) {
                t.dataset.silent = '1';
                t.click();
                setTimeout(function (el) { delete el.dataset.silent; }, 200, t);
                return true;
            }
        }

        var buttons = Array.prototype.slice.call(document.querySelectorAll('button'));
        for (var j = 0; j < buttons.length; j++) {
            var b = buttons[j];
            var txt = (b.textContent || '').trim().toLowerCase();
            if (txt.indexOf('show less') !== -1) {
                b.dataset.silent = '1';
                b.click();
                setTimeout(function (el) { delete el.dataset.silent; }, 200, b);
                return true;
            }
        }

        return false;
    }

    function clickShowLessForGrid(grid) {
        if (!grid) return clickShowLessButton();

        var toggleId = grid.dataset.loadMoreToggleId;
        if (toggleId) {
            var boundToggle = document.querySelector('.video-grid__toggle[data-for-grid="' + toggleId + '"]');
            if (boundToggle) {
                var expanded = boundToggle.getAttribute('aria-expanded') === 'true' || boundToggle.dataset.expanded === 'true';
                if (expanded) { boundToggle.dataset.silent = '1'; boundToggle.click(); setTimeout(function (el) { delete el.dataset.silent; }, 200, boundToggle); return true; }
            }
        }

        var parent = grid.parentNode;
        if (parent) {
            var parentToggle = parent.querySelector('.video-grid__toggle');
            if (parentToggle) {
                var exp = parentToggle.getAttribute('aria-expanded') === 'true' || parentToggle.dataset.expanded === 'true';
                if (exp) { parentToggle.dataset.silent = '1'; parentToggle.click(); setTimeout(function (el) { delete el.dataset.silent; }, 200, parentToggle); return true; }
            }

            var btn = Array.prototype.slice.call(parent.querySelectorAll('button')).find(function (b) {
                var t = (b.textContent || '').trim().toLowerCase();
                return t.indexOf('show less') !== -1;
            });
            if (btn) { btn.dataset.silent = '1'; btn.click(); setTimeout(function (el) { delete el.dataset.silent; }, 200, btn); return true; }
        }

        return clickShowLessButton();
    }

    function unregisterVideo(video) {
        var idx = activeVideos.indexOf(video);
        if (idx !== -1) {
            activeVideos.splice(idx, 1);
        }
    }

    function pauseOtherVideos(except) {
        activeVideos.forEach(function (v) {
            if (v !== except && !v.paused) {
                v.pause();
            }
        });
    }

    function getVideoSrc(video) {
        if (video.currentSrc) return video.currentSrc;
        if (video.getAttribute('src')) return video.src;
        var source = video.querySelector('source');
        return source ? source.src : '';
    }

    function setupThumb(thumb) {
        if (thumb.dataset.thumbBound === '1') return;
        thumb.dataset.thumbBound = '1';

        var video = thumb.querySelector('video');
        if (!video) {
            return;
        }

        var hasControls = video.hasAttribute('controls');
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'thumb-play-btn';
        btn.setAttribute('aria-label', 'Play video');
        btn.innerHTML = PLAY_ICON_SVG;
        thumb.appendChild(btn);

        thumb.classList.add('has-video');
        video.playsInline = true;
        video.preload = 'metadata';
        if (!hasControls) {
            video.removeAttribute('controls');
        }

        registerVideo(video);

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            video.pause();
            openVideoModal(video);
        });

        video.addEventListener('click', function () {
            if (video.hasAttribute('controls')) {
                return;
            }
            video.pause();
            openVideoModal(video);
        });

        video.addEventListener('play', function () {
            btn.classList.add('is-hidden');
        });

        video.addEventListener('pause', function () {
            btn.classList.remove('is-hidden');
        });
    }

    function openImageModal(src) {
        var backdrop = document.createElement('div');
        backdrop.className = 'project-image-modal__backdrop';

        var modal = document.createElement('div');
        modal.className = 'project-image-modal';

        var closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'project-image-modal__close';
        closeBtn.setAttribute('aria-label', 'Close');
        closeBtn.innerHTML = '&times;';

        var img = document.createElement('img');
        img.src = src;
        img.alt = '';
        img.className = 'project-image-modal__img';

        modal.appendChild(closeBtn);
        modal.appendChild(img);
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(function () {
            backdrop.classList.add('is-open');
        });

        function close() {
            backdrop.classList.remove('is-open');
            document.body.style.overflow = '';
            document.removeEventListener('keydown', onKeydown);
            setTimeout(function () {
                backdrop.remove();
            }, 250);
        }

        function onKeydown(e) {
            if (e.key === 'Escape') {
                close();
            }
        }

        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) {
                close();
            }
        });

        closeBtn.addEventListener('click', close);
        document.addEventListener('keydown', onKeydown);
    }

    function openVideoModal(sourceVideo) {
        var src = getVideoSrc(sourceVideo);

        var backdrop = document.createElement('div');
        backdrop.className = 'project-image-modal__backdrop';

        var modal = document.createElement('div');
        modal.className = 'project-image-modal';

        var closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'project-image-modal__close';
        closeBtn.setAttribute('aria-label', 'Close');
        closeBtn.innerHTML = '&times;';

        var video = document.createElement('video');
        video.src = src;
        video.controls = true;
        video.autoplay = true;
        video.playsInline = true;
        video.className = 'project-image-modal__img project-image-modal__video';

        registerVideo(video);

        video.addEventListener('ended', function () {
            setTimeout(function () {
                var grid = sourceVideo && sourceVideo.closest ? sourceVideo.closest('.video-grid, .projects-grid') : null;
                clickShowLessForGrid(grid);
            }, 50);
        });

        modal.appendChild(closeBtn);
        modal.appendChild(video);
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(function () {
            backdrop.classList.add('is-open');
        });

        function close() {
            video.pause();
            backdrop.classList.remove('is-open');
            document.body.style.overflow = '';
            document.removeEventListener('keydown', onKeydown);
            setTimeout(function () {
                backdrop.remove();
                unregisterVideo(video);
            }, 250);
        }

        function onKeydown(e) {
            if (e.key === 'Escape') {
                close();
            }
        }

        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) {
                close();
            }
        });

        closeBtn.addEventListener('click', close);
        document.addEventListener('keydown', onKeydown);
    }

    function setupLoadMore(grid) {
        if (!grid || grid.dataset.loadMoreBound === '1') return;

        var cards = Array.prototype.slice.call(grid.querySelectorAll('.project-card'));
        if (cards.length <= 8) return;

        grid.dataset.loadMoreBound = '1';

        var visibleCount = 8;
        cards.forEach(function (card, index) {
            card.hidden = index >= visibleCount;
        });

        var toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'video-grid__toggle';
        toggle.textContent = 'Load More';
        toggle.setAttribute('aria-expanded', 'false');
        toggle.dataset.expanded = 'false';

        var toggleId = 'videoGridToggle_' + Math.random().toString(36).slice(2, 9);
        grid.dataset.loadMoreToggleId = toggleId;
        toggle.dataset.forGrid = toggleId;

        function syncToggleState() {
            var expanded = visibleCount >= cards.length;
            toggle.textContent = expanded ? 'Show Less' : 'Load More';
            toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            toggle.dataset.expanded = expanded ? 'true' : 'false';
        }

        toggle.addEventListener('click', function () {
            var expanded = toggle.getAttribute('aria-expanded') === 'true';

            if (expanded) {
                var htmlEl = document.documentElement;
                var prevAnchor = htmlEl.style.overflowAnchor;
                var prevBehavior = htmlEl.style.scrollBehavior;
                htmlEl.style.overflowAnchor = 'none';
                htmlEl.style.scrollBehavior = 'auto';

                var top = grid.getBoundingClientRect().top + window.pageYOffset - 20;

                visibleCount = 8;
                cards.forEach(function (card, index) {
                    card.hidden = index >= visibleCount;
                });
                syncToggleState();

                if (!toggle.dataset.silent) {
                    window.scrollTo(0, top);
                } else {
                    delete toggle.dataset.silent;
                }

                requestAnimationFrame(function () {
                    htmlEl.style.overflowAnchor = prevAnchor;
                    htmlEl.style.scrollBehavior = prevBehavior;
                });
                return;
            }

            visibleCount = Math.min(cards.length, visibleCount + 8);
            cards.forEach(function (card, index) {
                card.hidden = index >= visibleCount;
            });
            syncToggleState();
        });

        var wrap = document.createElement('div');
        wrap.className = 'video-grid__toggle-wrap';
        wrap.appendChild(toggle);
        grid.parentNode.appendChild(wrap);
    }

    function init(scope) {
        var root = scope || document;
        root.querySelectorAll('.project-thumb').forEach(setupThumb);
        root.querySelectorAll('.video-grid').forEach(setupLoadMore);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            init();
        });
    } else {
        init();
    }
})();