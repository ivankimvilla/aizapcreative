(function () {
    var PLAY_ICON_SVG = '<svg viewBox="0 0 24 24"><path d="M5 3v18l15-9z"/></svg>';

    var activeVideos = [];

    var prefersReducedMotion = typeof window.matchMedia === 'function' &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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

        var thumbProgress = document.createElement('div');
        thumbProgress.className = 'thumb-progress';
        var thumbProgressFill = document.createElement('div');
        thumbProgressFill.className = 'thumb-progress-fill';
        thumbProgress.appendChild(thumbProgressFill);
        thumb.appendChild(thumbProgress);

        thumb.classList.add('has-video');
        video.playsInline = true;
        video.preload = 'metadata';
        if (!hasControls) {
            video.removeAttribute('controls');
        }

        registerVideo(video);
        setupLoadingShimmer(thumb, video);
        setupMagneticPlayButton(thumb, btn);

        video.addEventListener('timeupdate', function () {
            if (!video.duration) return;
            var pct = (video.currentTime / video.duration) * 100;
            thumbProgressFill.style.width = Math.min(100, Math.max(0, pct)) + '%';
        });

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            openVideoModal(video);
        });

        video.addEventListener('click', function () {
            if (video.hasAttribute('controls')) {
                return;
            }
            openVideoModal(video);
        });

        video.addEventListener('play', function () {
            btn.classList.add('is-hidden');
        });

        video.addEventListener('pause', function () {
            btn.classList.remove('is-hidden');
        });
    }

    function setupLoadingShimmer(thumb, video) {
        if (video.readyState >= 2) {
            return;
        }

        thumb.classList.add('is-loading');

        function clear() {
            thumb.classList.remove('is-loading');
            video.removeEventListener('loadeddata', clear);
            video.removeEventListener('error', clear);
        }

        video.addEventListener('loadeddata', clear);
        video.addEventListener('error', clear);
    }

    function setupMagneticPlayButton(thumb, btn) {
        if (prefersReducedMotion) return;

        thumb.addEventListener('mousemove', function (e) {
            var rect = thumb.getBoundingClientRect();
            var x = (e.clientX - rect.left - rect.width / 2) * 0.08;
            var y = (e.clientY - rect.top - rect.height / 2) * 0.08;
            btn.style.setProperty('--magnet-x', x.toFixed(1) + 'px');
            btn.style.setProperty('--magnet-y', y.toFixed(1) + 'px');
        });

        thumb.addEventListener('mouseleave', function () {
            btn.style.setProperty('--magnet-x', '0px');
            btn.style.setProperty('--magnet-y', '0px');
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

    function getVideoCollection(sourceVideo) {
        var grid = sourceVideo && sourceVideo.closest ? sourceVideo.closest('.video-grid, .projects-grid') : null;
        var cards = grid ? grid.querySelectorAll('.project-card') : document.querySelectorAll('.project-card');
        var videos = [];

        cards.forEach(function (card) {
            var thumbVideo = card && card.querySelector ? card.querySelector('video') : null;
            if (thumbVideo && thumbVideo.src) {
                videos.push(thumbVideo);
            }
        });

        if (!videos.length) {
            videos = [sourceVideo];
        }

        return videos;
    }

    function openAdminVideoModal(sourceVideo) {
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
        video.src = getVideoSrc(sourceVideo);
        video.controls = true;
        video.autoplay = true;
        video.playsInline = true;
        video.className = 'project-image-modal__img project-image-modal__video';

        modal.appendChild(closeBtn);
        modal.appendChild(video);
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(function () {
            backdrop.classList.add('is-open');
            video.play().catch(function () { });
        });

        function close() {
            video.pause();
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
        if (sourceVideo && !sourceVideo.paused) {
            sourceVideo.pause();
        }

        if (sourceVideo && sourceVideo.closest && sourceVideo.closest('.admin-video-card')) {
            openAdminVideoModal(sourceVideo);
            return;
        }

        var collection = getVideoCollection(sourceVideo);
        var currentIndex = collection.indexOf(sourceVideo);
        if (currentIndex === -1) {
            currentIndex = 0;
        }

        var backdrop = document.createElement('div');
        backdrop.className = 'project-image-modal__backdrop project-video-feed__backdrop';

        var modal = document.createElement('div');
        modal.className = 'project-image-modal project-video-feed';

        var closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'project-image-modal__close';
        closeBtn.setAttribute('aria-label', 'Close');
        closeBtn.innerHTML = '&times;';

        var muteBtn = document.createElement('button');
        muteBtn.type = 'button';
        muteBtn.className = 'project-video-feed__mute';
        muteBtn.setAttribute('aria-label', 'Mute video');

        var isMuted = false;

        function updateMuteButton() {
            muteBtn.setAttribute('aria-label', isMuted ? 'Unmute video' : 'Mute video');
            muteBtn.setAttribute('aria-pressed', String(isMuted));
            muteBtn.innerHTML = isMuted
                ? '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9v6h4l5 4V5L8 9H4z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m17 9 4 6m0-6-4 6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>'
                : '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9v6h4l5 4V5L8 9H4z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M17 9.5a4 4 0 0 1 0 5M19.5 7a7.5 7.5 0 0 1 0 10" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>';
        }

        muteBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            isMuted = !isMuted;
            feedVideos.forEach(function (videoEl) {
                videoEl.muted = isMuted;
            });
            updateMuteButton();
        });
        updateMuteButton();

        var navPrev = document.createElement('button');
        navPrev.type = 'button';
        navPrev.className = 'project-video-feed__nav project-video-feed__nav--prev';
        navPrev.setAttribute('aria-label', 'Previous video');
        navPrev.innerHTML = '<svg viewBox="0 0 24 24" width="22" height="22"><path d="M5 15l7-7 7 7" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';

        var navNext = document.createElement('button');
        navNext.type = 'button';
        navNext.className = 'project-video-feed__nav project-video-feed__nav--next';
        navNext.setAttribute('aria-label', 'Next video');
        navNext.innerHTML = '<svg viewBox="0 0 24 24" width="22" height="22"><path d="M5 9l7 7 7-7" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';

        var categoryLabel = document.createElement('div');
        categoryLabel.className = 'project-video-feed__category';
        categoryLabel.setAttribute('aria-live', 'polite');

        var stage = document.createElement('div');
        stage.className = 'project-video-feed__stage';

        var progressBar = document.createElement('div');
        progressBar.className = 'project-video-feed__progress';
        var progressFill = document.createElement('div');
        progressFill.className = 'project-video-feed__progress-fill';
        progressBar.appendChild(progressFill);

        var centerPlayBtn = document.createElement('button');
        centerPlayBtn.type = 'button';
        centerPlayBtn.className = 'project-video-feed__play-btn is-hidden';
        centerPlayBtn.setAttribute('aria-label', 'Play video');
        centerPlayBtn.innerHTML = PLAY_ICON_SVG;

        function updateProgressFill() {
            var activeVideo = feedVideos[currentIndex];
            if (!activeVideo || !activeVideo.duration) {
                progressFill.style.width = '0%';
                return;
            }
            var pct = (activeVideo.currentTime / activeVideo.duration) * 100;
            progressFill.style.width = Math.min(100, Math.max(0, pct)) + '%';
        }

        var feedVideos = [];

        function getCategoryLabel(videoEl) {
            var card = videoEl && videoEl.closest ? videoEl.closest('.project-card') : null;
            if (card) {
                var cardLabel = card.dataset.categoryLabel || card.getAttribute('data-category-label');
                if (cardLabel && cardLabel.trim()) {
                    return cardLabel.trim();
                }
            }
            var category = card ? card.querySelector('.project-category') : null;
            return category ? category.textContent.trim() : '';
        }

        collection.forEach(function (videoEl, index) {
            var video = document.createElement('video');
            video.src = getVideoSrc(videoEl);
            video.controls = false;
            video.autoplay = true;
            video.muted = isMuted;
            video.playsInline = true;
            video.preload = 'auto';
            video.className = 'project-video-feed__video';
            video.setAttribute('data-feed-index', String(index));
            stage.appendChild(video);
            registerVideo(video);

            video.addEventListener('click', function (e) {
                e.stopPropagation();
                if (index !== currentIndex) return;
                if (video.paused) {
                    video.play().catch(function () { });
                } else {
                    video.pause();
                }
            });

            video.addEventListener('play', function () {
                if (index === currentIndex) {
                    centerPlayBtn.classList.add('is-hidden');
                }
            });

            video.addEventListener('pause', function () {
                if (index === currentIndex) {
                    centerPlayBtn.classList.remove('is-hidden');
                }
            });

            video.addEventListener('ended', function () {
                if (index === currentIndex) {
                    var nextIndex = Math.min(currentIndex + 1, feedVideos.length - 1);
                    updateCurrentVideo(nextIndex);
                }
            });

            video.addEventListener('timeupdate', function () {
                if (index === currentIndex) {
                    updateProgressFill();
                }
            });

            feedVideos.push(video);
        });

        centerPlayBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var activeVideo = feedVideos[currentIndex];
            if (!activeVideo) return;
            if (activeVideo.paused) {
                activeVideo.play().catch(function () { });
            } else {
                activeVideo.pause();
            }
        });

        function updateCurrentVideo(nextIndex) {
            if (typeof nextIndex !== 'number' || nextIndex < 0 || nextIndex >= feedVideos.length) {
                return;
            }

            currentIndex = nextIndex;
            categoryLabel.textContent = getCategoryLabel(collection[currentIndex]);
            categoryLabel.hidden = !categoryLabel.textContent;
            centerPlayBtn.classList.add('is-hidden');

            feedVideos.forEach(function (videoEl, index) {
                videoEl.classList.remove('is-active', 'is-prev', 'is-next');

                if (index === currentIndex) {
                    videoEl.classList.add('is-active');
                    videoEl.currentTime = 0;
                    videoEl.play().catch(function () { });
                } else if (index < currentIndex) {
                    videoEl.classList.add('is-prev');
                    videoEl.pause();
                } else {
                    videoEl.classList.add('is-next');
                    videoEl.pause();
                }
            });

            positionCategoryLabel();
            updateProgressFill();

            navPrev.disabled = currentIndex === 0;
            navNext.disabled = currentIndex === feedVideos.length - 1;
        }

        function positionCategoryLabel() {
            var activeVideo = feedVideos[currentIndex];
            if (!activeVideo || !activeVideo.videoWidth || !activeVideo.videoHeight) {
                categoryLabel.style.top = 'auto';
                categoryLabel.style.bottom = '24px';
                return;
            }

            var stageRect = stage.getBoundingClientRect();
            var videoRatio = activeVideo.videoWidth / activeVideo.videoHeight;
            var stageRatio = stageRect.width / stageRect.height;
            var displayedHeight = stageRatio < videoRatio
                ? stageRect.width / videoRatio
                : stageRect.height;
            var displayedTop = (stageRect.height - displayedHeight) / 2;

            categoryLabel.style.top = Math.max(18, displayedTop + displayedHeight - categoryLabel.offsetHeight - 24) + 'px';
            categoryLabel.style.bottom = 'auto';
        }

        feedVideos.forEach(function (video) {
            video.addEventListener('loadedmetadata', positionCategoryLabel);
        });
        window.addEventListener('resize', positionCategoryLabel);

        function handleDirectionalMove(direction) {
            if (direction === 'next') {
                updateCurrentVideo(Math.min(currentIndex + 1, feedVideos.length - 1));
                return;
            }

            updateCurrentVideo(Math.max(currentIndex - 1, 0));
        }

        navPrev.addEventListener('click', function (e) {
            e.stopPropagation();
            handleDirectionalMove('prev');
        });

        navNext.addEventListener('click', function (e) {
            e.stopPropagation();
            handleDirectionalMove('next');
        });

        modal.appendChild(closeBtn);
        modal.appendChild(muteBtn);
        modal.appendChild(stage);
        stage.appendChild(categoryLabel);
        stage.appendChild(progressBar);
        stage.appendChild(centerPlayBtn);
        modal.appendChild(navPrev);
        modal.appendChild(navNext);
        backdrop.appendChild(modal);
        document.body.appendChild(backdrop);
        var htmlElement = document.documentElement;
        var previousHtmlOverflow = htmlElement.style.overflow;
        var previousBodyOverflow = document.body.style.overflow;
        htmlElement.style.overflow = 'hidden';
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(function () {
            backdrop.classList.add('is-open');
            updateCurrentVideo(currentIndex);
        });

        var wheelLock = false;
        var touchStartY = null;

        function handleWheel(e) {
            if (wheelLock) return;
            e.preventDefault();

            if (Math.abs(e.deltaY) < 18) return;

            wheelLock = true;
            handleDirectionalMove(e.deltaY > 0 ? 'next' : 'prev');
            window.setTimeout(function () {
                wheelLock = false;
            }, 420);
        }

        backdrop.addEventListener('wheel', handleWheel, { passive: false });
        backdrop.addEventListener('touchstart', function (e) {
            if (e.touches && e.touches.length) {
                touchStartY = e.touches[0].clientY;
            }
        }, { passive: true });

        backdrop.addEventListener('touchmove', function (e) {
            if (touchStartY === null || !e.touches || !e.touches.length) return;
            var deltaY = e.touches[0].clientY - touchStartY;
            if (Math.abs(deltaY) < 30) return;
            e.preventDefault();
            touchStartY = e.touches[0].clientY;
            handleDirectionalMove(deltaY > 0 ? 'prev' : 'next');
        }, { passive: false });

        function close() {
            feedVideos.forEach(function (videoEl) {
                videoEl.pause();
                unregisterVideo(videoEl);
            });
            backdrop.classList.remove('is-open');
            htmlElement.style.overflow = previousHtmlOverflow;
            document.body.style.overflow = previousBodyOverflow;
            document.removeEventListener('keydown', onKeydown);
            window.removeEventListener('resize', positionCategoryLabel);
            setTimeout(function () {
                backdrop.remove();
            }, 250);
        }

        function onKeydown(e) {
            if (e.key === 'Escape') {
                close();
            }

            if (e.key === 'ArrowDown') {
                handleDirectionalMove('next');
            }

            if (e.key === 'ArrowUp') {
                handleDirectionalMove('prev');
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

    function getComputedColumnCount(grid) {
        var style = window.getComputedStyle(grid);
        var template = style.getPropertyValue('grid-template-columns');
        if (!template || template === 'none') return 0;
        return template.split(' ').filter(Boolean).length;
    }

    function setupScrollReveal(scope) {
        if (prefersReducedMotion || typeof IntersectionObserver === 'undefined') return;

        var root = scope || document;
        var grids = root.querySelectorAll('.projects-grid, .video-grid');
        var toObserve = [];

        grids.forEach(function (grid) {
            var cards = Array.prototype.slice.call(grid.querySelectorAll('.project-card'));
            var columns = getComputedColumnCount(grid) || 4;

            cards.forEach(function (card, index) {
                if (card.dataset.revealBound === '1') return;
                card.dataset.revealBound = '1';
                card.classList.add('reveal');
                var col = index % columns;
                card.style.setProperty('--reveal-delay', Math.min(col * 90, 360) + 'ms');
                toObserve.push(card);
            });
        });

        if (!toObserve.length) return;

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                } else {
                    entry.target.classList.remove('is-visible');
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

        toObserve.forEach(function (card) {
            observer.observe(card);
        });
    }

    function revealShownCards(cards) {
        if (prefersReducedMotion) return;
        cards.forEach(function (card) {
            if (card.hidden) return;
            if (card.classList.contains('reveal') && !card.classList.contains('is-visible')) {
                requestAnimationFrame(function () {
                    card.classList.add('is-visible');
                });
            }
        });
    }

    function setupParallax(scope) {
        if (prefersReducedMotion) return;

        var root = scope || document;
        var thumbs = Array.prototype.slice.call(root.querySelectorAll('.project-thumb'));
        if (!thumbs.length) return;

        var ticking = false;

        function update() {
            var viewportHeight = window.innerHeight;
            thumbs.forEach(function (thumb) {
                var rect = thumb.getBoundingClientRect();
                if (rect.bottom < -100 || rect.top > viewportHeight + 100) return;
                var center = rect.top + rect.height / 2 - viewportHeight / 2;
                var offset = Math.max(-14, Math.min(14, center * -0.04));
                thumb.style.setProperty('--parallax-y', offset.toFixed(2) + 'px');
            });
            ticking = false;
        }

        function onScroll() {
            if (!ticking) {
                window.requestAnimationFrame(update);
                ticking = true;
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll, { passive: true });
        update();
    }

    function setupLoadMore(grid) {
        if (!grid || grid.dataset.loadMoreBound === '1') return;

        var cards = Array.prototype.slice.call(grid.querySelectorAll('.project-card'));
        if (cards.length === 0) return;

        grid.dataset.loadMoreBound = '1';

        var wrap = document.createElement('div');
        wrap.className = 'video-grid__toggle-wrap';
        grid.parentNode.appendChild(wrap);

        if (cards.length <= 8) {
            return;
        }

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
            revealShownCards(cards);
        });

        wrap.appendChild(toggle);
    }

    function init(scope) {
        var root = scope || document;
        if (!root || !root.querySelectorAll) return;
        root.querySelectorAll('.project-thumb').forEach(setupThumb);
        root.querySelectorAll('.video-grid').forEach(setupLoadMore);
        setupScrollReveal(root);
        setupParallax(root);
    }

    window.initVideoPlayer = init;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            init();
        });
    } else {
        init();
    }
})();