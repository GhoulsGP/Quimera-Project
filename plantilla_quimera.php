<?php
// ARCHIVO: plantilla_quimera.php (v8.2 - Corrección de Regresión y Sincronización)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quimera</title> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --font-main: 'Inter', -apple-system, sans-serif;
            --radius-xl: 32px; --radius-lg: 24px; --radius-md: 16px; --radius-sm: 12px;
            --nav-width: 280px; --nav-width-collapsed: 90px;
            --transition-fast: 0.2s; --transition-medium: 0.4s;
            --blur-heavy: 32px; --blur-light: 16px;
            --c-accent-h: 260; --c-accent-s: 80%; --c-accent-l: 70%;
        }
        body, body.theme-aurora {
            --c-bg: #0D1117; --c-text: #E6EDF3; --c-text-secondary: #8B949E; --c-text-tertiary: #484F58;
            --c-accent: hsl(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l)); 
            --c-accent-text: #FFFFFF; --c-glass-bg: hsla(215, 25%, 15%, 0.5);
            --c-glass-border: hsla(215, 25%, 100%, 0.1);
            --aurora-opacity: 1;
        }
        body.theme-dark {
            --c-bg: #000000; --c-text: #EAEAEA; --c-text-secondary: #999999;
            --c-accent: #FFFFFF; --c-accent-text: #000000; --c-glass-bg: rgba(22, 22, 22, 0.6);
            --c-glass-border: rgba(255, 255, 255, 0.12); --aurora-opacity: 0;
        }
        body.theme-light {
            --c-bg: #F0F2F5; --c-text: #050505; --c-text-secondary: #65676B;
            --c-accent: #1877F2; --c-accent-text: #FFFFFF; --c-glass-bg: rgba(255, 255, 255, 0.7);
            --c-glass-border: rgba(0, 0, 0, 0.08); --aurora-opacity: 0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-main); background-color: var(--c-bg); color: var(--c-text); transition: background-color var(--transition-medium) ease, color var(--transition-medium) ease; overflow-x: hidden; }
        .mobile-toggle { display: none; }
        #particle-canvas { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none; }
        #aurora-background { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; transition: opacity var(--transition-medium) ease; opacity: var(--aurora-opacity); }
        .aurora-blob { position: absolute; border-radius: 50%; filter: blur(150px); will-change: transform; transition: background 1s ease; }
        .aurora-blob:nth-child(1) { width: 40vmax; height: 40vmax; background: hsla(var(--c-accent-h), 80%, 70%, 0.3); top: -10%; left: -15%; animation: move-blob-1 35s ease-in-out infinite alternate; }
        .aurora-blob:nth-child(2) { width: 50vmax; height: 50vmax; background: hsla(calc(var(--c-accent-h) + 60), 80%, 60%, 0.3); bottom: -20%; right: -10%; animation: move-blob-2 40s ease-in-out infinite alternate; }
        @keyframes move-blob-1 { to { transform: translate(15vw, 10vh) scale(1.3); } }
        @keyframes move-blob-2 { to { transform: translate(-10vw, -15vh) scale(0.8); } }
        .layout-wrapper { display: flex; }
        main.content-area { width: 100%; min-width: 0; padding: 32px; padding-left: calc(var(--nav-width-collapsed) + 32px); transition: padding-left var(--transition-medium) ease; }
        body.nav-expanded main.content-area { padding-left: calc(var(--nav-width) + 32px); }
        #main-nav { position: fixed; top: 16px; left: 16px; height: calc(100vh - 32px); width: var(--nav-width-collapsed); background: var(--c-glass-bg); backdrop-filter: blur(var(--blur-heavy)); border: 1px solid var(--c-glass-border); border-radius: var(--radius-xl); padding: 24px 0; display: flex; flex-direction: column; align-items: center; z-index: 1000; transition: width var(--transition-medium) ease, background var(--transition-medium) ease; }
        body.nav-expanded #main-nav { width: var(--nav-width); }
        #main-nav ul { list-style: none; width: 100%; padding: 0;}
        .nav-link { display: flex; align-items: center; justify-content: center; width: 100%; height: 56px; color: var(--c-text-secondary); text-decoration: none; font-weight: 600; font-size: 1rem; position: relative; padding: 0; }
        body.nav-expanded .nav-link { justify-content: flex-start; padding: 0 32px; }
        .nav-link svg { width: 24px; height: 24px; stroke: var(--c-text-secondary); flex-shrink: 0; transition: stroke var(--transition-fast) ease; }
        .nav-link-text { position: absolute; left: 72px; opacity: 0; transform: translateX(-10px); transition: opacity var(--transition-medium) ease, transform var(--transition-medium) ease; pointer-events: none; }
        body.nav-expanded .nav-link-text { position: static; opacity: 1; transform: translateX(0); pointer-events: auto; margin-left: 20px; }
        .nav-link.active, .nav-link:hover { color: var(--c-text); }
        .nav-link.active svg, .nav-link:hover svg { stroke: var(--c-accent); }
        #nav-header { text-align: center; padding-bottom: 24px; width: 100%; }
        #nav-logo { font-weight: 800; font-size: 1.5rem; text-decoration: none; color: var(--c-text); }
        .logo-full { display: none; }
        .logo-icon { display: block; }
        body.nav-expanded .logo-full { display: inline; }
        body.nav-expanded .logo-icon { display: none; }
        #nav-footer { margin-top: auto; width: 100%; display: flex; flex-direction: column; align-items: center; }
        body.nav-expanded #nav-footer { align-items: stretch; }
        .desktop-toggle { background: none; border: none; cursor: pointer; }
        #theme-switcher { display: flex; flex-direction: column; align-items: center; gap: 12px; height: auto; padding: 12px 0; }
        body.nav-expanded #theme-switcher { align-items: flex-start; padding: 12px 32px; }
        .theme-button { width: 24px; height: 24px; border-radius: 50%; cursor: pointer; border: 2px solid var(--c-text-tertiary); transition: all var(--transition-fast); flex-shrink: 0; }
        .theme-button:hover { transform: scale(1.15); }
        .theme-button.active { border-color: var(--c-accent); }
        #btn-aurora { background: linear-gradient(45deg, hsl(210, 80%, 50%), hsl(260, 80%, 60%)); }
        #btn-dark { background: #000; }
        #btn-light { background: #fff; }
        .search-palette { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; display: none; align-items: center; justify-content: center; }
        .search-palette.open { display: flex; }
        .search-backdrop { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: hsla(215, 25%, 5%, 0.5); backdrop-filter: blur(12px); }
        .search-container { position: relative; width: 100%; max-width: 600px; background: var(--c-glass-bg); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); box-shadow: 0 16px 40px hsla(0, 0%, 0%, 0.3); }
        .search-input-wrapper { display: flex; align-items: center; padding: 12px 24px; border-bottom: 1px solid var(--c-glass-border); }
        .search-input-wrapper svg { width: 24px; height: 24px; stroke: var(--c-text-secondary); margin-right: 16px; }
        #search-input-field { width: 100%; background: transparent; border: none; outline: none; color: var(--c-text); font-size: 1.2rem; font-weight: 500; font-family: var(--font-main); }
        #search-input-field::placeholder { color: var(--c-text-secondary); }
        #search-results-list { list-style: none; padding: 12px; margin: 0; max-height: 40vh; overflow-y: auto; }
        .search-result-item { display: flex; align-items: center; gap: 16px; padding: 12px; border-radius: var(--radius-md); cursor: pointer; transition: background-color 0.2s ease; opacity: 0; animation: result-fade-in 0.5s ease forwards; }
        @keyframes result-fade-in { to { opacity: 1; transform: translateY(0); } }
        .search-result-item:hover { background: hsla(0, 0%, 100%, 0.05); }
        .result-avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
        .result-info { display: flex; flex-direction: column; }
        .result-name { font-weight: 600; color: var(--c-text); }
        .result-handle { color: var(--c-text-secondary); font-size: 0.9em; }
        #notifications-trigger { position: relative; }
        #notifications-trigger.has-new .pulse-indicator { display: block; }
        .pulse-indicator { display: none; position: absolute; top: 15px; left: calc(50% + 10px); width: 8px; height: 8px; background-color: var(--c-accent); border-radius: 50%; box-shadow: 0 0 0 0 hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.5); animation: pulse-animation 2s infinite; transition: left var(--transition-medium) ease, top var(--transition-medium) ease; }
        body.nav-expanded .pulse-indicator { left: 55px; }
        @keyframes pulse-animation { 0% { transform: scale(0.95); box-shadow: 0 0 0 0 hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.7); } 70% { transform: scale(1); box-shadow: 0 0 0 10px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0); } 100% { transform: scale(0.95); box-shadow: 0 0 0 0 hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0); } }
        .notifications-popover { position: absolute; top: 0; left: calc(var(--nav-width-collapsed) + 12px); width: 380px; backdrop-filter: blur(var(--blur-heavy)); background: hsla(215, 25%, 15%, 0.9); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); box-shadow: 0 16px 40px hsla(0, 0%, 0%, 0.3); z-index: 990; opacity: 0; transform-origin: left center; transform: scale(0.95); transition: all 0.2s ease; pointer-events: none; }
        body.nav-expanded .notifications-popover { left: calc(var(--nav-width) + 12px); }
        .notifications-popover.open { opacity: 1; transform: scale(1); pointer-events: auto; }
        .popover-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--c-glass-border); }
        .popover-header h3 { font-size: 1rem; font-weight: 600; }
        .popover-header a { font-size: 0.85rem; color: var(--c-accent); text-decoration: none; font-weight: 500; }
        .popover-content { list-style: none; padding: 8px; margin: 0; max-height: 400px; overflow-y: auto; }
        .notification-item { display: flex; gap: 12px; padding: 12px; border-radius: var(--radius-md); }
        .notification-item:not(:last-child) { border-bottom: 1px solid var(--c-glass-border); }
        .notification-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .notification-content { flex-grow: 1; font-size: 0.9rem; color: var(--c-text-secondary); line-height: 1.5; }
        .notification-content b { color: var(--c-text); font-weight: 600; }
        .notification-content .post-quote { display: block; border-left: 3px solid var(--c-accent); padding-left: 12px; margin-top: 8px; opacity: 0.8; }
        .notification-footer { display: flex; gap: 12px; margin-top: 8px; }
        .inline-action-button { background: hsla(var(--c-accent-h), var(--c-accent-s), 100%, 0.1); border: none; color: var(--c-text); padding: 6px 12px; border-radius: var(--radius-sm); cursor: pointer; font-size: 0.8rem; font-weight: 500; transition: background-color 0.2s ease; }
        .inline-action-button:hover { background: hsla(var(--c-accent-h), var(--c-accent-s), 100%, 0.2); }
        :root { --mc-bg: hsla(220, 20%, 10%, 0.7); --mc-border: hsla(220, 15%, 100%, 0.1); --mc-sidebar-bg: hsla(220, 20%, 5%, 0.3); --mc-hover-bg: hsla(220, 15%, 100%, 0.05); --mc-active-bg: hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.15); --mc-bubble-sent-bg: var(--c-accent); --mc-bubble-sent-text: var(--c-accent-text); --mc-bubble-received-bg: hsla(220, 15%, 100%, 0.1); --mc-bubble-received-text: var(--c-text); }
        #message-center { position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 5000; display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity var(--transition-fast) ease; pointer-events: none; }
        #message-center.open { opacity: 1; pointer-events: auto;}
        #message-center.open .mc-panel { transform: scale(1); }
        .mc-backdrop { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: hsla(215, 25%, 5%, 0.5); backdrop-filter: blur(var(--blur-light)); }
        .mc-panel { position: relative; width: 90%; height: 90%; max-width: 1400px; max-height: 900px; background: var(--mc-bg); border: 1px solid var(--mc-border); border-radius: var(--radius-xl); box-shadow: 0 24px 60px hsla(0, 0%, 0%, 0.4); display: grid; grid-template-columns: 320px 1fr; overflow: hidden; transform: scale(0.97); transition: transform var(--transition-medium) cubic-bezier(0.16, 1, 0.3, 1); }
        .mc-sidebar { background: var(--mc-sidebar-bg); display: flex; flex-direction: column; border-right: 1px solid var(--mc-border); }
        .mc-sidebar-header { padding: 24px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .mc-sidebar-header h2 { font-size: 1.5rem; font-weight: 700; }
        .mc-new-message-btn { background: transparent; border: none; color: var(--c-text); cursor: pointer; padding: 4px; }
        .mc-new-message-btn svg { width: 24px; height: 24px; stroke: var(--c-text-secondary); transition: stroke var(--transition-fast); }
        .mc-new-message-btn:hover svg { stroke: var(--c-text); }
        .mc-search-wrapper { padding: 0 24px 16px; flex-shrink: 0; }
        .mc-search-input { width: 100%; background: hsla(0,0%,100%,0.05); border: 1px solid transparent; border-radius: var(--radius-sm); padding: 10px 16px; color: var(--c-text); outline: none; transition: all var(--transition-fast) ease; }
        .mc-search-input:focus { border-color: var(--c-accent); background: transparent; }
        .mc-conversation-list { flex-grow: 1; list-style: none; overflow-y: auto; }
        .mc-conversation-item { display: flex; align-items: center; gap: 16px; padding: 16px 24px; cursor: pointer; border-top: 1px solid var(--mc-border); }
        .mc-conversation-item:first-child { border-top: none; }
        .mc-conversation-item:hover { background: var(--mc-hover-bg); }
        .mc-conversation-item.active { background: var(--mc-active-bg); }
        .mc-conversation-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
        .mc-conversation-details { flex-grow: 1; min-width: 0; }
        .mc-conversation-name { font-weight: 600; color: var(--c-text); }
        .mc-conversation-excerpt { font-size: 0.9rem; color: var(--c-text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .mc-conversation-meta { text-align: right; flex-shrink: 0; }
        .mc-conversation-time { font-size: 0.8rem; color: var(--c-text-secondary); }
        .mc-unread-badge { display: block; background: var(--c-accent); color: var(--c-accent-text); font-size: 0.75rem; font-weight: 600; padding: 2px 6px; border-radius: 99px; margin-top: 8px; }
        .mc-chat-panel { display: flex; flex-direction: column; }
        .mc-chat-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid var(--mc-border); flex-shrink: 0; }
        .mc-user-info { display: flex; align-items: center; gap: 16px; }
        .mc-user-avatar { width: 40px; height: 40px; border-radius: 50%; }
        .mc-user-name { font-weight: 600; }
        .mc-user-status { font-size: 0.85rem; color: var(--c-text-secondary); }
        .mc-user-status.online { color: var(--c-accent); }
        .mc-chat-actions button { background: transparent; border: none; color: var(--c-text-secondary); cursor: pointer; padding: 4px; }
        .mc-chat-actions button:hover { color: var(--c-text); }
        .mc-chat-actions svg { width: 22px; height: 22px; }
        .mc-message-history { flex-grow: 1; padding: 24px; overflow-y: auto; display: flex; flex-direction: column; gap: 16px; }
        .mc-message { display: flex; max-width: 70%; }
        .mc-message.sent { align-self: flex-end; }
        .mc-message.received { align-self: flex-start; }
        .mc-message-bubble { padding: 12px 16px; border-radius: var(--radius-lg); line-height: 1.6; }
        .mc-message.sent .mc-message-bubble { background: var(--mc-bubble-sent-bg); color: var(--mc-bubble-sent-text); border-bottom-right-radius: var(--radius-sm); }
        .mc-message.received .mc-message-bubble { background: var(--mc-bubble-received-bg); color: var(--mc-bubble-received-text); border-bottom-left-radius: var(--radius-sm); }
        .mc-input-form { display: flex; gap: 16px; padding: 24px; border-top: 1px solid var(--mc-border); flex-shrink: 0; }
        .mc-message-input { flex-grow: 1; background: hsla(0,0%,100%,0.1); border: 1px solid transparent; border-radius: var(--radius-md); padding: 14px 20px; color: var(--c-text); font-size: 1rem; outline: none; transition: all var(--transition-fast) ease; }
        .mc-message-input:focus { border-color: var(--c-accent); box-shadow: 0 0 0 4px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.2); }
        .mc-send-button { width: 50px; height: 50px; background: var(--c-accent); border: none; border-radius: 50%; color: var(--c-accent-text); cursor: pointer; flex-shrink: 0; display: flex; align-items: center; justify-content: center; transition: all var(--transition-fast) ease; }
        .mc-send-button:hover { transform: scale(1.05); box-shadow: 0 4px 15px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.3); }
        .mc-send-button svg { width: 20px; height: 20px; }
        @media (max-width: 768px) {
            html { font-size: 14px; }
            .desktop-toggle { display: none; }
            .mobile-toggle { display: flex; align-items: center; justify-content: center; position: fixed; top: 10px; left: 10px; width: 50px; height: 50px; z-index: 2001; background: var(--c-glass-bg); backdrop-filter: blur(8px); border: 1px solid var(--c-glass-border); border-radius: 50%; color: var(--c-text); text-decoration: none; }
            .mobile-toggle svg { width: 24px; height: 24px; stroke: currentColor; }
            main.content-area { padding: 16px; padding-left: 16px; transition: filter var(--transition-medium) ease; }
            body.nav-expanded main.content-area { filter: brightness(0.6); pointer-events: none; }
            #main-nav { position: fixed; top: 0; left: 0; height: 100vh; border-radius: 0; transform: translateX(-100%); transition: transform var(--transition-medium) ease, width var(--transition-medium) ease; z-index: 2000; border-right: 1px solid var(--c-glass-border); box-shadow: 5px 0 25px rgba(0,0,0,0.2); }
            body.nav-expanded #main-nav { transform: translateX(0); }
            .notifications-popover { display: none; } 
        }
    </style>
