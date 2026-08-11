document.addEventListener('click', function () {
    document.querySelectorAll('.booking-menu').forEach(function (menu) {
        menu.hidden = true;
    });
    document.querySelectorAll('.booking-menu-trigger').forEach(function (trigger) {
        trigger.setAttribute('aria-expanded', 'false');
    });
});

var selectAllBookings = document.getElementById('selectAllBookings');
var bookingBulkForm = document.getElementById('bulkDeleteBookingsForm');
var deleteSelectedBookings = document.getElementById('deleteSelectedBookings');
var bookingTableBody = document.querySelector('.booking-table tbody');
var bookingNoteModal = document.getElementById('bookingNoteModal');
var bookingNoteAuthor = document.getElementById('bookingNoteAuthor');
var bookingNoteText = document.getElementById('bookingNoteText');
var bookingNoteClose = document.getElementById('bookingNoteClose');

function getBookingSelections() {
    return Array.prototype.slice.call(document.querySelectorAll('.booking-select'));
}

function updateBookingSelection() {
    var checkboxes = getBookingSelections();
    var selected = checkboxes.filter(function (checkbox) { return checkbox.checked; });

    if (selectAllBookings) {
        selectAllBookings.checked = checkboxes.length > 0 && selected.length === checkboxes.length;
        selectAllBookings.indeterminate = selected.length > 0 && selected.length < checkboxes.length;
    }

    if (deleteSelectedBookings) {
        deleteSelectedBookings.disabled = selected.length === 0;
    }
}

if (selectAllBookings) {
    selectAllBookings.addEventListener('change', function () {
        getBookingSelections().forEach(function (checkbox) {
            checkbox.checked = selectAllBookings.checked;
        });
        updateBookingSelection();
    });
}

getBookingSelections().forEach(function (checkbox) {
    checkbox.addEventListener('change', updateBookingSelection);
});

if (bookingBulkForm) {
    bookingBulkForm.addEventListener('submit', function (event) {
        var selected = getBookingSelections().filter(function (checkbox) { return checkbox.checked; });

        if (!selected.length || !window.confirm('Delete the selected booking(s)? This action cannot be undone.')) {
            event.preventDefault();
            return;
        }

        selected.forEach(function (checkbox) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = checkbox.value;
            bookingBulkForm.appendChild(input);
        });
    });
}

updateBookingSelection();

document.addEventListener('click', function (event) {
    var noteButton = event.target.closest('.booking-note-view');
    if (noteButton) {
        var noteRow = noteButton.closest('tr');
        if (bookingNoteText && bookingNoteModal) {
            if (bookingNoteAuthor) bookingNoteAuthor.textContent = 'From: ' + (noteRow.dataset.name || 'Unknown');
            bookingNoteText.textContent = noteRow.dataset.note || 'No note provided.';
            bookingNoteModal.hidden = false;
        }
        return;
    }

    var trigger = event.target.closest('.booking-menu-trigger');
    if (!trigger) return;

    event.stopPropagation();
    var menu = trigger.nextElementSibling;
    var isOpen = !menu.hidden;

    document.querySelectorAll('.booking-menu').forEach(function (item) {
        item.hidden = true;
    });
    document.querySelectorAll('.booking-menu-trigger').forEach(function (item) {
        item.setAttribute('aria-expanded', 'false');
    });

    menu.hidden = isOpen;
    trigger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
});

function closeBookingNote() {
    if (bookingNoteModal) bookingNoteModal.hidden = true;
}

if (bookingNoteClose) bookingNoteClose.addEventListener('click', closeBookingNote);
if (bookingNoteModal) {
    bookingNoteModal.addEventListener('click', function (event) {
        if (event.target === bookingNoteModal) closeBookingNote();
    });
}

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') closeBookingNote();
});

document.addEventListener('submit', function (event) {
    if (event.target.matches('.delete-booking-form') && !window.confirm('Delete this booking? This action cannot be undone.')) {
        event.preventDefault();
    }
    if (event.target.matches('.cancel-booking-form') && !window.confirm('Cancel this booking?')) {
        event.preventDefault();
    }
});

document.addEventListener('change', function (event) {
    if (event.target.matches('.booking-select')) {
        updateBookingSelection();
    }
});

function syncBookings() {
    if (!bookingTableBody || getBookingSelections().some(function (checkbox) { return checkbox.checked; })) {
        return;
    }

    fetch(window.location.href, {
        headers: { 'Accept': 'application/json' },
    }).then(function (response) {
        if (!response.ok) throw new Error('Booking sync failed');
        return response.json();
    }).then(function (result) {
        if (!result.html) return;

        bookingTableBody.innerHTML = result.html;
        var statClasses = ['topbar-stat-all', 'topbar-stat-confirmed', 'topbar-stat-pending', 'topbar-stat-completed', 'topbar-stat-cancelled'];
        statClasses.forEach(function (className, index) {
            var count = document.querySelector('.' + className + ' strong');
            if (count) count.textContent = [result.stats.all, result.stats.confirmed, result.stats.pending, result.stats.completed, result.stats.cancelled][index];
        });
        updateBookingSelection();
    }).catch(function () {
        // Keep the current booking list usable if background sync is unavailable.
    });
}

window.setInterval(syncBookings, 10000);