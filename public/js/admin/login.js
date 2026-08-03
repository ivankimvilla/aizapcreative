
document.querySelectorAll('.toggle-password').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var input = btn.previousElementSibling;
        var isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.setAttribute('aria-pressed', String(isPassword));
        btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        btn.classList.toggle('is-visible', isPassword);
    });
});