</head>
<body class="theme-aurora">
    <a href="#" class="mobile-toggle" data-action="toggle-nav" title="Abrir Menú">
        <svg fill="none" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </a>
    <canvas id="particle-canvas"></canvas>
    <div id="aurora-background">
        <div class="aurora-blob"></div>
        <div class="aurora-blob"></div>
    </div>
    <div class="layout-wrapper">
        <nav id="main-nav">
            <div id="nav-header"><a href="inicio.php" id="nav-logo"><span class="logo-full">Quimera</span><span class="logo-icon">Q</span></a></div>
            <ul>
                <li><a href="inicio.php" class="nav-link"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path><path d="M9 22V12h6v10"></path></svg><span class="nav-link-text">Inicio</span></a></li>
                <li><a href="" class="nav-link" id="search-trigger"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 17.25a6.25 6.25 0 110-12.5 6.25 6.25 0 010 12.5z"></path><path d="M16 16l4.5 4.5"></path></svg><span class="nav-link-text">Buscar</span></a></li>
                <li><a href="" class="nav-link" id="notifications-trigger"><span class="pulse-indicator"></span><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 01-3.46 0"></path></svg><span class="nav-link-text">Notificaciones</span></a></li>
                <li><a href="" class="nav-link" id="messages-trigger"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h10a2 2 0 012 2v10z"></path></svg><span class="nav-link-text">Mensajes</span></a></li>
            </ul>
            <div id="nav-footer">
                <a href="/perfil.php" class="nav-link"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><path d="M12 11a4 4 0 100-8 4 4 0 000 8z"></path></svg><span class="nav-link-text">Perfil</span></a>
                <a href="#" id="sound-toggle" class="nav-link" title="Activar/Desactivar Sonido"><svg id="sound-on-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M15.54 8.46a5 5 0 010 7.07"></path></svg><svg id="sound-off-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display: none;"><path d="M11 5L6 9H2v6h4l5 4V5z"></path><path d="M23 9l-6 6"></path><path d="M17 9l6 6"></path></svg><span class="nav-link-text">Sonido</span></a>
                <div id="theme-switcher"><button class="theme-button active" id="btn-aurora" data-theme="theme-aurora" title="Tema Aurora"></button><button class="theme-button" id="btn-dark" data-theme="theme-dark" title="Tema Oscuro"></button><button class="theme-button" id="btn-light" data-theme="theme-light" title="Tema Claro"></button></div>
                <a href="#" data-action="toggle-nav" class="nav-link desktop-toggle" title="Expandir/Colapsar Menú"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg><span class="nav-link-text">Menú</span></a>
            </div>
            <div class="notifications-popover" id="notifications-popover">
                <div class="popover-header">
                    <h3>Notificaciones</h3>
                    <a href="#">Ver todas</a>
                </div>
                <ul class="popover-content" id="notifications-list">
                </ul>
            </div>
        </nav>
        <main class="content-area">