
var toggle = document.getElementById('menuToggle');
var sidebar = document.getElementById('sidebar');
if (toggle && sidebar) {
    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('open');
    });
}

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

/* Keep the select and the visual category cards in sync */
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
        // label already triggers the input via `for`; guard against double-trigger on nested clicks
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
        // label triggers input via for
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

if (form && categorySelect) {
    form.addEventListener('submit', function (e) {
        if (!categorySelect.value) {
            e.preventDefault();
            categorySelect.focus();
        }
    });
}
