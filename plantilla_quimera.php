<?php
// ARCHIVO: plantilla_quimera.php (Estable v1.2)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trendly - Quimera</title> 
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* --- SISTEMA DE DISEÑO QUIMERA v1.2 (Estable) --- */
        :root {
            --font-main: 'Inter', -apple-system, sans-serif;
            --radius-xl: 32px; --radius-lg: 24px; --radius-md: 16px; --radius-sm: 12px;
            --nav-width: 280px; --nav-width-collapsed: 90px;
            --transition-fast: 0.2s; --transition-medium: 0.4s;
            --blur-heavy: 32px;
        }
        body, body.theme-aurora {
            --c-bg: #0D1117; --c-text: #E6EDF3; --c-text-secondary: #8B949E; --c-text-tertiary: #484F58;
            --c-accent: #8865E8; --c-accent-text: #FFFFFF; --c-glass-bg: hsla(215, 25%, 15%, 0.4);
            --c-glass-border: hsla(215, 25%, 100%, 0.1); --c-glass-border-hover: hsla(270, 80%, 70%, 0.6);
            --aurora-opacity: 1;
        }
        body.theme-dark {
            --c-bg: #000000; --c-text: #EAEAEA; --c-text-secondary: #999999; --c-text-tertiary: #444444;
            --c-accent: #FFFFFF; --c-accent-text: #000000; --c-glass-bg: rgba(22, 22, 22, 0.5);
            --c-glass-border: rgba(255, 255, 255, 0.12); --c-glass-border-hover: rgba(255, 255, 255, 0.4);
            --aurora-opacity: 0;
        }
        body.theme-light {
            --c-bg: #F0F2F5; --c-text: #050505; --c-text-secondary: #65676B; --c-text-tertiary: #CED0D4;
            --c-accent: #1877F2; --c-accent-text: #FFFFFF; --c-glass-bg: rgba(255, 255, 255, 0.7);
            --c-glass-border: rgba(0, 0, 0, 0.08); --c-glass-border-hover: rgba(0, 0, 0, 0.25);
            --aurora-opacity: 0;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-main); background-color: var(--c-bg); color: var(--c-text); transition: background-color var(--transition-medium) ease; }
        #aurora-background { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; transition: opacity var(--transition-medium) ease; opacity: var(--aurora-opacity); }
        .aurora-blob { position: absolute; border-radius: 50%; filter: blur(150px); will-change: transform; }
        .aurora-blob:nth-child(1) { width: 40vmax; height: 40vmax; background: hsla(260, 80%, 70%, 0.3); top: -10%; left: -15%; animation: move-blob-1 35s ease-in-out infinite alternate; }
        .aurora-blob:nth-child(2) { width: 50vmax; height: 50vmax; background: hsla(190, 80%, 60%, 0.3); bottom: -20%; right: -10%; animation: move-blob-2 40s ease-in-out infinite alternate; }
        @keyframes move-blob-1 { to { transform: translate(15vw, 10vh) scale(1.3); } }
        @keyframes move-blob-2 { to { transform: translate(-10vw, -15vh) scale(0.8); } }

        .layout-wrapper { display: flex; }
        main.content-area { width: 100%; padding: 32px; margin-left: var(--nav-width-collapsed); transition: margin-left var(--transition-medium) ease; }
        body.nav-expanded main.content-area { margin-left: var(--nav-width); }

        #main-nav {
            position: fixed; top: 16px; left: 16px; height: calc(100vh - 32px);
            width: var(--nav-width-collapsed);
            background: var(--c-glass-bg); backdrop-filter: blur(var(--blur-heavy));
            border: 1px solid var(--c-glass-border); border-radius: var(--radius-xl);
            padding: 24px 0;
            display: flex; flex-direction: column; align-items: center;
            z-index: 100;
            transition: width var(--transition-medium) ease, background var(--transition-medium) ease;
        }
        body.nav-expanded #main-nav { width: var(--nav-width); }
        #main-nav ul { list-style: none; width: 100%; }
        .nav-link {
            display: flex; align-items: center; justify-content: center;
            width: 100%; height: 56px; color: var(--c-text-secondary); text-decoration: none;
            font-weight: 600; font-size: 1rem; position: relative; padding: 0;
        }
        body.nav-expanded .nav-link { justify-content: flex-start; padding: 0 32px; }
        .nav-link svg { width: 24px; height: 24px; stroke: var(--c-text-secondary); flex-shrink: 0; transition: stroke var(--transition-fast) ease; }
        .nav-link-text {
            position: absolute; left: 72px; opacity: 0; transform: translateX(-10px);
            transition: opacity var(--transition-medium) ease, transform var(--transition-medium) ease; pointer-events: none;
        }
        body.nav-expanded .nav-link-text { position: static; opacity: 1; transform: translateX(0); pointer-events: auto; margin-left: 20px; }
        .nav-link.active, .nav-link:hover { color: var(--c-text); }
        .nav-link.active svg, .nav-link:hover svg { stroke: var(--c-accent); }
        .nav-link::before {
            content: ''; position: absolute; left: 0; top: 50%;
            transform: translateY(-50%); width: 4px; height: 0%;
            background-color: var(--c-accent); border-radius: 99px;
            transition: height var(--transition-medium) ease; display: none;
        }
        body.nav-expanded .nav-link::before { display: block; left: 10px; }
        .nav-link.active::before { height: 60%; }
        .nav-link:hover:not(.active)::before { height: 30%; }
        #nav-header { text-align: center; padding-bottom: 24px; width: 100%; }
        #nav-logo { font-weight: 800; font-size: 1.5rem; text-decoration: none; color: var(--c-text); }
        .logo-full { display: none; }
        .logo-icon { display: block; }
        body.nav-expanded .logo-full { display: inline; }
        body.nav-expanded .logo-icon { display: none; }
        #nav-footer { margin-top: auto; width: 100%; display: flex; flex-direction: column; align-items: center; }
        body.nav-expanded #nav-footer { align-items: stretch; }
        #nav-toggle { background: none; border: none; cursor: pointer; }
        #theme-switcher { display: flex; justify-content: center; gap: 8px; height: 56px; align-items: center; }
        body.nav-expanded #theme-switcher { justify-content: flex-start; padding: 0 32px; }
        .theme-button { width: 24px; height: 24px; border-radius: 50%; cursor: pointer; border: 2px solid var(--c-text-tertiary); transition: all var(--transition-fast); }
        .theme-button:hover { transform: scale(1.15); }
        .theme-button.active { border-color: var(--c-accent); }
        #btn-aurora { background: linear-gradient(45deg, hsl(210, 80%, 50%), hsl(260, 80%, 60%)); }
        #btn-dark { background: #000; }
        #btn-light { background: #fff; }
    </style>
