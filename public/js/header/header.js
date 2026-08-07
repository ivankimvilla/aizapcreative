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

    window.__closeMobileNav = function () {
        nav.classList.remove('site-header__nav--open');
        toggle.classList.remove('site-header__toggle--open');
        toggle.setAttribute('aria-expanded', 'false');
    };
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

    window.__closeServicesDropdown = closeDropdown;
})();

(function () {
    var status = document.querySelector('.site-header__status');
    if (!status) return;

    window.setTimeout(function () {
        status.style.opacity = '0';
        status.style.transform = 'translateX(-50%) translateY(-4px)';
        window.setTimeout(function () {
            if (status && status.parentNode) {
                status.parentNode.removeChild(status);
            }
        }, 250);
    }, 4200);
})();

/**
 * AJAX navigation ("pjax"-style).
 *
 * Intercepts clicks on same-origin links, fetches the destination page,
 * swaps out #app-content, updates <title>, active nav states, and the
 * URL via history.pushState — avoiding a full page reload.
 *
 * Requirements on the Blade side:
 *   - Wrap page content in a container with id="app-content" in the
 *     master layout, e.g. <main id="app-content"> @yield('content') </main>
 *   - This header.js must be loaded on every page that uses the layout.
 *
 * Optional server-side optimization: if the request has header
 * X-Requested-With: XMLHttpRequest, your controller/layout can skip
 * rendering the header/footer and return just the #app-content markup,
 * which reduces payload size. The script works either way since it
 * only reads #app-content out of whatever HTML comes back.
 */
(function () {
    var CONTENT_SELECTOR = '#app-content';

    var contentEl = document.querySelector(CONTENT_SELECTOR);
    if (!contentEl) {
        // No content container found — AJAX nav disabled, links behave normally.
        return;
    }

    function isSameOrigin(href) {
        try {
            var a = document.createElement('a');
            a.href = href;
            return a.origin === window.location.origin;
        } catch (e) {
            return false;
        }
    }

    function shouldIntercept(link) {
        if (!link || !link.getAttribute) return false;
        if (link.hasAttribute('data-no-ajax')) return false;
        if (link.target && link.target !== '') return false;
        if (link.hasAttribute('download')) return false;

        var href = link.getAttribute('href');
        if (!href || href.charAt(0) === '#') return false;
        if (href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return false;
        if (!isSameOrigin(link.href)) return false;
        if (link.href === window.location.href) return false;

        return true;
    }

    function closeAnyOpenMenus() {
        if (window.__closeMobileNav) window.__closeMobileNav();
        if (window.__closeServicesDropdown) window.__closeServicesDropdown();
    }

    // Recomputes which nav/dropdown links should carry the "active" class,
    // mirroring the request()->is(...) checks used server-side in Blade.
    function updateActiveStates(pathname) {
        var path = pathname.replace(/\/+$/, '') || '/';

        document.querySelectorAll('.site-header__nav-link[href], .site-header__cta[href]').forEach(function (link) {
            var linkPath;
            try {
                linkPath = new URL(link.href).pathname.replace(/\/+$/, '') || '/';
            } catch (e) {
                return;
            }

            var isActive = linkPath === path;

            if (link.classList.contains('site-header__cta')) {
                link.classList.toggle('site-header__cta--active', isActive);
            } else {
                link.classList.toggle('site-header__nav-link--active', isActive);
            }
        });

        document.querySelectorAll('.site-header__services-links a[href]').forEach(function (link) {
            var linkPath;
            try {
                linkPath = new URL(link.href).pathname.replace(/\/+$/, '') || '/';
            } catch (e) {
                return;
            }
            link.classList.toggle('site-header__services-link--active', linkPath === path);
        });

        var servicesToggle = document.getElementById('servicesToggle');
        if (servicesToggle) {
            servicesToggle.classList.toggle('site-header__nav-link--active', path.indexOf('/what-we-do/') === 0);
        }
    }

    function runInlineScripts(container) {
        // Fetched HTML's <script> tags don't execute when injected via
        // innerHTML — re-create them so any page-specific JS still runs.
        container.querySelectorAll('script').forEach(function (oldScript) {
            var newScript = document.createElement('script');
            for (var i = 0; i < oldScript.attributes.length; i++) {
                var attr = oldScript.attributes[i];
                newScript.setAttribute(attr.name, attr.value);
            }
            newScript.textContent = oldScript.textContent;
            oldScript.parentNode.replaceChild(newScript, oldScript);
        });
    }

    function loadPage(url, pushState) {
        contentEl.setAttribute('aria-busy', 'true');
        contentEl.classList.add('is-loading');

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        })
            .then(function (res) {
                if (!res.ok) {
                    throw new Error('Navigation request failed: ' + res.status);
                }
                return res.text();
            })
            .then(function (html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                var newContent = doc.querySelector(CONTENT_SELECTOR);

                if (!newContent) {
                    // Response doesn't have the expected container
                    // (e.g. redirected to an external/full page) — fall back.
                    window.location.href = url;
                    return;
                }

                contentEl.innerHTML = newContent.innerHTML;
                runInlineScripts(contentEl);

                var newTitle = doc.querySelector('title');
                if (newTitle) {
                    document.title = newTitle.textContent;
                }

                if (pushState) {
                    window.history.pushState({ ajaxNav: true }, '', url);
                }

                updateActiveStates(window.location.pathname);
                closeAnyOpenMenus();
                window.scrollTo(0, 0);

                document.dispatchEvent(new CustomEvent('ajaxnav:loaded', { detail: { url: url } }));
            })
            .catch(function (err) {
                console.error('[ajax-nav]', err);
                // Fail safe: do a normal navigation so the user isn't stuck.
                window.location.href = url;
            })
            .finally(function () {
                contentEl.removeAttribute('aria-busy');
                contentEl.classList.remove('is-loading');
            });
    }

    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

        var link = e.target.closest ? e.target.closest('a[href]') : null;
        if (!shouldIntercept(link)) return;

        e.preventDefault();
        loadPage(link.href, true);
    });

    window.addEventListener('popstate', function () {
        loadPage(window.location.href, false);
    });

    // Mark the very first load as a history entry we can return to.
    window.history.replaceState({ ajaxNav: true }, '', window.location.href);
})();