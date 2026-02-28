<!-- â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
     HAMBURGER MÃ“VIL â€” componente independiente
     Solo visible en pantallas â‰¤ 768px
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• -->
<style>
    /* â”€â”€ BotÃ³n flotante â”€â”€ */
    .mob-fab {
        display: none;
        position: fixed;
        top: 16px;
        right: 16px;
        z-index: 99999;
        width: 46px; height: 46px;
        border-radius: 13px;
        background: var(--primary);
        box-shadow: 0 4px 18px rgba(157,27,50,0.45);
        border: none;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 5px;
        padding: 0;
        transition: background .2s, transform .15s;
    }
    .mob-fab:active { transform: scale(0.93); }

    .mob-fab-bar {
        display: block;
        width: 20px; height: 2px;
        background: #fff;
        border-radius: 2px;
        transition: transform .25s ease, opacity .2s ease;
        transform-origin: center;
    }
    .mob-fab.is-open .mob-fab-bar:nth-child(1) { transform: translateY(7px) rotate(45deg); }
    .mob-fab.is-open .mob-fab-bar:nth-child(2) { opacity: 0; }
    .mob-fab.is-open .mob-fab-bar:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

    /* â”€â”€ Panel â€” oculto por defecto con visibility+opacity para poder transicionar â”€â”€ */
    .mob-menu {
        display: block;
        visibility: hidden;
        position: fixed;
        top: 72px;
        right: 12px;
        z-index: 99998;
        width: 230px;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.09);
        border-radius: 18px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 4px 16px rgba(0,0,0,0.08);
        padding: 10px 8px 12px;
        transform-origin: top right;
        transform: scale(0.9) translateY(-6px);
        opacity: 0;
        transition: transform .22s cubic-bezier(.34,1.56,.64,1),
                    opacity .18s ease,
                    visibility 0s linear .22s;
    }
    html.dark .mob-menu {
        background: #0e1117;
        border-color: rgba(255,255,255,0.09);
        box-shadow: 0 20px 60px rgba(0,0,0,0.55);
    }
    .mob-menu.is-open {
        visibility: visible;
        transform: scale(1) translateY(0);
        opacity: 1;
        transition: transform .22s cubic-bezier(.34,1.56,.64,1),
                    opacity .18s ease,
                    visibility 0s linear 0s;
    }

    .mob-menu-label {
        font-size: 0.68rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase;
        color: #94a3b8; padding: 6px 12px 4px;
    }
    .mob-menu-link {
        display: flex; align-items: center; gap: 10px;
        padding: 11px 12px; border-radius: 11px;
        text-decoration: none; font-size: 0.88rem; font-weight: 600;
        color: #0d1117;
        transition: background .15s, color .15s;
        cursor: pointer; border: none; background: none;
        width: 100%; text-align: left; font-family: inherit;
    }
    .mob-menu-link:hover  { background: rgba(157,27,50,0.07); color: var(--primary); }
    .mob-menu-link:active { background: rgba(157,27,50,0.13); }
    html.dark .mob-menu-link       { color: rgba(255,255,255,0.85); }
    html.dark .mob-menu-link:hover { background: rgba(255,255,255,0.07); color: #fff; }
    .mob-menu-link svg { flex-shrink: 0; opacity: 0.55; }
    .mob-menu-link:hover svg { opacity: 1; }

    .mob-menu-divider {
        height: 1px; background: rgba(0,0,0,0.07); margin: 6px 8px;
    }
    html.dark .mob-menu-divider { background: rgba(255,255,255,0.07); }

    .mob-menu-link--cta {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
        color: #fff !important; margin-top: 2px;
        box-shadow: 0 4px 14px rgba(157,27,50,0.3);
    }
    .mob-menu-link--cta:hover { filter: brightness(1.08) !important; color: #fff !important; }
    .mob-menu-link--cta svg { opacity: 1 !important; }

    /* Overlay */
    .mob-overlay {
        display: none;
        position: fixed; inset: 0;
        z-index: 99997;
        background: rgba(0,0,0,0.15);
        opacity: 0;
        transition: opacity .2s;
    }
    .mob-overlay.is-open { opacity: 1; pointer-events: auto; }

    @media (max-width: 768px) {
        .mob-fab    { display: flex; }
        .mob-overlay { display: block; pointer-events: none; }
    }
</style>

<div id="mob-overlay" class="mob-overlay"></div>

<button id="mob-fab" class="mob-fab" aria-label="MenÃº" aria-expanded="false">
    <span class="mob-fab-bar"></span>
    <span class="mob-fab-bar"></span>
    <span class="mob-fab-bar"></span>
</button>

<nav id="mob-menu" class="mob-menu">

    <div class="mob-menu-label">Navegar</div>

    <a href="#mapa" class="mob-menu-link mob-nav-link smooth-scroll">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        Mapa en vivo
    </a>

    <a href="#incidencias" class="mob-menu-link mob-nav-link smooth-scroll">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
        Incidencias
    </a>

    <div class="mob-menu-divider"></div>
    <div class="mob-menu-label">Acciones</div>

    <a href="#0" class="mob-menu-link mob-nav-link modal-trigger" aria-controls="modal-consult">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        Consultar folio
    </a>

    <a href="#0" class="mob-menu-link mob-nav-link mob-menu-link--cta modal-trigger" aria-controls="modal-report">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        Reportar ahora
    </a>

    <div class="mob-menu-divider"></div>

    <button id="mob-dark-toggle" class="mob-menu-link">
        <svg id="mob-icon-moon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        <svg id="mob-icon-sun"  width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/></svg>
        <span id="mob-dark-label">Modo oscuro</span>
    </button>

</nav>

<script>
(function () {
    var fab     = document.getElementById('mob-fab');
    var menu    = document.getElementById('mob-menu');
    var overlay = document.getElementById('mob-overlay');
    if (!fab || !menu) return;

    function open() {
        menu.classList.add('is-open');
        overlay.classList.add('is-open');
        fab.classList.add('is-open');
        fab.setAttribute('aria-expanded', 'true');
    }
    function close() {
        menu.classList.remove('is-open');
        overlay.classList.remove('is-open');
        fab.classList.remove('is-open');
        fab.setAttribute('aria-expanded', 'false');
    }

    fab.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.contains('is-open') ? close() : open();
    });
    overlay.addEventListener('click', close);

    menu.querySelectorAll('.mob-nav-link').forEach(function (link) {
        link.addEventListener('click', function () { setTimeout(close, 150); });
    });

    // Dark mode
    var darkBtn   = document.getElementById('mob-dark-toggle');
    var iconMoon  = document.getElementById('mob-icon-moon');
    var iconSun   = document.getElementById('mob-icon-sun');
    var darkLabel = document.getElementById('mob-dark-label');

    function syncDark() {
        var dark = document.documentElement.classList.contains('dark');
        iconMoon.style.display = dark ? 'none' : '';
        iconSun.style.display  = dark ? ''     : 'none';
        darkLabel.textContent  = dark ? 'Modo claro' : 'Modo oscuro';
    }
    syncDark();

    darkBtn.addEventListener('click', function () {
        var isDark = document.documentElement.classList.toggle('dark');
        try { localStorage.setItem('rc-theme', isDark ? 'dark' : 'light'); } catch(e) {}
        syncDark();
        setTimeout(close, 200);
    });
})();
</script>
