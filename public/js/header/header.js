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

(function () {
    var CONTENT_SELECTOR = '#app-content';
    var FADE_MS = 150;

    var contentEl = document.querySelector(CONTENT_SELECTOR);
    if (!contentEl) {
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
        if (link.tagName && link.tagName.toLowerCase() !== 'a') return false;
        if (link.closest && link.closest('[data-no-ajax]')) return false;
        if (link.hasAttribute('data-no-ajax')) return false;
        if (link.target && link.target !== '') return false;
        if (link.hasAttribute('download')) return false;

        var href = link.getAttribute('href');
        if (!href || href.charAt(0) === '#') return false;
        if (href.indexOf('mailto:') === 0 || href.indexOf('tel:') === 0) return false;

        try {
            var parsed = new URL(href, window.location.href);
            if (parsed.origin !== window.location.origin) return false;
            if (parsed.pathname === window.location.pathname && parsed.search === window.location.search) return false;
        } catch (e) {
            return false;
        }

        return true;
    }

    function closeAnyOpenMenus() {
        if (window.__closeMobileNav) window.__closeMobileNav();
        if (window.__closeServicesDropdown) window.__closeServicesDropdown();
    }

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

    var navInProgress = false;

    function loadPage(url, pushState) {
        if (navInProgress) return;
        navInProgress = true;
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
                    window.location.href = url;
                    return;
                }

                var fadeElapsed = new Promise(function (resolve) {
                    window.setTimeout(resolve, FADE_MS);
                });

                fadeElapsed.then(function () {
                    contentEl.innerHTML = newContent.innerHTML;
                    runInlineScripts(contentEl);

                    var newTitle = doc.querySelector('title');
                    if (newTitle) {
                        document.title = newTitle.textContent;
                    }

                    var resolvedUrl = new URL(url, window.location.href);
                    if (pushState) {
                        window.history.pushState({ ajaxNav: true }, '', resolvedUrl.pathname + resolvedUrl.search + resolvedUrl.hash);
                    }

                    updateActiveStates(window.location.pathname);
                    closeAnyOpenMenus();
                    window.scrollTo(0, 0);

                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () {
                            contentEl.classList.remove('is-loading');
                            contentEl.removeAttribute('aria-busy');
                            navInProgress = false;
                        });
                    });

                    document.dispatchEvent(new CustomEvent('ajaxnav:loaded', { detail: { url: url } }));
                });
            })
            .catch(function (err) {
                console.warn('[ajax-nav]', err);
                // fallback to full navigation when AJAX navigation fails
                window.location.href = url;
            });
    }

    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

        var link = e.target && e.target.closest ? e.target.closest('a[href]') : null;
        if (!shouldIntercept(link)) return;

        e.preventDefault();
        e.stopPropagation();
        loadPage(link.href, true);
    });

    window.addEventListener('popstate', function () {
        loadPage(window.location.href, false);
    });

    window.history.replaceState({ ajaxNav: true }, '', window.location.href);
})();