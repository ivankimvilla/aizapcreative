

(function () {
  function initSidebar() {
    var sidebar = document.getElementById('sidebar');
    var toggle = document.getElementById('menuToggle');
    var closeBtn = document.getElementById('sidebarClose');

    if (!sidebar) {
      return;
    }

    function openSidebar() {
      sidebar.classList.add('open');
      if (toggle) {
        toggle.classList.add('menu-toggle--open');
        toggle.setAttribute('aria-expanded', 'true');
      }
      var backdrop = document.getElementById('sidebarBackdrop');
      if (backdrop) {
        backdrop.hidden = false;
        backdrop.classList.add('open');
      }
    }

    function closeSidebar() {
      sidebar.classList.remove('open');
      if (toggle) {
        toggle.classList.remove('menu-toggle--open');
        toggle.setAttribute('aria-expanded', 'false');
      }
      var backdrop = document.getElementById('sidebarBackdrop');
      if (backdrop) {
        backdrop.classList.remove('open');
        // hide after transition
        setTimeout(function () { backdrop.hidden = true; }, 200);
      }
    }

    if (toggle) {
      toggle.addEventListener('click', function () {
        if (sidebar.classList.contains('open')) {
          closeSidebar();
        } else {
          openSidebar();
        }
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', closeSidebar);
    }
    var backdropEl = document.getElementById('sidebarBackdrop');
    if (backdropEl) {
      backdropEl.addEventListener('click', closeSidebar);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSidebar);
  } else {
    initSidebar();
  }
})();
