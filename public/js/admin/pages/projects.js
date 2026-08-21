var deleteSelectedForm = document.getElementById('deleteSelectedForm');
var checkboxes = document.querySelectorAll('.video-checkbox');
var selectAll = document.getElementById('selectAll');
var selectedCount = document.getElementById('selectedCount');
var deleteBtn = document.getElementById('deleteSelected');
var newVideoBtn = document.getElementById('newVideoBtn');
var overlay = document.getElementById('newVideoOverlay');
var closeBtn = document.getElementById('newVideoClose');
var cancelBtn = document.getElementById('newVideoCancel');
var categoryCards = document.querySelectorAll('.category-card');
var categorySelect = document.getElementById('categorySelect');
var uploadDrop = document.getElementById('uploadDrop');
var videoFile = document.getElementById('videoFile');
var uploadText = document.getElementById('uploadText');
var coverDrop = document.getElementById('coverDrop');
var coverImage = document.getElementById('coverImage');
var form = document.getElementById('newVideoForm');

function openModal() {
    if (!overlay) return;
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    if (!overlay) return;
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}

function updateSelectionState() {
    var checked = document.querySelectorAll('.video-checkbox:checked');
    if (selectedCount) {
        selectedCount.textContent = checked.length + ' selected';
    }
    if (deleteBtn) {
        deleteBtn.disabled = checked.length === 0;
    }
    if (selectAll) {
        selectAll.checked = checked.length === checkboxes.length;
        selectAll.indeterminate = checked.length > 0 && checked.length < checkboxes.length;
    }
}

function updateDeleteInputs() {
    var container = document.getElementById('deleteInputs');
    if (!container) return;
    container.innerHTML = '';
    var checked = document.querySelectorAll('.video-checkbox:checked');
    checked.forEach(function (box) {
        var card = box.closest('.video-card');
        if (!card) return;
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = card.dataset.id;
        container.appendChild(input);
    });
}

checkboxes.forEach(function (box) {
    box.addEventListener('change', function () {
        var card = box.closest('.video-card');
        if (card) {
            card.classList.toggle('selected', box.checked);
        }
        updateSelectionState();
        updateDeleteInputs();
    });
});

if (selectAll) {
    selectAll.addEventListener('change', function () {
        checkboxes.forEach(function (box) {
            box.checked = selectAll.checked;
            var card = box.closest('.video-card');
            if (card) {
                card.classList.toggle('selected', box.checked);
            }
        });
        updateSelectionState();
        updateDeleteInputs();
    });
}

if (deleteBtn) {
    deleteBtn.addEventListener('click', function () {
        var checked = document.querySelectorAll('.video-checkbox:checked');
        if (checked.length === 0) return;
        var confirmed = confirm('Delete ' + checked.length + ' selected video' + (checked.length > 1 ? 's' : '') + '? This cannot be undone.');
        if (!confirmed) return;
        updateDeleteInputs();
        if (deleteSelectedForm) {
            deleteSelectedForm.submit();
        }
    });
}

if (newVideoBtn) {
    newVideoBtn.addEventListener('click', openModal);
}
if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
}
if (cancelBtn) {
    cancelBtn.addEventListener('click', closeModal);
}

if (overlay) {
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeModal();
    });
}

if (overlay) {
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
    });
}

if (categoryCards.length > 0 && categorySelect) {
    categoryCards.forEach(function (card) {
        var radio = card.querySelector('input[type="radio"]');
        var link = card.querySelector('.category-card-link');

        if (!radio) return;

        radio.addEventListener('change', function () {
            categoryCards.forEach(function (c) { c.classList.remove('active'); });
            card.classList.add('active');
            categorySelect.value = card.dataset.category;
        });

        if (link) {
            link.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    });

    categorySelect.addEventListener('change', function () {
        categoryCards.forEach(function (card) {
            var isMatch = card.dataset.category === categorySelect.value;
            card.classList.toggle('active', isMatch);
            var radio = card.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = isMatch;
            }
        });
    });
}

