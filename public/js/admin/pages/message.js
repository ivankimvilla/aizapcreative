function sizeInboxPanel() {
    var panel = document.getElementById('inbox');
    if (!panel) return;
    var bottomMargin = 24;
    var top = panel.getBoundingClientRect().top;
    var height = window.innerHeight - top - bottomMargin;
    panel.style.height = Math.max(height, 320) + 'px';
}

window.addEventListener('load', sizeInboxPanel);
window.addEventListener('resize', sizeInboxPanel);
sizeInboxPanel();

var VIEWED_KEY = 'aizap_viewed_messages';

function getViewedIds() {
    try {
        return JSON.parse(localStorage.getItem(VIEWED_KEY)) || [];
    } catch (e) {
        return [];
    }
}

function markAsViewed(id) {
    var viewed = getViewedIds();
    if (viewed.indexOf(id) === -1) {
        viewed.push(id);
        try {
            localStorage.setItem(VIEWED_KEY, JSON.stringify(viewed));
        } catch (e) { }
    }
}

var viewedIds = getViewedIds();

var selectAllMessages = document.getElementById('selectAllMessages');
var deleteSelectedMessages = document.getElementById('deleteSelectedMessages');
var messageList = document.getElementById('messageList');
var quoteSubjects = ['AI Commercial Ads', 'Product Advertising', 'Storytelling & Short Films', 'Custom Projects'];

function getMessageCheckboxes() {
    return Array.prototype.slice.call(document.querySelectorAll('.message-select'));
}

function updateSelectionControls() {
    var checkboxes = getMessageCheckboxes();
    var selectedCount = checkboxes.filter(function (checkbox) { return checkbox.checked; }).length;

    if (selectAllMessages) {
        selectAllMessages.checked = checkboxes.length > 0 && selectedCount === checkboxes.length;
        selectAllMessages.indeterminate = selectedCount > 0 && selectedCount < checkboxes.length;
    }

    if (deleteSelectedMessages) {
        deleteSelectedMessages.hidden = selectedCount === 0;
    }
}

function showDeleteToast(message, type) {
    var toast = document.createElement('div');
    toast.className = 'delete-toast delete-toast--' + type;
    toast.setAttribute('role', type === 'success' ? 'status' : 'alert');
    toast.textContent = message;
    document.body.appendChild(toast);

    window.setTimeout(function () {
        toast.classList.add('delete-toast--hidden');
        window.setTimeout(function () {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 180);
    }, 3200);
}

function deleteMessages(ids) {
    if (!ids.length || !window.confirm('Delete the selected message' + (ids.length === 1 ? '' : 's') + '?')) {
        return;
    }

    var inbox = document.getElementById('inbox');
    var deleteUrl = inbox ? inbox.dataset.deleteUrl : '';
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    fetch(deleteUrl, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken ? csrfToken.content : '',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ ids: ids }),
    }).then(function (response) {
        if (!response.ok) throw new Error('Delete failed');
        return response.json();
    }).then(function (result) {
        if (!result.deleted) throw new Error('Message was not deleted');

        ids.forEach(function (id) {
            var row = document.querySelector('.message-row-wrap[data-msg-id="' + id + '"]');
            if (row) row.remove();
        });
        var count = document.querySelector('.message-count');
        if (count) count.textContent = getMessageCheckboxes().length;
        updateSelectionControls();
        showDeleteToast(ids.length === 1 ? 'Message deleted successfully.' : ids.length + ' messages deleted successfully.', 'success');
    }).catch(function () {
        showDeleteToast('Unable to delete the selected message. Please try again.', 'error');
    });
}

if (selectAllMessages) {
    selectAllMessages.addEventListener('change', function () {
        getMessageCheckboxes().forEach(function (checkbox) {
            checkbox.checked = selectAllMessages.checked;
        });
        updateSelectionControls();
    });
}

if (deleteSelectedMessages) {
    deleteSelectedMessages.addEventListener('click', function () {
        deleteMessages(getMessageCheckboxes().filter(function (checkbox) { return checkbox.checked; }).map(function (checkbox) { return checkbox.value; }));
    });
}