</head>
<body class="theme-aurora">
    <div id="aurora-background">
        <div class="aurora-blob"></div>
        <div class="aurora-blob"></div>
    </div>
    <div class="layout-wrapper">
        <nav id="main-nav">
            <div id="nav-header">
                <a href="/inicio.php" id="nav-logo">
                    <span class="logo-full">Trendly</span>
                    <span class="logo-icon">T</span>
                </a>
            </div>
            <ul>
                <li><a href="#" class="nav-link active">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path><path d="M9 22V12h6v10"></path></svg>
                    <span class="nav-link-text">Inicio</span>
                </a></li>
                <li><a href="#" class="nav-link">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 17.25a6.25 6.25 0 110-12.5 6.25 6.25 0 010 12.5z"></path><path d="M16 16l4.5 4.5"></path></svg>
                    <span class="nav-link-text">Explorar</span>
                </a></li>
                <li><a href="#" class="nav-link">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 01-3.46 0"></path></svg>
                    <span class="nav-link-text">Notificaciones</span>
                </a></li>
                <li><a href="#" class="nav-link">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h10a2 2 0 012 2v10z"></path></svg>
                    <span class="nav-link-text">Mensajes</span>
                </a></li>
            </ul>
            <div id="nav-footer">
                <a href="/perfil.php" class="nav-link">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><path d="M12 11a4 4 0 100-8 4 4 0 000 8z"></path></svg>
                    <span class="nav-link-text">Perfil</span>
                </a>
                <div id="theme-switcher">
                    <button class="theme-button active" id="btn-aurora" data-theme="theme-aurora" title="Tema Aurora"></button>
                    <button class="theme-button" id="btn-dark" data-theme="theme-dark" title="Tema Oscuro"></button>
                    <button class="theme-button" id="btn-light" data-theme="theme-light" title="Tema Claro"></button>
                </div>
                <a href="#" id="nav-toggle" class="nav-link" title="Expandir/Colapsar Menú">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <span class="nav-link-text">Menú</span>
                </a>
            </div>
        </nav>
        <main class="content-area">