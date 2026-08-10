document.querySelectorAll('.eye-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var targetId = btn.getAttribute('data-target');
        var input = document.getElementById(targetId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.setAttribute('aria-label', 'Hide ' + targetId.replace(/_/g, ' '));
        } else {
            input.type = 'password';
            btn.setAttribute('aria-label', 'Show ' + targetId.replace(/_/g, ' '));
        }
    });
});