if (uploadDrop && videoFile && uploadText) {
    uploadDrop.addEventListener('click', function (e) {
        if (e.target === videoFile) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        if (typeof videoFile.click === 'function') {
            videoFile.click();
        }
    });

    uploadDrop.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            if (typeof videoFile.click === 'function') {
                videoFile.click();
            }
        }
    });

    videoFile.addEventListener('change', function () {
        if (videoFile.files && videoFile.files[0]) {
            uploadText.innerHTML = '<b>' + videoFile.files[0].name + '</b> selected';
            uploadDrop.classList.add('has-file');
        }
    });

    ['dragenter', 'dragover'].forEach(function (evt) {
        uploadDrop.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            uploadDrop.classList.add('drag-over');
        });
    });

    ['dragleave', 'drop'].forEach(function (evt) {
        uploadDrop.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            uploadDrop.classList.remove('drag-over');
        });
    });

    uploadDrop.addEventListener('drop', function (e) {
        var files = e.dataTransfer.files;
        if (files && files[0]) {
            videoFile.files = files;
            uploadText.innerHTML = '<b>' + files[0].name + '</b> selected';
            uploadDrop.classList.add('has-file');
        }
    });
}

if (coverDrop && coverImage) {
    var coverText = coverDrop.querySelector('.upload-text');

    coverDrop.addEventListener('click', function (e) {
        if (e.target === coverImage) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        coverImage.click();
    });

    coverImage.addEventListener('change', function () {
        if (coverImage.files && coverImage.files[0]) {
            if (coverText) coverText.innerHTML = '<b>' + coverImage.files[0].name + '</b> selected';
            coverDrop.classList.add('has-file');
        }
    });

    ['dragenter', 'dragover'].forEach(function (evt) {
        coverDrop.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            coverDrop.classList.add('drag-over');
        });
    });

    ['dragleave', 'drop'].forEach(function (evt) {
        coverDrop.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            coverDrop.classList.remove('drag-over');
        });
    });

    coverDrop.addEventListener('drop', function (e) {
        var files = e.dataTransfer.files;
        if (files && files[0]) {
            coverImage.files = files;
            if (coverText) coverText.innerHTML = '<b>' + files[0].name + '</b> selected';
            coverDrop.classList.add('has-file');
        }
    });
}

function buildVideoCard(video) {
    var article = document.createElement('article');
    article.className = 'project-card video-card admin-video-card';
    article.dataset.id = video.id;

    var poster = video.cover_url ? ' poster="' + video.cover_url + '"' : '';
    var videoMarkup = video.video_url ? (
        '<video playsinline preload="metadata"' + poster + ' src="' + video.video_url + '"></video>'
    ) : (
        '<button class="play-btn" aria-label="Play video"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7Z"/></svg></button>'
    );

    article.innerHTML = '<div class="project-thumb video-thumb hue-' + (((video.id || 1) % 4) + 1) + ' ' + (video.video_url ? 'has-video' : '') + '">' +
        '<label class="video-select"><input type="checkbox" class="video-checkbox"><span></span></label>' +
        videoMarkup +
        '<span class="duration"></span>' +
        '</div>' +
        '<div class="project-card__content video-info"><span class="status-pill ' + (video.is_featured ? 'approved' : 'review') + '">' +
        (video.is_featured ? 'Featured' : 'Not featured') +
        '</span></div>';

    return article;
}

