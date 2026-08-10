document.addEventListener('DOMContentLoaded', function () {
    var button = document.getElementById('notificationButton');
    var dropdown = document.getElementById('notificationDropdown');

    if (!button || !dropdown) {
        return;
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
});
