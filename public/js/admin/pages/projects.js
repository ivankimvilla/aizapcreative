var deleteSelectedForm = document.getElementById('deleteSelectedForm');
var checkboxes = document.querySelectorAll('.video-checkbox');
var selectAll = document.getElementById('selectAll');
var selectedCount = document.getElementById('selectedCount');
var deleteBtn = document.getElementById('deleteSelected');
var projectsPage = document.querySelector('.projects-page');
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

// ---- Upload configuration ----
var ACCEPTED_VIDEO_TYPES = ['video/mp4', 'video/quicktime', 'video/webm'];
var UPLOAD_TIMEOUT_MS = 15 * 60 * 1000; // 15 minutes, generous for large videos on slow connections

var currentXhr = null;
var isUploading = false;

async function uploadToSignedStorage(file, folder) {
    if (!file || !form) return null;

    var tokenInput = form.querySelector('input[name="_token"]');
    if (!tokenInput) return null;

    var directUploadUrl = form.action ? form.action.replace(/\/$/, '') + '/upload-url' : '/admin/projects/upload-url';
    var payload = new FormData();
    payload.append('file_name', file.name);
    payload.append('folder', folder || '');
    payload.append('content_type', file.type || 'application/octet-stream');

    try {
        var response = await fetch(directUploadUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': tokenInput.value,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: payload
        });

        if (!response.ok) return null;

        var result = await response.json();
        if (!result || !result.url || !result.key) return null;

        var putResponse = await fetch(result.url, {
            method: 'PUT',
            body: file,
            headers: {
                'Content-Type': file.type || 'application/octet-stream'
            }
        });

        if (!putResponse.ok) return null;

        return result;
    } catch (e) {
        return null;
    }
}

function showFloatingToast(message, duration) {
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
}

if (document.readyState !== 'loading') {
    var flashStatus = document.querySelector('[data-flash-status]');
    if (flashStatus && flashStatus.dataset.flashStatus) {
        showFloatingToast(flashStatus.dataset.flashStatus, 4000);
        flashStatus.remove();
    }
} else {
    document.addEventListener('DOMContentLoaded', function () {
        var flashStatus = document.querySelector('[data-flash-status]');
        if (flashStatus && flashStatus.dataset.flashStatus) {
            showFloatingToast(flashStatus.dataset.flashStatus, 4000);
            flashStatus.remove();
        }
    });
}

function openModal() {
    if (!overlay) return;
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.width = '100%';
}

function closeModal(force) {
    if (!overlay) return;

    if (isUploading && !force) {
        var confirmed = confirm('A video is still uploading. Cancel the upload and close?');
        if (!confirmed) return;
        if (currentXhr) {
            currentXhr.abort();
        }
    }

    overlay.classList.remove('open');
    document.body.style.overflow = '';
    document.documentElement.style.overflow = '';
    document.body.style.position = '';
    document.body.style.width = '';
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
        if (projectsPage) {
            projectsPage.classList.toggle('is-selecting-all', selectAll.checked);
        }
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

document.addEventListener('click', function (event) {
    var deleteCardButton = event.target.closest('.video-delete-btn');
    if (!deleteCardButton || !deleteSelectedForm) return;

    var videoId = deleteCardButton.dataset.id;
    if (!videoId) return;

    var confirmed = confirm('Delete this video? This cannot be undone.');
    if (!confirmed) return;

    var container = document.getElementById('deleteInputs');
    if (!container) return;
    container.innerHTML = '';

    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'ids[]';
    input.value = videoId;
    container.appendChild(input);
    deleteSelectedForm.submit();
});

if (newVideoBtn) {
    newVideoBtn.addEventListener('click', openModal);
}
if (closeBtn) {
    closeBtn.addEventListener('click', function () { closeModal(false); });
}
if (cancelBtn) {
    cancelBtn.addEventListener('click', function () { closeModal(false); });
}

if (overlay) {
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeModal(false);
    });
}

