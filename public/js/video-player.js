(function () {
    var PLAY_ICON_SVG = '<svg viewBox="0 0 24 24"><path d="M5 3v18l15-9z"/></svg>';

    // Registry of every video we know about (thumbnails + modal videos).
    // Used to enforce "only one video plays at a time" across the whole page.
    var activeVideos = [];

    function registerVideo(video) {
        if (activeVideos.indexOf(video) === -1) {
            activeVideos.push(video);
        }
        video.addEventListener('play', function () {
            pauseOtherVideos(video);
        });
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

        // Clicking the play button now expands the video into the
        // modal (instead of playing it inline in the thumbnail).
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            video.pause();
            openVideoModal(video);
        });

        // If the thumbnail video itself is clicked directly (and it
        // doesn't already have native controls), also expand it rather
        // than toggling inline playback.
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

        toggle.addEventListener('click', function () {
            var expanded = toggle.getAttribute('aria-expanded') === 'true';

            if (expanded) {
                visibleCount = 8;
                cards.forEach(function (card, index) {
                    card.hidden = index >= visibleCount;
                });
                toggle.textContent = 'Show Less';
                toggle.setAttribute('aria-expanded', 'false');
                return;
            }

            visibleCount = Math.min(cards.length, visibleCount + 8);
            cards.forEach(function (card, index) {
                card.hidden = index >= visibleCount;
            });

            if (visibleCount >= cards.length) {
                toggle.textContent = 'Show Less';
                toggle.setAttribute('aria-expanded', 'true');
            } else {
                toggle.textContent = 'Load More';
                toggle.setAttribute('aria-expanded', 'false');
            }
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