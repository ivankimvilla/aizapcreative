document.addEventListener('DOMContentLoaded', function () {
    function createToast(message, type = 'success', timeout = 4500) {
        const container = document.getElementById('toast-container') || (() => {
            const el = document.createElement('div');
            el.id = 'toast-container';
            document.body.appendChild(el);
            return el;
        })();

        const toast = document.createElement('div');
        toast.className = 'toast ' + (type === 'error' ? 'error' : 'success');

        const icon = document.createElement('span');
        icon.className = 'icon';
        icon.innerHTML = type === 'error' ? '⚠️' : '✓';

        const msg = document.createElement('div');
        msg.className = 'message';
        msg.textContent = message;

        const close = document.createElement('button');
        close.className = 'close';
        close.type = 'button';
        close.innerHTML = '✕';
        close.addEventListener('click', () => removeToast(toast));

        toast.appendChild(icon);
        toast.appendChild(msg);
        toast.appendChild(close);

        container.appendChild(toast);

        // show
        requestAnimationFrame(() => toast.classList.add('show'));

        const id = setTimeout(() => removeToast(toast), timeout);
        toast.dataset.timeoutId = id;
        return toast;
    }

    function removeToast(toast) {
        if (!toast) return;
        const id = toast.dataset.timeoutId;
        if (id) clearTimeout(id);
        toast.classList.remove('show');
        setTimeout(() => { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 220);
    }

    // Expose for debug
    window.showToast = createToast;

    // Auto-show server flash messages: look for .form-status and .form-errors
    const formStatus = document.querySelector('.form-status');
    if (formStatus && formStatus.textContent.trim()) {
        createToast(formStatus.textContent.trim(), 'success');
    }

    const formErrors = document.querySelector('.form-errors');
    if (formErrors) {
        // show first error as toast
        const first = formErrors.querySelector('li');
        if (first && first.textContent.trim()) {
            createToast(first.textContent.trim(), 'error');
        }
    }
});