function applyViewedState() {
    document.querySelectorAll('.message-row-wrap').forEach(function (wrap) {
        if (viewedIds.indexOf(wrap.dataset.msgId) !== -1) {
            wrap.classList.add('viewed');
        }
    });
}

if (messageList) {
    messageList.addEventListener('click', function (event) {
        var deleteButton = event.target.closest('.delete-message-btn');
        if (deleteButton) {
            event.stopPropagation();
            deleteMessages([deleteButton.dataset.messageId]);
            return;
        }

        var row = event.target.closest('.message-row');
        if (!row) return;

        var wrap = row.closest('.message-row-wrap');

        wrap.classList.add('viewed');
        markAsViewed(wrap.dataset.msgId);

        document.getElementById('fullViewName').textContent = wrap.dataset.name;
        document.getElementById('fullViewEmail').textContent = wrap.dataset.email;
        var phoneField = document.getElementById('fullViewPhoneField');
        document.getElementById('fullViewPhone').textContent = wrap.dataset.phone || 'Not provided';
        phoneField.style.display = quoteSubjects.indexOf(wrap.dataset.subject) !== -1 ? '' : 'none';
        document.getElementById('fullViewDate').textContent = wrap.dataset.date;
        document.getElementById('fullViewBody').textContent = wrap.dataset.message;

        var role = wrap.dataset.role;
        var roleField = document.getElementById('fullViewRole');
        var roleWrap = roleField ? roleField.closest('.message-detail-field') : null;
        var emailWrap = document.getElementById('fullViewEmail').closest('.message-detail-field');
        var dateWrap = document.getElementById('fullViewDate').closest('.message-detail-field');

        if (roleWrap) {
            if (role && role.trim() !== '') {
                roleField.textContent = role;
                roleWrap.style.display = '';
                emailWrap.style.borderRight = '';
                dateWrap.style.paddingLeft = '';
                dateWrap.style.borderLeft = '';
            } else {
                roleWrap.style.display = 'none';
                emailWrap.style.borderRight = 'none';
                dateWrap.style.paddingLeft = '0';
                dateWrap.style.borderLeft = 'none';
            }
        }

        document.getElementById('inbox').classList.add('viewing');
        document.getElementById('messageFullView').scrollTop = 0;
    });
    messageList.addEventListener('change', function (event) {
        if (event.target.classList.contains('message-select')) {
            updateSelectionControls();
        }
    });
}

function syncMessages() {
    if (!messageList || getMessageCheckboxes().some(function (checkbox) { return checkbox.checked; })) {
        return;
    }

    fetch(window.location.href, {
        headers: { 'Accept': 'application/json' },
    }).then(function (response) {
        if (!response.ok) throw new Error('Sync failed');
        return response.json();
    }).then(function (result) {
        if (result.html) {
            messageList.innerHTML = result.html;
            var count = document.querySelector('.message-count');
            if (count) count.textContent = result.count;
            applyViewedState();
            updateSelectionControls();
        }
    }).catch(function () {
        // The existing inbox remains usable when a background sync is unavailable.
    });
}

applyViewedState();
window.setInterval(syncMessages, 10000);

updateSelectionControls();

var backBtn = document.getElementById('backToList');
if (backBtn) {
    backBtn.addEventListener('click', function () {
        document.getElementById('inbox').classList.remove('viewing');
    });
}

var replyBtn = document.getElementById('replyBtn');
if (replyBtn) {
    replyBtn.addEventListener('click', function () {
        var email = document.getElementById('fullViewEmail').textContent.trim();
        if (!email || email === 'Not provided') return;

        var subject = 'Aizap Creatives';
        var senderAccount = 'aizapcreative@gmail.com';

        var url = 'https://mail.google.com/mail/?view=cm&fs=1&authuser=' + encodeURIComponent(senderAccount) + '&to=' + encodeURIComponent(email) + '&su=' + encodeURIComponent(subject);
        window.open(url, '_blank');
    });
}