if (form && categorySelect) {
    form.addEventListener('submit', function (e) {
        if (!categorySelect.value) {
            e.preventDefault();
            categorySelect.focus();
            return;
        }

        var submitButton = form.querySelector('button[type="submit"]');
        var tokenInput = form.querySelector('input[name="_token"]');
        var grid = document.getElementById('videoGrid');

        if (!tokenInput) {
            return;
        }

        e.preventDefault();
        if (submitButton) submitButton.disabled = true;

        function removeExistingAlerts(container) {
            if (!container) return;
            var existing = container.querySelectorAll('.form-alert');
            existing.forEach(function (el) { el.remove(); });
        }

        function showFormAlert(container, type, title, messages) {
            if (!container) return;
            removeExistingAlerts(container);
            var wrap = document.createElement('div');
            wrap.className = 'form-alert form-alert--' + (type === 'success' ? 'success' : 'error');
            wrap.setAttribute('role', 'alert');

            var icon = document.createElement('div');
            icon.className = type === 'success' ? 'form-alert--success__icon' : 'form-alert__icon';
            icon.setAttribute('aria-hidden', 'true');
            icon.innerHTML = type === 'success'
                ? '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                : '<div>!</div>';
            wrap.appendChild(icon);

            var body = document.createElement('div');
            var titleEl = document.createElement('div');
            titleEl.className = type === 'success' ? 'form-alert--success__title' : 'form-alert__title';
            titleEl.textContent = title;
            body.appendChild(titleEl);

            if (messages && messages.length) {
                var ul = document.createElement('ul');
                messages.forEach(function (m) { var li = document.createElement('li'); li.textContent = m; ul.appendChild(li); });
                body.appendChild(ul);
            }

            wrap.appendChild(body);

            container.insertBefore(wrap, container.firstChild);
            return wrap;
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': tokenInput.value,
            },
            body: new FormData(form)
        }).then(function (response) {
            if (!response.ok) {
                return response.json().then(function (data) {
                    return Promise.reject({ status: response.status, data: data });
                }).catch(function () {
                    return Promise.reject({ status: response.status });
                });
            }
            return response.json();
        }).then(function (video) {
            if (!video || !video.id) {
                throw new Error('Missing video payload');
            }

            if (grid) {
                var firstEmptyState = grid.querySelector('.feedback-form-wrap');
                if (firstEmptyState) {
                    firstEmptyState.remove();
                }
                var newCard = buildVideoCard(video);
                grid.prepend(newCard);
                if (window.initVideoPlayer) {
                    window.initVideoPlayer(grid);
                }
            }

            closeModal();
            form.reset();
            if (videoFile && uploadText) {
                uploadText.innerHTML = 'Drop a video here, or <b>browse</b>';
                uploadDrop.classList.remove('has-file');
            }
            if (categorySelect) categorySelect.value = '';
            categoryCards.forEach(function (card) {
                card.classList.remove('active');
                var radio = card.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            (function showFloatingToast(message, duration) {
                duration = duration || 4000;
                var container = document.getElementById('globalToasts');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'globalToasts';
                    container.style.position = 'fixed';
                    container.style.top = '20px';
                    container.style.right = '20px';
                    container.style.display = 'flex';
                    container.style.flexDirection = 'column';
                    container.style.gap = '10px';
                    container.style.zIndex = '9999';
                    document.body.appendChild(container);
                }

                var toast = document.createElement('div');
                toast.className = 'form-alert form-alert--success form-alert--toast';
                toast.setAttribute('role', 'status');
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-6px)';
                toast.style.transition = 'opacity 180ms ease, transform 180ms ease';

                var icon = document.createElement('div');
                icon.className = 'form-alert--success__icon';
                icon.setAttribute('aria-hidden', 'true');
                icon.innerHTML = '<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

                var body = document.createElement('div');
                body.className = 'form-alert--success__body';
                var titleEl = document.createElement('div');
                titleEl.className = 'form-alert--success__title';
                titleEl.textContent = 'Success';
                var text = document.createElement('p');
                text.className = 'form-alert--success__text';
                text.style.margin = '0';
                text.textContent = message || 'Video added successfully.';

                body.appendChild(titleEl);
                body.appendChild(text);

                toast.appendChild(icon);
                toast.appendChild(body);

                container.appendChild(toast);

                requestAnimationFrame(function () {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateY(0)';
                });

                setTimeout(function () {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-6px)';
                    setTimeout(function () { try { toast.remove(); } catch (e) { } }, 200);
                }, duration);
            })('Video added successfully.', 4000);
        }).catch(function (err) {
            var container = form;
            var msgs = [];
            if (err && err.data) {
                if (err.data.errors) {
                    Object.keys(err.data.errors).forEach(function (k) { msgs = msgs.concat(err.data.errors[k]); });
                } else if (err.data.message) {
                    msgs.push(err.data.message);
                }
            } else if (err && err.message) {
                msgs.push(err.message);
            } else {
                msgs.push('Upload failed. Please try again.');
            }

            showFormAlert(container, 'error', "Couldn't add video", msgs);
        }).finally(function () {
            if (submitButton) submitButton.disabled = false;
        });
    });
}