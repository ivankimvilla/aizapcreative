(function () {
    var toggle = document.getElementById('siteNavToggle');
    var nav = document.getElementById('siteNav');

    if (!toggle || !nav) {
        return;
    }

    toggle.addEventListener('click', function () {
        var isOpen = nav.classList.toggle('site-header__nav--open');
        toggle.classList.toggle('site-header__toggle--open', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
})();

(function () {
    var svcToggle = document.getElementById('servicesToggle');
    var svcDropdown = document.getElementById('servicesDropdown');

    if (!svcToggle || !svcDropdown) {
        return;
    }

    function closeDropdown() {
        svcDropdown.hidden = true;
        svcToggle.setAttribute('aria-expanded', 'false');
        svcToggle.classList.remove('site-header__nav-link--open');
    }

    function openDropdown() {
        svcDropdown.hidden = false;
        svcToggle.setAttribute('aria-expanded', 'true');
        svcToggle.classList.add('site-header__nav-link--open');
    }

    svcToggle.addEventListener('click', function (e) {
        var isOpen = !svcDropdown.hidden;
        if (isOpen) {
            closeDropdown();
        } else {
            openDropdown();
        }
        e.stopPropagation();
    });

    // Close when clicking outside
    document.addEventListener('click', function (e) {
        var target = e.target;
        if (!svcDropdown.contains(target) && target !== svcToggle) {
            closeDropdown();
        }
    });
    // Close when clicking any link inside the dropdown
    svcDropdown.addEventListener('click', function (e) {
        var target = e.target;
        if (target && target.tagName === 'A') {
            closeDropdown();
        }
    });
})();
