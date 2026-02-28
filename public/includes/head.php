<!DOCTYPE html>
<html lang="es" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reporte Ciudadano</title>
    <meta name="description"
        content="Plataforma de reporte ciudadano para registrar incidencias, consultar estatus y visualizar reportes en mapa en tiempo real.">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Dark mode: apply class BEFORE paint to avoid FOUC -->
    <script>
        (function(){
            try { if(localStorage.getItem('rc-theme')==='dark') document.documentElement.classList.add('dark'); } catch(e){}
        })();
    </script>
    <style>
        /* ═══════════════════════════════════════════════════
           DESIGN SYSTEM — Reporte Ciudadano
        ═══════════════════════════════════════════════════ */
        :root {
            --primary: #9D1B32;
            --primary-light: #c42845;
            --primary-dark: #6e1122;
            --primary-glow: rgba(157,27,50,0.38);
            --primary-glow-soft: rgba(157,27,50,0.16);
            --dark: #06080c;
            --dark-2: #0e1117;
            --dark-3: #161b24;
            --gray: #64748b;
            --gray-light: #94a3b8;
            --gray-muted: #cbd5e1;
            --bg: #f0f3f8;
            --bg-alt: #e8ecf3;
            --bg-card: #ffffff;
            --border: #dde3ec;
            --border-light: #edf0f7;
            --white: #ffffff;
            --text: #0d1117;
            --text-muted: #64748b;
            --status-pending: #d97706;
            --status-resolved: #059669;
            --status-inprogress: #2563eb;
            --status-rejected: #dc2626;
            --shadow-xs: 0 1px 3px rgba(13,17,23,0.06);
            --shadow-sm: 0 2px 8px rgba(13,17,23,0.07), 0 1px 3px rgba(13,17,23,0.04);
            --shadow-md: 0 8px 24px rgba(13,17,23,0.09), 0 3px 8px rgba(13,17,23,0.05);
            --shadow-lg: 0 20px 40px rgba(13,17,23,0.12), 0 8px 16px rgba(13,17,23,0.06);
            --shadow-xl: 0 32px 64px rgba(13,17,23,0.16), 0 16px 32px rgba(13,17,23,0.08);
            --shadow-primary: 0 8px 32px rgba(157,27,50,0.3), 0 2px 8px rgba(157,27,50,0.18);
            --r-xs: 6px; --r-sm: 8px; --r-md: 12px; --r-lg: 16px; --r-xl: 22px; --r-2xl: 32px; --r-full: 9999px;
            --ease-bounce: cubic-bezier(0.34,1.56,0.64,1);
            --ease-out: cubic-bezier(0.22,1,0.36,1);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--text);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }
        ::selection { background: rgba(157,27,50,0.18); color: var(--primary-dark); }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #e8ecf3; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }

        /* ── SCROLL PROGRESS BAR ── */
        #nav-progress {
            position: fixed; top: 0; left: 0; height: 2px; width: 0;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 60%, #f87171 100%);
            z-index: 200; transition: width .1s linear;
            box-shadow: 0 0 8px var(--primary-glow);
        }

        /* ── HEADER ── */
        .site-header {
            background: rgba(255,255,255,0.92) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border-bottom: 1px solid rgba(0,0,0,0.07) !important;
            box-shadow: 0 1px 12px rgba(0,0,0,0.06);
            position: sticky !important; top: 0; z-index: 200 !important;
            transition: background .3s, border-color .3s, box-shadow .3s, padding .3s;
        }
        /* Scrolled state */
        .site-header.is-scrolled {
            background: rgba(255,255,255,0.97) !important;
            border-bottom-color: rgba(157,27,50,0.15) !important;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }

        /* Dark mode: restore the original dark glass header */
        html.dark .site-header {
            background: rgba(6,8,12,0.7) !important;
            border-bottom: 1px solid rgba(255,255,255,0.06) !important;
            box-shadow: none;
        }
        html.dark .site-header.is-scrolled {
            background: rgba(6,8,12,0.92) !important;
            border-bottom-color: rgba(157,27,50,0.3) !important;
            box-shadow: 0 4px 32px rgba(0,0,0,0.4);
        }

        /* Brand */
        .brand-link {
            display: inline-flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .brand-icon {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px var(--primary-glow-soft);
            transition: box-shadow .2s, transform .2s;
        }
        .brand-link:hover .brand-icon { transform: rotate(-6deg) scale(1.08); box-shadow: 0 6px 20px var(--primary-glow); }
        .brand-name {
            font-size: 0.95rem; color: rgba(0,0,0,0.55); font-weight: 400;
            letter-spacing: -0.01em;
        }
        .brand-name strong { color: #0d1117; font-weight: 800; }
        html.dark .brand-name       { color: rgba(255,255,255,0.75); }
        html.dark .brand-name strong { color: #fff; }

        /* Nav layout — desktop */
        .header-nav-inner {
            display: flex; align-items: center; justify-content: flex-end;
            gap: 0; width: 100%;
        }
        .nav-links {
            display: flex; align-items: center; gap: 2px;
            margin-right: 12px;
        }
        .nav-actions {
            display: flex; align-items: center; gap: 8px;
        }

        /* Nav links */
        .header-link {
            display: inline-flex; align-items: center; gap: 6px;
            color: rgba(0,0,0,0.55); font-size: 0.82rem; font-weight: 600;
            text-decoration: none; padding: 7px 14px; border-radius: var(--r-full);
            border: 1px solid transparent;
            transition: color .2s, background .2s;
            position: relative;
        }
        .header-link::after {
            content: ''; position: absolute; bottom: 4px; left: 50%; right: 50%;
            height: 1.5px; background: var(--primary-light);
            transition: left .25s var(--ease-out), right .25s var(--ease-out);
            border-radius: 9px;
        }
        .nav-links .header-link:hover { color: var(--primary); }
        .nav-links .header-link:hover::after { left: 14px; right: 14px; }
        /* Dark mode nav links */
        html.dark .header-link              { color: rgba(255,255,255,0.55); }
        html.dark .nav-links .header-link:hover { color: #fff; }

        /* Ghost CTA */
        .header-ghost {
            color: rgba(0,0,0,0.55) !important;
            border: 1px solid rgba(0,0,0,0.14) !important;
            padding: 7px 14px !important;
        }
        .header-ghost::after { display: none; }
        .header-ghost:hover {
            color: var(--primary) !important;
            background: rgba(157,27,50,0.06) !important;
            border-color: rgba(157,27,50,0.2) !important;
        }
        html.dark .header-ghost             { color: rgba(255,255,255,0.65) !important; border-color: rgba(255,255,255,0.14) !important; }
        html.dark .header-ghost:hover       { color: #fff !important; background: rgba(255,255,255,0.07) !important; border-color: rgba(255,255,255,0.22) !important; }

        /* Primary CTA */
        .header-cta {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
            color: #fff !important;
            border: 1px solid rgba(255,255,255,0.15) !important;
            padding: 7px 16px !important;
            box-shadow: 0 4px 14px var(--primary-glow-soft);
        }
        .header-cta::after { display: none; }
        .header-cta:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px var(--primary-glow) !important;
            color: #fff !important;
        }

        /* Hamburger bars — dark on light bg, white on dark bg */
        .header-nav-toggle {
            background: none !important;
            border: none !important;
            padding: 8px !important;
            cursor: pointer;
            display: none !important; /* reemplazado por hamburger-mobile.php */
            z-index: 10;
        }
        .hamburger-inner,
        .hamburger-inner::before,
        .hamburger-inner::after { background: #0d1117 !important; }
        html.dark .hamburger-inner,
        html.dark .hamburger-inner::before,
        html.dark .hamburger-inner::after { background: #fff !important; }

        /* ── MOBILE NAV ── */
        @media (max-width: 768px) {
            .header-nav-toggle { display: block !important; }

            /* override style.css adjacent-sibling rule with !important */
            .header-nav-toggle + .header-nav,
            .header-nav {
                position: fixed !important;
                top: 72px !important;
                left: 0 !important; right: 0 !important;
                width: 100% !important;
                background: rgba(255,255,255,0.98) !important;
                backdrop-filter: blur(20px) !important;
                -webkit-backdrop-filter: blur(20px) !important;
                border-bottom: 1px solid rgba(0,0,0,0.09) !important;
                box-shadow: 0 16px 40px rgba(0,0,0,0.12) !important;
                z-index: 9999 !important;
                flex-grow: 0 !important;
                flex-direction: column !important;
                overflow: hidden !important;
                /* hidden state */
                max-height: 0 !important;
                opacity: 0 !important;
                pointer-events: none !important;
                transition: max-height .35s ease, opacity .25s ease !important;
            }
            .header-nav-toggle + .header-nav.mob-open,
            .header-nav.mob-open {
                max-height: 400px !important;
                opacity: 1 !important;
                pointer-events: auto !important;
            }
            html.dark .header-nav-toggle + .header-nav,
            html.dark .header-nav {
                background: rgba(10,14,22,0.97) !important;
                border-bottom-color: rgba(255,255,255,0.07) !important;
            }

            .header-nav-inner {
                flex-direction: column !important;
                align-items: stretch !important;
                padding: 12px 16px 20px !important;
                gap: 4px !important;
            }
            .nav-links {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 2px !important;
                margin-right: 0 !important;
            }
            .header-link {
                justify-content: flex-start !important;
                padding: 13px 16px !important;
                font-size: 0.95rem !important;
                border-radius: var(--r-md) !important;
                color: #0d1117 !important;
                border: none !important;
            }
            .header-link::after { display: none !important; }
            .header-link:hover, .header-link:active {
                background: rgba(157,27,50,0.07) !important;
                color: var(--primary) !important;
            }
            html.dark .header-link { color: rgba(255,255,255,0.85) !important; }
            html.dark .header-link:hover { background: rgba(255,255,255,0.07) !important; color: #fff !important; }
        }

        /* ── HERO ── */
        .hero.has-bg-color { position: relative; overflow: hidden; }
        /* Light mode: clean white-to-light-rose gradient */
        .hero.has-bg-color::before {
            background: linear-gradient(145deg, #ffffff 0%, #fdf2f4 45%, #fce8ec 75%, #f5f7fb 100%) !important;
        }
        .hero.has-bg-color::after {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 10% 40%, rgba(157,27,50,0.07) 0%, transparent 58%),
                radial-gradient(ellipse 50% 70% at 85% 10%, rgba(157,27,50,0.05) 0%, transparent 55%),
                radial-gradient(ellipse 35% 40% at 50% 90%, rgba(157,27,50,0.06) 0%, transparent 60%);
            animation: hero-pulse 10s ease-in-out infinite alternate;
            pointer-events: none; z-index: 0;
        }
        /* Subtle grid overlay on hero */
        .hero.has-bg-color .container { position: relative; z-index: 1; }
        .hero-grid-overlay {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
            background-image: linear-gradient(rgba(0,0,0,0.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(0,0,0,0.04) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black, transparent);
        }
        @keyframes hero-pulse {
            0%   { opacity: .65; transform: scale(1); }
            50%  { opacity: .9; }
            100% { opacity: 1; transform: scale(1.06); }
        }
        .hero-inner { position: relative; z-index: 1; }
        /* Light mode: dark text on light hero */
        .hero-content h1 {
            font-family: 'Space Grotesk', 'Inter', system-ui, sans-serif;
            font-weight: 700; letter-spacing: -0.03em; line-height: 1.2;
            background: linear-gradient(150deg, #0d1117 0%, #3a0a14 45%, #9D1B32 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
            margin-bottom: 1.25rem;
        }
        .hero-content p { color: #475569; font-size: 1.05rem; line-height: 1.8; max-width: 520px; margin-bottom: 2rem; }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 9px;
            font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.14em; font-weight: 700;
            color: var(--primary); background: rgba(157,27,50,0.08); border: 1px solid rgba(157,27,50,0.2);
            border-radius: var(--r-full); padding: 8px 16px; margin-bottom: 1.1rem;
        }
        .hero-eyebrow::before {
            content: ''; width: 7px; height: 7px; border-radius: 50%; background: var(--primary);
            box-shadow: 0 0 0 4px rgba(157,27,50,0.15);
            animation: live-dot 2s ease-in-out infinite;
        }
        @keyframes live-dot {
            0%, 100% { box-shadow: 0 0 0 4px rgba(157,27,50,0.12); }
            50%       { box-shadow: 0 0 0 7px rgba(157,27,50,0.05), 0 0 16px rgba(157,27,50,0.2); }
        }
        .hero-content .button-group { margin-bottom: 2rem; gap: 12px; }
        .hero-trust { display: flex; flex-wrap: wrap; gap: 9px; }
        .hero-trust-item {
            display: inline-flex; align-items: center; gap: 7px; color: #64748b;
            font-size: 0.78rem; font-weight: 600; background: rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.08); border-radius: var(--r-full); padding: 7px 13px;
        }
        .hero-trust-item svg { opacity: .6; flex-shrink: 0; }
        .hero-figure { position: relative; }
        .hero-figure img { border-radius: var(--r-xl); box-shadow: var(--shadow-xl), 0 0 0 1px rgba(0,0,0,0.06); }
        .hero-figure-badge {
            position: absolute; right: 16px; bottom: 16px;
            background: rgba(255,255,255,0.92); color: #0d1117;
            font-size: 0.73rem; font-weight: 700; letter-spacing: 0.02em;
            border-radius: var(--r-md); padding: 9px 14px;
            border: 1px solid rgba(0,0,0,0.1); backdrop-filter: blur(12px);
            box-shadow: var(--shadow-lg);
        }
        .hero-figure-badge::before {
            content: ''; display: inline-block; width: 6px; height: 6px;
            border-radius: 50%; background: #34d399; margin-right: 6px; vertical-align: middle;
            box-shadow: 0 0 8px rgba(52,211,153,0.6);
        }

        /* ── DARK MODE: restore original dark hero ── */
        html.dark .hero.has-bg-color::before {
            background: linear-gradient(145deg, #06080c 0%, #0f0208 45%, #08040a 75%, #0a0a0e 100%) !important;
        }
        html.dark .hero.has-bg-color::after {
            background:
                radial-gradient(ellipse 70% 60% at 10% 40%, rgba(157,27,50,0.22) 0%, transparent 58%),
                radial-gradient(ellipse 50% 70% at 85% 10%, rgba(120,20,40,0.14) 0%, transparent 55%),
                radial-gradient(ellipse 35% 40% at 50% 90%, rgba(80,10,25,0.18) 0%, transparent 60%),
                radial-gradient(ellipse 20% 20% at 65% 55%, rgba(157,27,50,0.10) 0%, transparent 60%);
        }
        html.dark .hero-grid-overlay {
            background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
        }
        html.dark .hero-content h1 {
            font-family: 'Space Grotesk', 'Inter', system-ui, sans-serif;
            background: linear-gradient(150deg, #ffffff 0%, #ffe4e8 45%, #fca5a5 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        html.dark .hero-content p { color: #8899ad; }
        html.dark .hero-eyebrow {
            color: #fdd8de; background: rgba(157,27,50,0.22); border-color: rgba(255,100,120,0.3);
            backdrop-filter: blur(8px);
        }
        html.dark .hero-eyebrow::before {
            background: #f87171;
            box-shadow: 0 0 0 4px rgba(248,113,113,0.25), 0 0 12px rgba(248,113,113,0.4);
        }
        html.dark .hero-trust-item {
            color: #94a3b8; background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.1); backdrop-filter: blur(6px);
        }
        html.dark .hero-figure-badge {
            background: rgba(6,8,12,0.82); color: #fff;
            border-color: rgba(255,255,255,0.12);
        }

        /* ── STATS STRIP (hero bottom) ── */
        .hero-stats-strip {
            display: flex; gap: 0; border-top: 1px solid rgba(0,0,0,0.08);
            margin-top: 3.5rem; padding-top: 0; position: relative; z-index: 2;
            background: rgba(255,255,255,0.5); backdrop-filter: blur(8px);
            border-radius: var(--r-xl); overflow: hidden;
        }
        .hero-stat {
            flex: 1; text-align: center; padding: 1.75rem 1rem;
            border-right: 1px solid rgba(0,0,0,0.07);
        }
        .hero-stat:last-child { border-right: none; }
        .hero-stat-num {
            display: block; font-size: clamp(1.8rem, 3vw, 2.6rem); font-weight: 900;
            letter-spacing: -0.04em; line-height: 1;
            background: linear-gradient(135deg, #0d1117 0%, var(--primary) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-stat-label {
            display: block; margin-top: 8px; font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.1em; color: #64748b;
        }
        html.dark .hero-stats-strip { border-top-color: rgba(255,255,255,0.08); }
        html.dark .hero-stat         { border-right-color: rgba(255,255,255,0.07); }
        html.dark .hero-stat-num {
            background: linear-gradient(135deg, #fff 0%, #fca5a5 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        /* ── BUTTONS ── */
        .button {
            border-radius: var(--r-full) !important; font-weight: 700; font-size: 0.88rem;
            letter-spacing: 0.01em; transition: transform .2s var(--ease-out), box-shadow .2s var(--ease-out);
            position: relative; overflow: hidden;
        }
        .button::after {
            content: ''; position: absolute; inset: 0;
            background: rgba(255,255,255,0); transition: background .2s; border-radius: inherit;
        }
        .button:hover::after { background: rgba(255,255,255,0.09); }
        .button-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
            border-color: transparent !important;
            box-shadow: var(--shadow-primary), inset 0 1px 0 rgba(255,255,255,0.12);
        }
        .button-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 36px var(--primary-glow), inset 0 1px 0 rgba(255,255,255,0.12); }
        .button-dark {
            background: #1e293b !important; color: #fff !important;
            border: 1px solid rgba(255,255,255,0.12) !important;
        }
        .button-dark:hover { background: #334155 !important; transform: translateY(-2px); }
        html.dark .button-dark {
            background: rgba(255,255,255,0.09) !important;
            border-color: rgba(255,255,255,0.18) !important;
            backdrop-filter: blur(8px);
        }
        html.dark .button-dark:hover { background: rgba(255,255,255,0.15) !important; }

        /* ── SECTION HELPERS ── */
        .section-label {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.14em;
            color: var(--primary); background: rgba(157,27,50,0.1);
            border: 1px solid rgba(157,27,50,0.2); border-radius: var(--r-full);
            padding: 5px 13px; margin-bottom: 0.85rem;
        }
        .section-header h2 {
            font-family: 'Space Grotesk', 'Inter', system-ui, sans-serif;
            font-weight: 700; letter-spacing: -0.03em; color: var(--text);
            font-size: clamp(1.75rem, 3.5vw, 2.7rem); line-height: 1.2;
            margin-bottom: 1rem;
        }
        .section-header p { color: var(--gray); font-size: 1.02rem; line-height: 1.75; max-width: 560px; margin-left: auto; margin-right: auto; }
        .has-top-divider::before, .has-bottom-divider::after { background: var(--border) !important; opacity: 1; }

        /* ── FEATURES ── */
        .features-tiles {
            background: var(--white);
            background-image:
                radial-gradient(circle at 0% 100%, rgba(157,27,50,0.05) 0%, transparent 40%),
                radial-gradient(circle at 100% 0%, rgba(157,27,50,0.04) 0%, transparent 40%);
        }
        .features-tiles .section-header { margin-bottom: 3rem; }
        .features-tiles .tiles-item-inner {
            background: var(--white); border-radius: var(--r-xl);
            padding: 2rem 1.75rem; border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: transform .3s var(--ease-out), box-shadow .3s var(--ease-out), border-color .3s;
            position: relative; overflow: hidden;
        }
        .features-tiles .tiles-item-inner::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 50%, transparent 100%);
            border-radius: var(--r-xl) var(--r-xl) 0 0;
        }
        .features-tiles .tiles-item-inner::after {
            content: ''; position: absolute; inset: 0; border-radius: inherit;
            background: radial-gradient(circle at 50% 0%, rgba(157,27,50,0.05) 0%, transparent 70%);
            opacity: 0; transition: opacity .3s;
        }
        .features-tiles .tiles-item-inner:hover { transform: translateY(-7px); box-shadow: var(--shadow-lg); border-color: rgba(157,27,50,0.2); }
        .features-tiles .tiles-item-inner:hover::after { opacity: 1; }
        .features-tiles-item-image {
            width: 52px; height: 52px; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
            border-radius: var(--r-md); box-shadow: 0 6px 20px var(--primary-glow-soft);
            position: relative; z-index: 1;
        }
        .features-tiles-item-image img { width: 28px; height: 28px; filter: brightness(0) invert(1); }
        .features-tiles h4 {
            font-family: 'Space Grotesk', 'Inter', system-ui, sans-serif;
            font-weight: 700; color: var(--text); letter-spacing: -0.02em; font-size: 1.15rem; margin-bottom: 0.75rem;
        }
        .features-tiles p.text-sm { color: var(--text-muted); line-height: 1.75; font-size: 0.92rem; }

        /* ── HOW IT WORKS — redesigned ── */
        .how-it-works {
            padding: 6rem 0 6.5rem;
            background: var(--white);
            position: relative; overflow: hidden;
        }
        .how-it-works::before {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 60% 50% at 10% 0%, rgba(157,27,50,0.04) 0%, transparent 100%),
                radial-gradient(ellipse 60% 50% at 90% 100%, rgba(157,27,50,0.03) 0%, transparent 100%);
        }
        .hiw-header { margin-bottom: 4rem; }

        /* 5-col layout: step / connector / step / connector / step */
        .hiw-grid {
            display: grid;
            grid-template-columns: 1fr 80px 1fr 80px 1fr;
            align-items: center;
            gap: 0;
        }

        /* Step card */
        .hiw-step {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-2xl);
            padding: 2.25rem 2rem 2rem;
            box-shadow: var(--shadow-sm);
            position: relative; overflow: hidden;
            transition: transform .35s var(--ease-out), box-shadow .35s var(--ease-out);
            display: flex; flex-direction: column;
        }
        .hiw-step::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            border-radius: var(--r-2xl) var(--r-2xl) 0 0;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-light) 100%);
        }
        .hiw-step:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); }

        /* Ghost big number */
        .hiw-step-bg-num {
            position: absolute; right: 16px; top: 12px;
            font-size: 5.5rem; font-weight: 900; line-height: 1;
            color: var(--primary); opacity: 0.055;
            letter-spacing: -0.06em; pointer-events: none; user-select: none;
        }

        /* Icon circle */
        .hiw-icon-wrap {
            width: 54px; height: 54px; border-radius: var(--r-lg);
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff; margin-bottom: 1.2rem; flex-shrink: 0;
            box-shadow: 0 8px 24px var(--primary-glow-soft);
            position: relative; z-index: 1;
        }

        /* Paso badge */
        .hiw-badge {
            font-size: 0.65rem; font-weight: 800; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--primary); margin-bottom: 0.5rem;
            position: relative; z-index: 1;
        }

        .hiw-title {
            font-family: 'Space Grotesk', 'Inter', system-ui, sans-serif;
            font-size: 1.15rem; font-weight: 700; color: var(--text);
            letter-spacing: -0.02em; margin: 0 0 0.75rem;
            position: relative; z-index: 1;
        }
        .hiw-desc {
            font-size: 0.88rem; color: var(--text-muted); line-height: 1.75;
            margin: 0 0 1.5rem; flex: 1;
            position: relative; z-index: 1;
        }
        .hiw-cta {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 0.82rem; font-weight: 700; color: var(--primary);
            text-decoration: none; transition: gap .2s, color .2s;
            position: relative; z-index: 1; margin-top: auto;
        }
        .hiw-cta:hover { color: var(--primary-dark); gap: 8px; }

        /* SVG wave connector between steps */
        .hiw-connector {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 6px; opacity: .75;
        }
        .hiw-connector svg { width: 100%; height: 24px; }
        .hiw-connector-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--primary); opacity: .5;
            box-shadow: 0 0 8px var(--primary-glow-soft);
        }

        /* ── BENEFIT TILES — per-card accent colors ── */
        .tiles-item-inner--citizen::before  { background: linear-gradient(90deg, var(--primary), var(--primary-light)); }
        .tiles-item-inner--tracking::before { background: linear-gradient(90deg, #2563eb, #60a5fa); }
        .tiles-item-inner--transparency::before { background: linear-gradient(90deg, #059669, #34d399); }
        .tiles-item-inner--tracking .features-tiles-item-image {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            box-shadow: 0 6px 20px rgba(37,99,235,0.25) !important;
        }
        .tiles-item-inner--transparency .features-tiles-item-image {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            box-shadow: 0 6px 20px rgba(5,150,105,0.25) !important;
        }

        /* ── DASHBOARD / MAP ── */
        .dashboard {
            padding: 6rem 0 6.5rem;
            background: linear-gradient(180deg, #f5f7fb 0%, #eceef5 60%, #f5f7fb 100%);
            position: relative;
        }
        .dashboard::before {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background-image:
                radial-gradient(circle at 85% 20%, rgba(157,27,50,0.06) 0%, transparent 40%),
                radial-gradient(circle at 15% 80%, rgba(157,27,50,0.05) 0%, transparent 40%);
        }

        /* Stats row */
        .map-stats-row {
            display: grid; grid-template-columns: repeat(4,1fr); gap: 14px;
            margin-bottom: 20px;
        }
        .map-stat-card {
            background: var(--white); border: 1px solid var(--border);
            border-radius: var(--r-xl); padding: 18px 20px;
            display: flex; align-items: center; gap: 14px;
            box-shadow: var(--shadow-sm);
            position: relative; overflow: hidden;
            transition: transform .25s var(--ease-out), box-shadow .25s;
        }
        .map-stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            border-radius: var(--r-xl) var(--r-xl) 0 0;
        }
        .map-stat--total::before    { background: linear-gradient(90deg, #475569, #94a3b8); }
        .map-stat--resolved::before { background: linear-gradient(90deg, #059669, #34d399); }
        .map-stat--inprogress::before{ background: linear-gradient(90deg, #2563eb, #60a5fa); }
        .map-stat--pending::before  { background: linear-gradient(90deg, #d97706, #fbbf24); }
        .map-stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .map-stat-icon {
            width: 44px; height: 44px; border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .map-stat--total    .map-stat-icon { background: rgba(71,85,105,0.1);  color: #475569; }
        .map-stat--resolved .map-stat-icon { background: rgba(5,150,105,0.1);  color: #059669; }
        .map-stat--inprogress .map-stat-icon { background: rgba(37,99,235,0.1); color: #2563eb; }
        .map-stat--pending  .map-stat-icon { background: rgba(217,119,6,0.1);  color: #d97706; }
        .map-stat-body { min-width: 0; }
        .map-stat-num {
            display: block; font-size: 2rem; font-weight: 900;
            letter-spacing: -0.05em; line-height: 1; color: var(--text);
        }
        .map-stat--resolved  .map-stat-num { color: #059669; }
        .map-stat--inprogress .map-stat-num { color: #2563eb; }
        .map-stat--pending   .map-stat-num { color: #d97706; }
        .map-stat-label {
            display: block; font-size: 0.63rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.09em; color: var(--gray);
            margin-top: 3px;
        }

        /* Map frame */
        .map-frame {
            position: relative; border-radius: var(--r-2xl);
            box-shadow: var(--shadow-xl), 0 0 0 1px var(--border);
            overflow: hidden;
            background: #f0f4f8;
        }

        /* Controls bar above map */
        .map-controls-bar {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 10px;
            padding: 12px 20px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
        }
        .map-legend {
            display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
        }
        .map-legend-item {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.75rem; font-weight: 600; color: #475569;
        }
        .map-legend-dot {
            width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
        }
        .map-loc-btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff !important; border: none; cursor: pointer;
            font-size: 0.78rem; font-weight: 700; border-radius: var(--r-full);
            padding: 8px 18px; box-shadow: 0 4px 14px var(--primary-glow-soft);
            transition: transform .2s var(--ease-out), box-shadow .2s;
        }
        .map-loc-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px var(--primary-glow); }
        /* Right side group: folio search + location button */
        .map-controls-right {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        }
        .map-folio-wrap {
            display: flex; align-items: center; gap: 6px;
            background: var(--bg); border: 1.5px solid var(--border);
            border-radius: var(--r-full); padding: 4px 4px 4px 12px;
            transition: border-color .2s, box-shadow .2s;
        }
        .map-folio-wrap:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(157,27,50,0.1);
        }
        .map-folio-wrap svg { flex-shrink: 0; color: #94a3b8; }
        .map-folio-wrap input {
            border: none; outline: none; background: transparent;
            font-size: 0.78rem; font-weight: 500; color: var(--text);
            font-family: inherit; width: 155px;
        }
        .map-folio-wrap input::placeholder { color: #94a3b8; }
        .map-folio-wrap button {
            background: var(--primary); color: #fff; border: none;
            border-radius: var(--r-full); padding: 6px 14px;
            font-size: 0.75rem; font-weight: 700; cursor: pointer;
            font-family: inherit; transition: background .2s;
            white-space: nowrap;
        }
        .map-folio-wrap button:hover { background: var(--primary-dark); }

        /* Live badge */
        .map-live-badge {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.72rem; font-weight: 600; color: #475569;
            padding: 4px 10px 4px 8px;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: var(--r-full);
            transition: opacity .4s;
        }
        .map-live-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #10b981; flex-shrink: 0;
            box-shadow: 0 0 0 0 rgba(16,185,129,.5);
            animation: live-pulse 2s ease-out infinite;
        }
        @keyframes live-pulse {
            0%   { box-shadow: 0 0 0 0 rgba(16,185,129,.5); }
            70%  { box-shadow: 0 0 0 6px rgba(16,185,129,0); }
            100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
        }
        html.dark .map-live-badge { background: #052e16; border-color: #166534; color: #86efac; }

        /* Map canvas */
        .map-mockup {
            width: 100%; height: 500px;
            position: relative;
        }

        /* ── Marker pulse ring ── */
        .map-pulse {
            position: absolute;
            width: 16px; height: 16px;
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
        }
        .map-pulse::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 1.5px solid var(--pulse-color, #f59e0b);
            opacity: 0;
            animation: mp-ring 3s ease-out infinite;
        }
        @keyframes mp-ring {
            0%   { transform: scale(0.6); opacity: 0.55; }
            100% { transform: scale(2.4); opacity: 0; }
        }

        /* Pin details card */
        .pin-details-card {
            position: absolute; bottom: 16px; left: 16px;
            width: min(360px, calc(100% - 32px));
            background: rgba(255,255,255,0.97); backdrop-filter: blur(18px);
            padding: 16px 18px 18px; border-radius: var(--r-xl);
            box-shadow: var(--shadow-xl), 0 0 0 1px rgba(0,0,0,0.05);
            opacity: 0; transform: translateY(12px) scale(.98); pointer-events: none;
            transition: opacity .25s var(--ease-out), transform .25s var(--ease-out);
            z-index: 20;
        }
        .pin-details-card.is-active { opacity: 1; transform: translateY(0) scale(1); pointer-events: auto; }
        .pin-details-close {
            position: absolute; top: 10px; right: 12px;
            background: none; border: none; cursor: pointer;
            font-size: 1.1rem; color: #94a3b8; line-height: 1;
            padding: 2px 4px; transition: color .15s;
        }
        .pin-details-close:hover { color: var(--text); }
        .pin-details-card h6 { font-size: 0.88rem; font-weight: 800; color: var(--text); margin-bottom: 4px; padding-right: 20px; }
        .pin-meta { font-size: 0.75rem; color: var(--text-muted); margin: 4px 0 10px; }

        /* keep old stat-card classes working (used elsewhere) */
        .stats-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: 12px; }
        .stat-card {
            background: var(--white); padding: 18px 16px; border-radius: var(--r-lg);
            box-shadow: var(--shadow-sm); text-align: center; border: 1px solid var(--border);
            position: relative; overflow: hidden;
            transition: transform .25s var(--ease-out), box-shadow .25s;
        }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: var(--r-lg) var(--r-lg) 0 0; }
        .stat-card--total::before    { background: linear-gradient(90deg, #475569, #94a3b8); }
        .stat-card--resolved::before { background: linear-gradient(90deg, #059669, #34d399); }
        .stat-card--inprogress::before { background: linear-gradient(90deg, #2563eb, #60a5fa); }
        .stat-card--pending::before  { background: linear-gradient(90deg, #d97706, #fbbf24); }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-md); }
        .stat-value { font-size: 2.4rem; font-weight: 900; line-height: 1; margin-bottom: 6px; letter-spacing: -0.05em; color: var(--text); }
        .stat-label { font-size: 0.64rem; font-weight: 700; color: var(--gray); letter-spacing: 0.08em; text-transform: uppercase; }
        .text-color-success { color: var(--status-resolved) !important; }
        .text-color-primary  { color: var(--status-inprogress) !important; }
        .text-color-error    { color: var(--status-rejected) !important; }
        .text-color-pending  { color: var(--status-pending) !important; }

        /* ── STATUS PILLS ── */
        .status-pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 11px; border-radius: var(--r-full);
            font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
        }
        .status-pill.pill-pendiente,[data-status="pendiente"] { background: rgba(217,119,6,0.12); color: #92400e; }
        .status-pill.pill-pendiente::before,[data-status="pendiente"]::before { content:'●'; font-size:7px; color:#d97706; }
        .status-pill.pill-rechazado,[data-status="rechazado"] { background: rgba(220,38,38,0.1); color: #991b1b; }
        .status-pill.pill-rechazado::before,[data-status="rechazado"]::before { content:'●'; font-size:7px; color: #dc2626; }
        .status-pill.pill-resuelto,[data-status="resuelto"] { background: rgba(5,150,105,0.1); color: #065f46; }
        .status-pill.pill-resuelto::before,[data-status="resuelto"]::before { content:'●'; font-size:7px; color: #059669; }
        .status-pill.pill-en-proceso,[data-status="en proceso"] { background: rgba(37,99,235,0.1); color: #1e3a8a; }
        .status-pill.pill-en-proceso::before,[data-status="en proceso"]::before { content:'●'; font-size:7px; color: #2563eb; }
        .status-pill.pill-activo { background: rgba(37,99,235,0.1); color: #1e3a8a; }

        /* ── TABLE ── */
        .incidents-table-section {
            background: var(--white);
            background-image:
                radial-gradient(circle at 100% 100%, rgba(157,27,50,0.04) 0%, transparent 40%);
            padding: 6rem 0 6.5rem;
        }
        .incidents-table-section .section-header h2 { color: var(--text); }
        .incidents-table-wrap {
            overflow-x: auto; background: var(--white); border-radius: var(--r-2xl);
            box-shadow: var(--shadow-xl); border: 1px solid var(--border);
        }
        .incidents-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .incidents-table th, .incidents-table td { white-space: nowrap; vertical-align: middle; }
        .incidents-table thead tr {
            background: linear-gradient(135deg, #0c101a 0%, #161b26 100%) !important;
        }
        .incidents-table th {
            color: #8899b5; font-weight: 700; letter-spacing: 0.07em;
            padding: 18px 22px; text-transform: uppercase; font-size: 0.67rem;
            border-bottom: 1px solid rgba(157,27,50,0.4);
        }
        .incidents-table th:first-child { border-radius: var(--r-2xl) 0 0 0; }
        .incidents-table th:last-child  { border-radius: 0 var(--r-2xl) 0 0; }
        .incidents-table tbody tr { background: var(--white); transition: background .12s; }
        .incidents-table tbody tr:nth-child(even) { background: #f9fafb; }
        .incidents-table tbody tr:hover { background: #f0f4ff !important; }
        .incidents-table td {
            padding: 15px 22px; font-size: 0.855rem; color: #334155;
            border-bottom: 1px solid var(--border-light);
        }
        .incidents-table tbody tr:last-child td { border-bottom: none; }
        .incidents-table .status-pill { font-size: 0.63rem; padding: 4px 10px; }
        .incidents-table .button-sm {
            padding: 7px 15px; font-size: 0.75rem; border-radius: var(--r-full);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white; border: none; font-weight: 700; cursor: pointer;
            box-shadow: 0 2px 8px var(--primary-glow-soft);
            transition: transform .18s var(--ease-out), box-shadow .18s;
        }
        .incidents-table .button-sm:hover { transform: translateY(-2px); box-shadow: 0 6px 18px var(--primary-glow); }
        .incidents-table-wrap::-webkit-scrollbar { height: 6px; }
        .incidents-table-wrap::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        .incidents-table-wrap::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 99px; }

        .btn-my-location { display: none; } /* replaced by map-loc-btn */

        /* ── FINAL CTA ── */
        .final-cta {
            padding: 6rem 0;
            background: linear-gradient(155deg, #080a10 0%, #130208 30%, #1a0410 60%, #0e0a12 100%);
            position: relative; overflow: hidden;
        }
        .final-cta::before {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(ellipse 60% 70% at 10% 30%, rgba(157,27,50,0.38) 0%, transparent 55%),
                radial-gradient(ellipse 50% 60% at 90% 75%, rgba(120,15,35,0.25) 0%, transparent 55%),
                radial-gradient(ellipse 25% 30% at 55% 10%, rgba(200,40,70,0.12) 0%, transparent 50%);
        }
        /* Decorative circles */
        .final-cta::after {
            content: ''; position: absolute;
            width: 600px; height: 600px; border-radius: 50%;
            border: 1px solid rgba(157,27,50,0.15);
            top: 50%; left: -200px; transform: translateY(-50%);
            pointer-events: none;
        }
        .final-cta-card {
            position: relative; z-index: 1;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: var(--r-2xl); padding: 3.5rem 3rem;
            backdrop-filter: blur(16px) saturate(150%);
            text-align: center;
            box-shadow: var(--shadow-xl), inset 0 1px 0 rgba(255,255,255,0.08);
        }
        .final-cta-card h2 {
            font-family: 'Space Grotesk', 'Inter', system-ui, sans-serif;
            color: #fff; margin: 0 0 18px;
            font-size: clamp(1.6rem, 3vw, 2.5rem); letter-spacing: -0.03em; font-weight: 700;
            line-height: 1.2;
            background: linear-gradient(135deg, #fff 0%, #fca5a5 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .final-cta-card p { color: #8899ad; margin: 0 auto 2rem; max-width: 600px; font-size: 1.02rem; line-height: 1.75; }
        .final-cta-divider {
            width: 48px; height: 3px; margin: 0 auto 1.5rem;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: var(--r-full);
        }

        /* ── FOOTER ── */
        .site-footer {
            background: linear-gradient(155deg, #06080c 0%, #0d0e14 100%) !important;
            border-top: 1px solid rgba(157,27,50,0.3); padding: 3rem 0;
        }
        .site-footer, .site-footer .invert-color { color: #64748b !important; }
        .site-footer a { color: #64748b !important; text-decoration: none; transition: color .2s; }
        .site-footer a:hover { color: var(--white) !important; }
        .tab.is-active { border-bottom: 3px solid var(--primary); }

        /* ── ANIMATIONS ── */
        @keyframes fadeInUp { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:translateY(0); } }
        @keyframes pulse { 0%{box-shadow:0 0 0 0 rgba(157,27,50,0.45)} 70%{box-shadow:0 0 0 10px rgba(157,27,50,0)} 100%{box-shadow:0 0 0 0 rgba(157,27,50,0)} }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .header-ghost { display: none; }
            .dashboard-inner .split-wrap { flex-direction: column; gap: 32px; }
            .map-stats-row { grid-template-columns: repeat(2,1fr); }
            .map-controls-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
            .map-controls-right { width: 100%; flex-wrap: wrap; }
            .map-folio-wrap { flex: 1; min-width: 0; }
            .map-folio-wrap input { width: 100%; }
            .map-mockup { height: 360px; }
            .stats-grid { grid-template-columns: repeat(2,1fr); gap: 10px; }
            .quick-steps-grid { grid-template-columns: 1fr; }
            .quick-steps-grid::before { display: none; }
            .hiw-grid { grid-template-columns: 1fr; gap: 16px; }
            .hiw-connector { display: none; }
            .hero-stats-strip { flex-wrap: wrap; }
            .hero-stat { flex: 1 1 50%; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.07); }
            .hero-stat:nth-child(odd) { border-right: 1px solid rgba(255,255,255,0.07); }
            .hero-stat:last-child, .hero-stat:nth-last-child(2):nth-child(odd) { border-bottom: none; }
            .hero-trust-item { font-size: 0.72rem; padding: 6px 10px; }
            .hero-figure-badge { right: 10px; bottom: 10px; font-size: 0.7rem; }
            .hero-map-footer { flex-direction: column; align-items: flex-start; gap: 6px; }
            .hero-map-view-btn { margin-left: 0; }
            .hero-map-notif { display: none; }
            .final-cta-card { padding: 2rem 1.5rem; }
        }

        /* ── PARTICLE CANVAS ── */
        #hero-canvas {
            position: absolute; inset: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 0; opacity: .55;
        }
        html.dark #hero-canvas { opacity: .5; }

        /* ── HERO FOLIO QUICK-SEARCH ── */
        .hero-folio-bar { margin-top: 0; margin-bottom: 1.5rem; }
        .hero-folio-wrap {
            display: flex; align-items: center;
            background: rgba(255,255,255,0.9); backdrop-filter: blur(12px);
            border: 1.5px solid rgba(0,0,0,0.1); border-radius: var(--r-full);
            padding: 5px 5px 5px 14px;
            box-shadow: var(--shadow-md), 0 0 0 4px rgba(157,27,50,0.07);
            max-width: 380px;
            transition: border-color .2s, box-shadow .2s;
        }
        .hero-folio-wrap:focus-within {
            border-color: var(--primary);
            box-shadow: var(--shadow-md), 0 0 0 4px rgba(157,27,50,0.12);
        }
        .hero-folio-icon { flex-shrink: 0; color: #94a3b8; margin-right: 6px; }
        .hero-folio-input {
            flex: 1; border: none; outline: none; background: transparent;
            font-size: 0.85rem; font-weight: 500; color: #0d1117;
            font-family: inherit;
        }
        .hero-folio-input::placeholder { color: #94a3b8; }
        .hero-folio-btn {
            display: inline-flex; align-items: center; gap: 5px;
            background: var(--primary); color: #fff;
            border: none; border-radius: var(--r-full);
            padding: 9px 18px; font-size: 0.8rem; font-weight: 700;
            cursor: pointer; flex-shrink: 0; font-family: inherit;
            transition: background .2s, transform .15s;
        }
        .hero-folio-btn:hover { background: var(--primary-dark); transform: scale(1.03); }
        html.dark .hero-folio-wrap {
            background: rgba(22,27,36,0.9); border-color: rgba(255,255,255,0.1);
            box-shadow: var(--shadow-md), 0 0 0 4px rgba(157,27,50,0.1);
        }
        html.dark .hero-folio-wrap:focus-within { border-color: rgba(157,27,50,0.6); }
        html.dark .hero-folio-input { color: #dde3ed; }
        /* ── HERO BUTTON ICON ── */
        .hero-btn-icon {
            flex-shrink: 0; margin-right: 6px;
            transition: transform .25s var(--ease-bounce);
            vertical-align: middle;
        }
        .button-primary:hover .hero-btn-icon { transform: translateX(-2px) scale(1.15); }

        /* ── HERO MAP CARD ── */
        .hero-map-card {
            position: relative; border-radius: var(--r-2xl); overflow: visible;
        }
        /* Floating notification pill */
        .hero-map-notif {
            position: absolute; top: -16px; left: 20px; z-index: 10;
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.95); border: 1px solid rgba(0,0,0,0.08);
            backdrop-filter: blur(14px); border-radius: var(--r-lg);
            padding: 9px 14px; box-shadow: var(--shadow-lg);
            animation: notif-entrance .5s var(--ease-bounce) .8s both;
        }
        @keyframes notif-entrance {
            from { opacity:0; transform: translateY(-10px) scale(.92); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }
        .hero-map-notif-icon {
            width: 30px; height: 30px; border-radius: var(--r-md);
            background: var(--primary); display: flex; align-items: center;
            justify-content: center; flex-shrink: 0;
            box-shadow: 0 0 12px var(--primary-glow);
        }
        .hero-map-notif-title {
            font-size: 0.75rem; font-weight: 700; color: #0d1117; line-height: 1.2;
        }
        .hero-map-notif-sub {
            font-size: 0.68rem; font-weight: 500; color: #64748b; margin-top: 1px;
        }
        /* Map iframe wrapper */
        .hero-map-wrap {
            position: relative; border-radius: var(--r-xl); overflow: hidden;
            aspect-ratio: 4 / 3;
            box-shadow: var(--shadow-xl), 0 0 0 1px rgba(0,0,0,0.06);
        }
        .hero-map-iframe {
            width: 100%; height: 100%; border: 0; display: block;
            filter: saturate(0.9) brightness(1);
        }
        /* Interaction blocker — covers iframe, reveals CTA on hover */
        .hero-map-blocker {
            position: absolute; inset: 0; z-index: 3;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; text-decoration: none;
        }
        .hero-map-blocker-hint {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.92); color: var(--primary);
            font-size: 0.78rem; font-weight: 700; border-radius: var(--r-full);
            padding: 9px 18px; border: 1px solid rgba(157,27,50,0.2);
            box-shadow: var(--shadow-lg);
            opacity: 0; transform: translateY(6px) scale(0.95);
            transition: opacity .22s, transform .22s var(--ease-bounce);
            pointer-events: none;
        }
        .hero-map-blocker:hover .hero-map-blocker-hint {
            opacity: 1; transform: translateY(0) scale(1);
        }
        html.dark .hero-map-blocker-hint {
            background: rgba(6,8,12,0.88); color: #fca5a5;
            border-color: rgba(157,27,50,0.35);
        }
        /* subtle veil */
        .hero-map-tint {
            position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(
                to bottom,
                rgba(255,255,255,0.1) 0%,
                transparent 35%,
                transparent 65%,
                rgba(255,255,255,0.15) 100%
            );
        }
        /* Glassmorphism live footer bar */
        .hero-map-footer {
            display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
            background: rgba(255,255,255,0.85); backdrop-filter: blur(14px);
            border: 1px solid rgba(0,0,0,0.08); border-radius: var(--r-full);
            padding: 9px 18px; margin-top: 12px;
            font-size: 0.76rem; font-weight: 600; color: #475569;
        }
        .hero-map-live-dot {
            width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
            background: #34d399; box-shadow: 0 0 8px rgba(52,211,153,.65);
            animation: live-dot 2s ease-in-out infinite;
        }
        @keyframes live-dot {
            0%,100% { opacity:1; box-shadow: 0 0 8px rgba(52,211,153,.65); }
            50%      { opacity:.5; box-shadow: 0 0 3px rgba(52,211,153,.3); }
        }
        .hero-map-live-text strong { color: #0d1117; }
        .hero-map-view-btn {
            display: inline-flex; align-items: center; gap: 3px;
            margin-left: auto; color: var(--primary) !important; font-weight: 700;
            text-decoration: none; font-size: 0.74rem; white-space: nowrap;
            transition: color .2s, gap .2s;
        }
        .hero-map-view-btn:hover { color: var(--primary-dark) !important; gap: 6px; }
        /* Dark mode: restore original dark map card styles */
        html.dark .hero-map-notif {
            background: rgba(6,8,12,0.88); border-color: rgba(255,255,255,0.13);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(157,27,50,0.3);
        }
        html.dark .hero-map-notif-title { color: #fff; }
        html.dark .hero-map-wrap { box-shadow: var(--shadow-xl), 0 0 0 1px rgba(255,255,255,0.09); }
        html.dark .hero-map-iframe { filter: saturate(0.8) brightness(0.92); }
        html.dark .hero-map-tint {
            background: linear-gradient(
                to bottom, rgba(6,8,12,0.22) 0%, transparent 35%,
                transparent 65%, rgba(6,8,12,0.35) 100%
            );
        }
        html.dark .hero-map-footer {
            background: rgba(6,8,12,0.78); border-color: rgba(255,255,255,0.1); color: #94a3b8;
        }
        html.dark .hero-map-live-text strong { color: #fff; }
        html.dark .hero-map-view-btn         { color: #fca5a5 !important; }
        html.dark .hero-map-view-btn:hover   { color: #fff !important; }

        /* ── DARK MODE TOGGLE BUTTON ── */
        .dark-toggle {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.12);
            cursor: pointer; color: #334155; flex-shrink: 0;
            transition: background .2s, transform .35s var(--ease-bounce), border-color .2s;
            position: relative;
        }
        .dark-toggle:hover { background: rgba(0,0,0,0.1); transform: rotate(22deg); }
        /* Dark mode: restore white glass look */
        html.dark .dark-toggle {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.18);
            color: #fff;
        }
        html.dark .dark-toggle:hover { background: rgba(255,255,255,0.2); }
        .dark-toggle .icon-sun,
        .dark-toggle .icon-moon { position: absolute; transition: opacity .25s, transform .3s; }
        html:not(.dark) .dark-toggle .icon-sun  { opacity: 0; transform: rotate(-80deg) scale(.5); pointer-events: none; }
        html:not(.dark) .dark-toggle .icon-moon { opacity: 1; transform: none; }
        html.dark       .dark-toggle .icon-moon { opacity: 0; transform: rotate(80deg) scale(.5); pointer-events: none; }
        html.dark       .dark-toggle .icon-sun  { opacity: 1; transform: none; }

        /* ── DARK MODE — VARIABLE OVERRIDES ── */
        html.dark {
            --bg:           #0d1117;
            --bg-alt:       #0a0d13;
            --bg-card:      #161b24;
            --white:        #161b24;
            --border:       rgba(255,255,255,0.08);
            --border-light: rgba(255,255,255,0.05);
            --text:         #dde3ed;
            --text-muted:   #7a8aa0;
            --gray:         #7a8aa0;
            --gray-light:   #566270;
            --gray-muted:   #2b3340;
        }
        html.dark body { background: var(--bg); color: var(--text); }
        html.dark ::-webkit-scrollbar-track { background: #161b24; }
        html.dark ::-webkit-scrollbar-thumb { background: #3a4455; }

        /* sections with hardcoded light backgrounds */
        html.dark .features-tiles    { background: #0d1117; background-image: none; }
        html.dark .how-it-works      { background: #0d1117; }
        html.dark .dashboard         { background: linear-gradient(180deg, #0a0d13 0%, #0d1117 60%, #0a0d13 100%); }
        html.dark .incidents-table-section { background: #0d1117; background-image: none; }

        /* cards */
        html.dark .features-tiles .tiles-item-inner,
        html.dark .hiw-step,
        html.dark .map-stat-card,
        html.dark .stat-card { background: #1e2532; border-color: rgba(255,255,255,0.07); }

        /* table */
        html.dark .incidents-table-wrap { background: #1e2532; border-color: rgba(255,255,255,0.07); }
        html.dark .incidents-table tbody tr             { background: #1e2532; }
        html.dark .incidents-table tbody tr:nth-child(even) { background: #192030; }
        html.dark .incidents-table tbody tr:hover       { background: #263040 !important; }
        html.dark .incidents-table td                   { color: #a0b4c8; border-bottom-color: rgba(255,255,255,0.05); }
        html.dark .incidents-table-wrap::-webkit-scrollbar-thumb { background: #3a4455; }
        html.dark .incidents-table-wrap::-webkit-scrollbar-track { background: #1e2532; }

        /* map */
        html.dark .map-frame        { background: #192030; }
        html.dark .map-controls-bar { background: #1e2532; border-bottom-color: rgba(255,255,255,0.07); }
        html.dark .map-legend-item  { color: #8899b5; }
        html.dark .pin-details-card { background: rgba(20,26,38,0.97); border: 1px solid rgba(255,255,255,0.1); }
        html.dark .pin-details-card h6 { color: var(--text); }

        /* status pills */
        html.dark .status-pill.pill-pendiente,
        html.dark [data-status="pendiente"] { background: rgba(217,119,6,0.2);  color: #fbbf24; }
        html.dark .status-pill.pill-rechazado,
        html.dark [data-status="rechazado"] { background: rgba(220,38,38,0.2);  color: #f87171; }
        html.dark .status-pill.pill-resuelto,
        html.dark [data-status="resuelto"]  { background: rgba(5,150,105,0.2);  color: #34d399; }
        html.dark .status-pill.pill-en-proceso,
        html.dark [data-status="en proceso"]{ background: rgba(37,99,235,0.2);  color: #60a5fa; }

        /* dividers */
        html.dark .has-top-divider::before,
        html.dark .has-bottom-divider::after { background: rgba(255,255,255,0.07) !important; }

        /* section headers */
        html.dark .section-header h2 { color: var(--text); }
        html.dark .section-header p  { color: var(--text-muted); }

        /* modals */
        html.dark .modal-custom-inner,
        html.dark .modal-custom-body  { background: #1a1e29; }
        html.dark .form-input-custom  { background: #232b3a; border-color: rgba(255,255,255,0.1); color: var(--text); }
        html.dark .form-input-custom:focus { background: #2a3547; border-color: var(--primary); }
        html.dark .mf-file-drop       { background: #232b3a; border-color: rgba(255,255,255,0.1); color: #8899b5; }
        html.dark .btn-geo            { background: #2a3547; border-color: rgba(255,255,255,0.1); color: #8899b5; }
        html.dark .status-result-card { background: #1e2532; border-color: rgba(255,255,255,0.07); }
        html.dark .modal-folio-badge  { background: #1a2030; border-color: rgba(255,255,255,0.1); color: var(--text); }
        html.dark .form-label-custom  { color: #a0b0c0; }
        html.dark .status-result-type { color: var(--text); }
        html.dark .status-result-update { color: #a0b0c0; }
        html.dark .modal-success-title  { color: var(--text); }
        html.dark .optional-tag         { background: #2a3547; color: #7a8aa0; }
        html.dark .modal-success-btn    { background: #2a3547; color: #a0b0c0; }
        html.dark .modal-success-btn:hover { background: #334155; color: var(--text); }
        html.dark .consult-back-btn     { color: #7a8aa0; }
    </style>
</head>
