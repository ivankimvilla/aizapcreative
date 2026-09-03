document.querySelectorAll('.settings-alert').forEach(function (alert) {
    window.setTimeout(function () {
        alert.classList.add('is-hidden');
    }, 5000);
});

(function () {
    var eyeSvg = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
    var eyeOffSvg = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';

    document.querySelectorAll('.eye-btn').forEach(function (btn) {
        if (!btn.innerHTML.trim()) btn.innerHTML = eyeSvg;

        btn.addEventListener('click', function () {
            var targetId = btn.getAttribute('data-target');
            var input = document.getElementById(targetId);
            var nowShowing = input.type === 'text';

            if (nowShowing) {
                input.type = 'password';
                btn.setAttribute('aria-label', 'Show ' + targetId.replace(/_/g, ' '));
                btn.innerHTML = eyeSvg;
            } else {
                input.type = 'text';
                btn.setAttribute('aria-label', 'Hide ' + targetId.replace(/_/g, ' '));
                btn.innerHTML = eyeOffSvg;
            }
        });
    });
})();