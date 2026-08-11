document.addEventListener('DOMContentLoaded', function () {
    var button = document.getElementById('notificationButton');
    var dropdown = document.getElementById('notificationDropdown');
    var markAllReadButton = document.getElementById('markAllReadButton');
    var badge = document.querySelector('.notification-badge');
    var headerBadge = document.querySelector('.notification-header-badge');
    var list = dropdown ? dropdown.querySelector('.notification-list') : null;

    if (!button || !dropdown) {
        return;
    }

    function updateNotificationCount(count) {
        if (badge) {
            badge.textContent = count > 0 ? count : '';
        }
        if (headerBadge) {
            headerBadge.textContent = count > 0 ? count + ' new' : '0 new';
        }
        if (markAllReadButton) {
            markAllReadButton.disabled = count === 0;
        }
    }

    function setEmptyNotifications() {
        if (!list) return;
        list.innerHTML = '<li class="notification-empty">No new notifications.</li>';
    }

    function adjustCount(delta) {
        var current = parseInt(badge ? badge.textContent || '0' : '0', 10);
        var next = Math.max(0, current + delta);
        updateNotificationCount(next);
        if (next === 0) {
            setEmptyNotifications();
        }
    }

    function markNotificationRead(type, id, item) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            return;
        }

        fetch('/admin/notifications/' + encodeURIComponent(type) + '/' + encodeURIComponent(id) + '/read', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({}),
        }).then(function (response) {
            if (!response.ok) throw new Error('Mark read failed');
            return response.json();
        }).then(function () {
            if (item && item.parentNode) {
                item.parentNode.removeChild(item);
            }
            adjustCount(-1);
        }).catch(function () {
            // Ignore network failures; the server will still be consistent on refresh.
        });
    }

    button.addEventListener('click', function () {
        var expanded = button.getAttribute('aria-expanded') === 'true';
        button.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        dropdown.classList.toggle('show');
    });

    document.addEventListener('click', function (event) {
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.remove('show');
            button.setAttribute('aria-expanded', 'false');
        }
    });

    if (list) {
        list.addEventListener('click', function (event) {
            var action = event.target.closest('.notification-item-action');
            if (!action) {
                return;
            }

            event.preventDefault();
            var type = action.dataset.type;
            var id = action.dataset.id;
            var item = action.closest('.notification-item');
            if (type && id) {
                markNotificationRead(type, id, item);
            }
        });
    }

    if (markAllReadButton) {
        markAllReadButton.addEventListener('click', function () {
            var url = markAllReadButton.dataset.url;
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!url || !csrfToken) {
                return;
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
            }).then(function (response) {
                if (!response.ok) throw new Error('Mark all read failed');
                return response.json();
            }).then(function () {
                updateNotificationCount(0);
                setEmptyNotifications();
            }).catch(function () {
                // Ignore network failures.
            });
        });
    }
});
