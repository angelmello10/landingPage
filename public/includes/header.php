<!-- Scroll progress bar -->
<div id="nav-progress" aria-hidden="true"></div>

<header class="site-header invert-color" id="site-header">
    <div class="container">
        <div class="site-header-inner">

            <!-- Brand -->
            <div class="brand">
                <a href="index.php" class="brand-link">
                    <div class="brand-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                    <!-- <span class="brand-name">Reporte<strong>Ciudadano</strong></span> -->
                </a>
            </div>

            <!-- Nav -->
            <nav id="header-nav" class="header-nav">
                <div class="header-nav-inner">
                    <div class="nav-links">
                        <a class="header-link smooth-scroll" href="#mapa">Mapa en vivo</a>
                        <a class="header-link" href="#incidencias">Incidencias</a>
                    </div>
                    <!-- <div class="nav-actions">
                        <a class="header-link header-ghost modal-trigger" aria-controls="modal-consult" href="#0">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            Consultar folio
                        </a>
                        <a class="header-link header-cta modal-trigger" aria-controls="modal-report" href="#0">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                            Reportar ahora
                        </a>
                    </div> -->
                </div>
            </nav>

            <!-- Dark mode toggle -->
            <button id="dark-toggle" class="dark-toggle" aria-label="Cambiar tema" title="Modo oscuro / claro">
                <!-- Sun (shown in dark mode) -->
                <svg class="icon-sun" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                <!-- Moon (shown in light mode) -->
                <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            </button>

        </div>
    </div>
</header>

<script>
    /* Scroll progress + header shrink */
    (function () {
        const bar    = document.getElementById('nav-progress');
        const header = document.getElementById('site-header');
        let ticking  = false;
        function onScroll() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    const scrolled = window.scrollY;
                    const total    = document.documentElement.scrollHeight - window.innerHeight;
                    if (bar)    bar.style.width = (total > 0 ? (scrolled / total) * 100 : 0) + '%';
                    if (header) header.classList.toggle('is-scrolled', scrolled > 40);
                    ticking = false;
                });
                ticking = true;
            }
        }
        window.addEventListener('scroll', onScroll, { passive: true });
    })();

    /* Dark mode toggle */
    document.getElementById('dark-toggle').addEventListener('click', function(){
        var isDark = document.documentElement.classList.toggle('dark');
        try { localStorage.setItem('rc-theme', isDark ? 'dark' : 'light'); } catch(e){}
    });

    /* ── MOBILE NAV TOGGLE (propio, no depende de main.min.js) ── */
    (function () {
        var btn = document.getElementById('header-nav-toggle');
        var nav = document.getElementById('header-nav');
        if (!btn || !nav) return;

        function openNav() {
            nav.classList.add('mob-open');
            btn.setAttribute('aria-expanded', 'true');
            // también activa la animación de la hamburguesa del framework
            nav.classList.add('is-active');
        }
        function closeNav() {
            nav.classList.remove('mob-open', 'is-active');
            btn.setAttribute('aria-expanded', 'false');
        }
        function isOpen() { return nav.classList.contains('mob-open'); }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            isOpen() ? closeNav() : openNav();
        });

        // cerrar al tocar un link
        nav.querySelectorAll('.header-link').forEach(function (link) {
            link.addEventListener('click', closeNav);
        });

        // cerrar al tocar fuera
        document.addEventListener('click', function (e) {
            if (isOpen() && !nav.contains(e.target) && e.target !== btn) closeNav();
        });
    })();
</script>
