<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Trendly - Proyecto Quimera</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ---
        SISTEMA DE DISEÑO QUIMERA v1.0
        PÁGINA: Index (Login / Registro)
        --- */

        /* 1. VARIABLES GLOBALES Y SISTEMA DE TEMAS */
        :root {
            --font-main: 'Inter', -apple-system, sans-serif;
            --radius-lg: 24px;
            --radius-md: 12px;
            --transition-fast: 0.2s;
            --transition-medium: 0.4s;
            --blur-strength: 16px;
        }
        
        /* Tema por defecto: Aurora */
        body, body.theme-aurora {
            --c-bg: #0D1117;
            --c-text: #E6EDF3;
            --c-text-secondary: #8B949E;
            --c-accent: #8865E8;
            --c-accent-text: #FFFFFF;
            --c-glass-bg: hsla(215, 25%, 15%, 0.4);
            --c-glass-border: hsla(215, 25%, 100%, 0.1);
            --c-input-bg: hsla(215, 25%, 100%, 0.05);
            --c-input-border: hsla(215, 25%, 100%, 0.1);
            --c-input-border-focus: var(--c-accent);
            --aurora-opacity: 1;
        }
        body.theme-dark {
            --c-bg: #000000;
            --c-text: #EAEAEA;
            --c-text-secondary: #999999;
            --c-accent: #FFFFFF;
            --c-accent-text: #000000;
            --c-glass-bg: rgba(22, 22, 22, 0.5);
            --c-glass-border: rgba(255, 255, 255, 0.12);
            --c-input-bg: rgba(255, 255, 255, 0.08);
            --c-input-border: rgba(255, 255, 255, 0.15);
            --c-input-border-focus: var(--c-accent);
            --aurora-opacity: 0;
        }
        body.theme-light {
            --c-bg: #F0F2F5;
            --c-text: #050505;
            --c-text-secondary: #65676B;
            --c-accent: #1877F2;
            --c-accent-text: #FFFFFF;
            --c-glass-bg: rgba(255, 255, 255, 0.7);
            --c-glass-border: rgba(0, 0, 0, 0.08);
            --c-input-bg: rgba(0, 0, 0, 0.04);
            --c-input-border: transparent;
            --c-input-border-focus: var(--c-accent);
            --aurora-opacity: 0;
        }

        /* 2. ESTILOS BASE Y FONDO ANIMADO */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { height: 100%; }
        body {
            font-family: var(--font-main);
            background-color: var(--c-bg);
            color: var(--c-text);
            transition: background-color var(--transition-medium) ease;
            overflow: hidden; /* Evita scroll en la página de login */
        }
        #aurora-background {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2;
            transition: opacity var(--transition-medium) ease;
            opacity: var(--aurora-opacity);
        }
        .aurora-blob {
            position: absolute; border-radius: 50%; filter: blur(120px); will-change: transform;
        }
        .aurora-blob:nth-child(1) { width: 50vmax; height: 50vmax; background: hsla(260, 80%, 70%, 0.3); top: -20%; left: -25%; animation: move-blob-1 35s ease-in-out infinite alternate; }
        .aurora-blob:nth-child(2) { width: 60vmax; height: 60vmax; background: hsla(190, 80%, 60%, 0.3); bottom: -30%; right: -20%; animation: move-blob-2 40s ease-in-out infinite alternate; }
        @keyframes move-blob-1 { to { transform: translate(15vw, 10vh) scale(1.3); } }
        @keyframes move-blob-2 { to { transform: translate(-10vw, -15vh) scale(0.8); } }

        /* 3. LAYOUT Y PANEL DE AUTENTICACIÓN */
        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
            perspective: 1500px;
        }
        
        .auth-panel {
            width: 100%;
            max-width: 420px;
            background: var(--c-glass-bg);
            backdrop-filter: blur(var(--blur-strength));
            -webkit-backdrop-filter: blur(var(--blur-strength));
            border: 1px solid var(--c-glass-border);
            border-radius: var(--radius-lg);
            padding: 40px;
            text-align: center;
            transform-style: preserve-3d;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
        }
        .auth-panel:hover {
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            transform: rotateY(var(--rotateY)) rotateX(var(--rotateX)) scale(1.02);
        }

        .auth-header h1 {
            font-weight: 800;
            font-size: 2.5rem;
            color: var(--c-text);
        }
        
        .auth-header p {
            font-size: 1rem;
            color: var(--c-text-secondary);
            margin-top: 8px;
            margin-bottom: 32px;
        }

        /* 4. ESTILOS DE FORMULARIO */
        .form-content {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 24px;
        }
        .input-group {
            position: relative;
            text-align: left;
        }
        .input-field {
            width: 100%;
            padding: 14px 18px;
            background-color: var(--c-input-bg);
            border: 1px solid var(--c-input-border);
            border-radius: var(--radius-md);
            color: var(--c-text);
            font-size: 1rem;
            font-weight: 500;
            transition: border-color var(--transition-fast) ease, background-color var(--transition-fast) ease;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--c-input-border-focus);
            background-color: transparent;
        }

        .auth-button {
            width: 100%;
            padding: 16px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            border-radius: var(--radius-md);
            border: none;
            background-color: var(--c-accent);
            color: var(--c-accent-text);
            transition: transform var(--transition-fast) ease, box-shadow var(--transition-fast) ease;
        }
        .auth-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px -5px var(--c-accent, hsla(260, 80%, 70%, 0.4));
        }

        .form-switcher {
            color: var(--c-text-secondary);
            font-size: 0.9rem;
        }
        .form-switcher a {
            color: var(--c-accent);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        
        .hidden {
            display: none;
        }

        /* 5. CAMBIADOR DE TEMA */
        #theme-switcher {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 8px;
            padding: 8px;
            z-index: 100;
        }
        .theme-button {
            width: 24px; height: 24px; border-radius: 50%; cursor: pointer;
            border: 2px solid var(--c-glass-border);
            transition: all var(--transition-fast);
        }
        .theme-button:hover { transform: scale(1.2); }
        .theme-button.active { border-color: var(--c-accent); }
        #btn-aurora { background: linear-gradient(45deg, hsl(210, 80%, 50%), hsl(260, 80%, 60%)); }
        #btn-dark { background: #000; }
        #btn-light { background: #fff; }

        /* 6. RESPONSIVE */
        @media (max-width: 480px) {
            .auth-panel {
                padding: 24px;
            }
            .auth-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="theme-aurora">

    <div id="aurora-background">
        <div class="aurora-blob"></div>
        <div class="aurora-blob"></div>
    </div>
    
    <div id="theme-switcher">
        <button class="theme-button active" id="btn-aurora" data-theme="theme-aurora" title="Tema Aurora"></button>
        <button class="theme-button" id="btn-dark" data-theme="theme-dark" title="Tema Oscuro"></button>
        <button class="theme-button" id="btn-light" data-theme="theme-light" title="Tema Claro"></button>
    </div>

    <main class="auth-container">
        <div class="auth-panel">
            <div class="auth-header">
                <h1>Quimera</h1>
                <p>Conecta. Descubre. Inspira.</p>
            </div>

            <form id="login-form" action="/login.php" method="POST">
                <div class="form-content">
                    <div class="input-group">
                        <input type="email" id="login-email" name="email" class="input-field" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="login-password" name="password" class="input-field" placeholder="Contraseña" required>
                    </div>
                </div>
                <button type="submit" class="auth-button">Iniciar Sesión</button>
            </form>

            <form id="register-form" action="/register.php" method="POST" class="hidden">
                <div class="form-content">
                     <div class="input-group">
                        <input type="text" id="register-name" name="name" class="input-field" placeholder="Nombre completo" required>
                    </div>
                    <div class="input-group">
                        <input type="email" id="register-email" name="email" class="input-field" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="register-password" name="password" class="input-field" placeholder="Contraseña" required>
                    </div>
                </div>
                <button type="submit" class="auth-button">Crear Cuenta</button>
            </form>
            
            <p class="form-switcher" id="switcher-p">
                <span id="to-register">¿No tienes cuenta? <a id="show-register">Regístrate</a></span>
                <span id="to-login" class="hidden">¿Ya tienes cuenta? <a id="show-login">Inicia Sesión</a></span>
            </p>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- LÓGICA DEL CAMBIADOR DE TEMAS ---
            const themeSwitcher = document.getElementById('theme-switcher');
            const themeButtons = themeSwitcher.querySelectorAll('.theme-button');
            
            themeSwitcher.addEventListener('click', (e) => {
                const target = e.target.closest('.theme-button');
                if (target) {
                    document.body.className = target.dataset.theme;
                    themeSwitcher.querySelector('.active')?.classList.remove('active');
                    target.classList.add('active');
                }
            });

            // --- LÓGICA PARA INTERCAMBIAR FORMULARIOS ---
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const showRegisterBtn = document.getElementById('show-register');
            const showLoginBtn = document.getElementById('show-login');
            const toRegisterText = document.getElementById('to-register');
            const toLoginText = document.getElementById('to-login');

            showRegisterBtn.addEventListener('click', (e) => {
                e.preventDefault();
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                toRegisterText.classList.add('hidden');
                toLoginText.classList.remove('hidden');
            });

            showLoginBtn.addEventListener('click', (e) => {
                e.preventDefault();
                registerForm.classList.add('hidden');
                loginForm.classList.remove('hidden');
                toLoginText.classList.add('hidden');
                toRegisterText.classList.remove('hidden');
            });
            
            // --- EFECTO 3D EN EL PANEL ---
            const authPanel = document.querySelector('.auth-panel');
            if (authPanel && window.matchMedia("(pointer: fine)").matches) {
                authPanel.addEventListener('mousemove', (e) => {
                    const rect = authPanel.getBoundingClientRect();
                    const centerX = rect.left + rect.width / 2;
                    const centerY = rect.top + rect.height / 2;
                    
                    const rotateX = (e.clientY - centerY) / 40; // Sensibilidad del efecto
                    const rotateY = -(e.clientX - centerX) / 40;
                    
                    authPanel.style.setProperty('--rotateX', `${rotateX}deg`);
                    authPanel.style.setProperty('--rotateY', `${rotateY}deg`);
                });

                authPanel.addEventListener('mouseleave', () => {
                    authPanel.style.setProperty('--rotateX', '0deg');
                    authPanel.style.setProperty('--rotateY', '0deg');
                });
            }
        });
    </script>
</body>
</html>