if (overlay) {
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal(false);
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

function resetUploadDropUi() {
    if (videoFile && uploadText && uploadDrop) {
        uploadText.innerHTML = 'Drop a video here, or <b>browse</b>';
        uploadDrop.classList.remove('has-file');
    }
}

function formatFileSize(bytes) {
    if (bytes >= 1024 * 1024 * 1024) return (bytes / (1024 * 1024 * 1024)).toFixed(1) + ' GB';
    if (bytes >= 1024 * 1024) return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    return Math.round(bytes / 1024) + ' KB';
}

// Validates the selected file client-side so obviously-bad uploads
// (wrong type, too large) fail instantly instead of after a slow upload.
function validateVideoFile(file) {
    if (!file) return 'Please select a video file.';

    if (ACCEPTED_VIDEO_TYPES.indexOf(file.type) === -1) {
        return 'Unsupported file type. Please upload an MP4, MOV, or WebM video.';
    }

    return null;
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
            var file = videoFile.files[0];
            var error = validateVideoFile(file);
            if (error) {
                showFormAlert(form, 'error', 'Invalid file', [error]);
                videoFile.value = '';
                resetUploadDropUi();
                return;
            }
            uploadText.innerHTML = '<b>' + file.name + '</b> (' + formatFileSize(file.size) + ') selected';
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
            var file = files[0];
            var error = validateVideoFile(file);
            if (error) {
                showFormAlert(form, 'error', 'Invalid file', [error]);
                resetUploadDropUi();
                return;
            }
            videoFile.files = files;
            uploadText.innerHTML = '<b>' + file.name + '</b> (' + formatFileSize(file.size) + ') selected';
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
        '<button type="button" class="video-delete-btn" data-id="' + video.id + '" aria-label="Delete video"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v5M14 11v5"/></svg></button>' +
        videoMarkup +
        (video.is_featured ? '<span class="featured-star" title="Featured" aria-label="Featured"></span>' : '') +
        '<span class="duration"></span>' +
        '</div>';

    return article;
}

function removeExistingAlerts(container) {
    if (!container) return;
    var existing = container.querySelectorAll('.form-alert');
    existing.forEach(function (el) { el.remove(); });
}

function showFormAlert(container, type, title, messages) {
    var host = document.getElementById('newVideoAlertHost');
    if (!host) {
        host = document.createElement('div');
        host.id = 'newVideoAlertHost';
        host.setAttribute('aria-live', 'polite');
        document.body.appendChild(host);
    }

    removeExistingAlerts(container);

    var wrap = document.createElement('div');
    wrap.className = 'form-alert form-alert--' + (type === 'success' ? 'success' : 'error');
    wrap.setAttribute('role', 'alert');
    wrap.style.opacity = '0';
    wrap.style.transition = 'opacity 180ms ease';

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
    host.appendChild(wrap);

    requestAnimationFrame(function () {
        wrap.style.opacity = '1';
    });

    setTimeout(function () {
        wrap.style.opacity = '0';
        setTimeout(function () {
            if (wrap && wrap.parentNode) {
                wrap.remove();
            }
        }, 180);
    }, 5000);

    return wrap;
}

// ---- Upload progress UI ----
var progressWrap = document.getElementById('uploadProgress');
var progressBarFill = document.getElementById('uploadProgressFill');
var progressLabel = document.getElementById('uploadProgressLabel');
var submitButton = form ? form.querySelector('button[type="submit"]') : null;

function setUploadingUi(active) {
    isUploading = active;

    if (submitButton) {
        submitButton.disabled = active;
        submitButton.textContent = active ? 'Uploading…' : 'Save video';
    }

    if (progressWrap) {
        progressWrap.style.display = active ? 'block' : 'none';
    }

    if (!active && progressBarFill) {
        progressBarFill.style.width = '0%';
    }
    if (!active && progressLabel) {
        progressLabel.textContent = '';
    }
}

function updateUploadProgress(loaded, total) {
    if (!total) return;
    var pct = Math.round((loaded / total) * 100);
    if (progressBarFill) {
        progressBarFill.style.width = pct + '%';
    }
    if (progressLabel) {
        progressLabel.textContent = pct + '% \u2014 ' + formatFileSize(loaded) + ' of ' + formatFileSize(total);
    }
}

if (form && categorySelect) {
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (isUploading) return; // guard against double-submit

        var tokenInput = form.querySelector('input[name="_token"]');
        var grid = document.getElementById('videoGrid');

        if (!tokenInput) {
            showFormAlert(form, 'error', "Couldn't add video", ['Your form session is missing. Please refresh the page and try again.']);
            return;
        }

        if (!videoFile || !videoFile.files || !videoFile.files.length) {
            showFormAlert(form, 'error', "Couldn't add video", ['Please select a video file before saving.']);
            return;
        }

        var fileError = validateVideoFile(videoFile.files[0]);
        if (fileError) {
            showFormAlert(form, 'error', "Couldn't add video", [fileError]);
            return;
        }

        setUploadingUi(true);

        var formData = new FormData(form);
        var directVideoUpload = null;
        var directCoverUpload = null;

        try {
            directVideoUpload = await uploadToSignedStorage(videoFile.files[0], 'project-videos');
        } catch (error) {
            directVideoUpload = null;
        }

        if (directVideoUpload) {
            formData.delete('video_file');
            formData.set('video_path', directVideoUpload.key);
            if (directVideoUpload.final_url) {
                formData.set('video_url', directVideoUpload.final_url);
            }
        }

        if (coverImage && coverImage.files && coverImage.files.length) {
            try {
                directCoverUpload = await uploadToSignedStorage(coverImage.files[0], 'project-covers');
            } catch (error) {
                directCoverUpload = null;
            }

            if (directCoverUpload) {
                formData.delete('cover_image');
                formData.set('cover_path', directCoverUpload.key);
                if (directCoverUpload.final_url) {
                    formData.set('cover_url', directCoverUpload.final_url);
                }
            }
        }

        var xhr = new XMLHttpRequest();
        currentXhr = xhr;

        xhr.open('POST', form.action, true);
        xhr.timeout = UPLOAD_TIMEOUT_MS;
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', tokenInput.value);

        if (!directVideoUpload) {
            xhr.upload.addEventListener('progress', function (evt) {
                if (evt.lengthComputable) {
                    updateUploadProgress(evt.loaded, evt.total);
                }
            });
        }

        xhr.addEventListener('load', function () {
            currentXhr = null;
            setUploadingUi(false);

            var status = xhr.status;
            var contentType = xhr.getResponseHeader('content-type') || '';
            var payload = null;

            if (contentType.indexOf('application/json') !== -1) {
                try {
                    payload = JSON.parse(xhr.responseText);
                } catch (parseErr) {
                    payload = null;
                }
            }

            if (status === 401 || (xhr.responseURL && /\/admin\/login/.test(xhr.responseURL))) {
                showFormAlert(form, 'error', "Couldn't add video", ['Your session expired. Please log in again.']);
                return;
            }

            if (status >= 200 && status < 300) {
                if (!payload || !payload.id) {
                    showFormAlert(form, 'error', "Couldn't add video", ['The server response was unexpected. Please refresh and check if the video was added.']);
                    return;
                }

                if (grid) {
                    var firstEmptyState = grid.querySelector('.feedback-form-wrap');
                    if (firstEmptyState) {
                        firstEmptyState.remove();
                    }
                    var newCard = buildVideoCard(payload);
                    grid.prepend(newCard);
                    if (window.initVideoPlayer) {
                        window.initVideoPlayer(grid);
                    }
                }

                closeModal(true);
                form.reset();
                resetUploadDropUi();
                if (categorySelect) categorySelect.value = '';
                categoryCards.forEach(function (card) {
                    card.classList.remove('active');
                    var radio = card.querySelector('input[type="radio"]');
                    if (radio) radio.checked = false;
                });
                showFloatingToast('Video added successfully.', 4000);
                return;
            }

            // Non-2xx response
            var msgs = [];
            if (payload && payload.errors) {
                Object.keys(payload.errors).forEach(function (k) { msgs = msgs.concat(payload.errors[k]); });
            } else if (payload && payload.message) {
                msgs.push(payload.message);
            } else if (status === 413) {
                msgs.push('That file is too large for the server to accept. Please compress it or choose a smaller file.');
            } else if (status === 419) {
                msgs.push('Your form session expired. Please refresh the page and try again.');
            } else if (status >= 500) {
                msgs.push('The server ran into a problem saving your video. Please try again in a moment.');
            } else {
                msgs.push('Upload failed (status ' + status + '). Please try again.');
            }

            showFormAlert(form, 'error', "Couldn't add video", msgs);
        });

        xhr.addEventListener('error', function () {
            currentXhr = null;
            setUploadingUi(false);
            showFormAlert(form, 'error', "Couldn't add video", ['A network error interrupted the upload. Check your connection and try again.']);
        });

        xhr.addEventListener('timeout', function () {
            currentXhr = null;
            setUploadingUi(false);
            showFormAlert(form, 'error', "Couldn't add video", ['The upload timed out. Try a smaller file or a more stable connection, then try again.']);
        });

        xhr.addEventListener('abort', function () {
            currentXhr = null;
            setUploadingUi(false);
            // No alert needed: abort only happens on deliberate user cancel/close.
        });

        xhr.send(formData);
    });
}