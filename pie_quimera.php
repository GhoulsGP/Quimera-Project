<?php
// ARCHIVO: pie_quimera.php (v6.5 - Corrección de Interacción de Paneles)
?>
        </main>
    </div>
    
    <div class="search-palette" id="search-palette">
        <div class="search-backdrop" id="search-backdrop"></div>
        <div class="search-container">
            <div class="search-input-wrapper">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 17.25a6.25 6.25 0 110-12.5 6.25 6.25 0 010 12.5z"></path><path d="M16 16l4.5 4.5"></path></svg>
                <input type="text" id="search-input-field" placeholder="Buscar usuarios por nombre o @handle...">
            </div>
            <ul id="search-results-list">
            </ul>
        </div>
    </div>

    <div id="message-center">
        <div class="mc-backdrop"></div>
        <div class="mc-panel">
            <aside class="mc-sidebar">
                <header class="mc-sidebar-header">
                    <h2>Mensajes</h2>
                    <button class="mc-new-message-btn" title="Nuevo Mensaje">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14m-7-7h14"></path></svg>
                    </button>
                </header>
                <div class="mc-search-wrapper">
                    <input type="text" class="mc-search-input" placeholder="Buscar conversaciones...">
                </div>
                <ul id="mc-conversation-list" class="mc-conversation-list">
                    <li class="mc-conversation-item active">
                        <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="Avatar" class="mc-conversation-avatar">
                        <div class="mc-conversation-details">
                            <span class="mc-conversation-name">Elena Codes</span>
                            <p class="mc-conversation-excerpt">Perfecto, entiendo la arquitectura. Procedamos.</p>
                        </div>
                        <div class="mc-conversation-meta">
                            <time class="mc-conversation-time">Ahora</time>
                            <span class="mc-unread-badge">2</span>
                        </div>
                    </li>
                     <li class="mc-conversation-item">
                        <img src="https://randomuser.me/api/portraits/lego/2.jpg" alt="Avatar" class="mc-conversation-avatar">
                        <div class="mc-conversation-details">
                            <span class="mc-conversation-name">David UX</span>
                            <p class="mc-conversation-excerpt">¿Has visto el nuevo flujo de onboarding?</p>
                        </div>
                        <div class="mc-conversation-meta">
                            <time class="mc-conversation-time">1h</time>
                        </div>
                    </li>
                </ul>
            </aside>
            <section class="mc-chat-panel">
                <header class="mc-chat-header">
                    <div class="mc-user-info">
                        <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="Avatar" class="mc-user-avatar">
                        <div>
                            <span class="mc-user-name">Elena Codes</span>
                            <span class="mc-user-status online">En línea</span>
                        </div>
                    </div>
                    <div class="mc-chat-actions">
                         <button title="Llamar"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path></svg></button>
                         <button title="Más información"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></button>
                    </div>
                </header>
                <div id="mc-message-history" class="mc-message-history">
                    <div class="mc-message received">
                        <div class="mc-message-bubble">Hola, he revisado la nueva arquitectura del indicador. Impecable.</div>
                    </div>
                     <div class="mc-message sent">
                        <div class="mc-message-bubble">Gracias. La robustez era la máxima prioridad.</div>
                    </div>
                </div>
                <form class="mc-input-form" onsubmit="event.preventDefault();">
                    <input type="text" class="mc-message-input" placeholder="Escribe un mensaje...">
                    <button type="submit" class="mc-send-button" title="Enviar Mensaje">
                        <svg fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
                    </button>
                </form>
            </section>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;

        // --- LÓGICA GLOBAL DE LA PLANTILLA ---
        const navToggles = document.querySelectorAll('[data-action="toggle-nav"]');
        navToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                body.classList.toggle('nav-expanded');
            });
        });
        
        const themeSwitcher = document.getElementById('theme-switcher');
        if (themeSwitcher) {
            themeSwitcher.addEventListener('click', (e) => {
                const target = e.target.closest('.theme-button');
                if (target) {
                    body.classList.remove('theme-aurora', 'theme-dark', 'theme-light');
                    body.classList.add(target.dataset.theme);
                    themeSwitcher.querySelector('.active')?.classList.remove('active');
                    target.classList.add('active');
                }
            });
        }
        
        // --- INICIO: LÓGICA DE PANELES INTERACTIVOS (BÚSQUEDA, NOTIFICACIONES, MENSAJES) ---
        const searchTrigger = document.getElementById('search-trigger');
        const searchPalette = document.getElementById('search-palette');
        const searchBackdrop = document.getElementById('search-backdrop');

        const notificationsTrigger = document.getElementById('notifications-trigger');
        const notificationsPopover = document.getElementById('notifications-popover');

        const messagesTrigger = document.getElementById('messages-trigger');
        const messageCenter = document.getElementById('message-center');
        const mcBackdrop = messageCenter.querySelector('.mc-backdrop');

        if (searchTrigger && searchPalette && searchBackdrop) {
            searchTrigger.addEventListener('click', e => {
                e.preventDefault();
                searchPalette.classList.add('open');
            });
            searchBackdrop.addEventListener('click', () => {
                searchPalette.classList.remove('open');
            });
        }

        if (notificationsTrigger && notificationsPopover) {
            notificationsTrigger.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation(); // Evita que el click se propague al listener del documento y cierre el popover inmediatamente.
                notificationsPopover.classList.toggle('open');
            });
        }
        
        if (messagesTrigger && messageCenter && mcBackdrop) {
            messagesTrigger.addEventListener('click', e => {
                e.preventDefault();
                messageCenter.classList.add('open');
            });
            mcBackdrop.addEventListener('click', () => {
                messageCenter.classList.remove('open');
            });
        }

        // Listener global para cerrar elementos como popovers al hacer click fuera de ellos.
        document.addEventListener('click', (e) => {
            // Cierre del popover de notificaciones.
            if (notificationsPopover && notificationsPopover.classList.contains('open')) {
                if (!notificationsPopover.contains(e.target) && !notificationsTrigger.contains(e.target)) {
                    notificationsPopover.classList.remove('open');
                }
            }
        });
        // --- FIN: LÓGICA DE PANELES INTERACTIVOS ---

        // --- LÓGICA DE INTERACCIÓN DE TARJETAS (GENERALIZADA Y CORREGIDA) ---
        // Esta lógica ahora se aplica a cualquier página que contenga un .post-card
        const postCards = document.querySelectorAll('.post-card');
        if (postCards.length > 0) {
            postCards.forEach(card => {
                const likeButton = card.querySelector('.like-button');
                const commentButton = card.querySelector('.comment-button');
                const saveButton = card.querySelector('.save-button');
                const commentsSection = card.querySelector('.post-comments-section');

                // Se adjuntan los listeners solo si no han sido adjuntados previamente
                if (likeButton && !likeButton.dataset.listenerAttached) { 
                    likeButton.addEventListener('click', (e) => { 
                        e.stopPropagation();
                        likeButton.classList.toggle('active'); 
                    });
                    likeButton.dataset.listenerAttached = 'true';
                }
                if (commentButton && commentsSection && !commentButton.dataset.listenerAttached) { 
                    commentButton.addEventListener('click', (e) => { 
                        e.stopPropagation();
                        commentsSection.classList.toggle('open'); 
                    });
                    commentButton.dataset.listenerAttached = 'true';
                }
                if (saveButton && !saveButton.dataset.listenerAttached) { 
                    saveButton.addEventListener('click', (e) => {
                        e.stopPropagation(); 
                        saveButton.classList.toggle('active'); 
                    });
                    saveButton.dataset.listenerAttached = 'true';
                }
            });
        }

        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        if(document.querySelector('.home-layout')) {
            const kineticTexts = document.querySelectorAll('.kinetic-text');
            kineticTexts.forEach(text => {
                if (text.classList.contains('kinetic-processed')) return;
                const originalText = text.textContent;
                const letters = originalText.split('').map(letter => {
                    const dx = (Math.random() - 0.5) * 20;
                    const dy = (Math.random() - 0.5) * 20;
                    const r = (Math.random() - 0.5) * 30;
                    return `<span class="char" style="--dx:${dx}px; --dy:${dy}px; --r:${r}deg;">${letter}</span>`;
                }).join('');
                text.innerHTML = letters;
                text.classList.add('kinetic-processed');
            });
        }

        // --- LÓGICA DE PESTAÑAS PARA PÁGINA DE PERFIL (LEGACY v4.0) ---
        if (document.querySelector('.profile-spotlight-layout')) {
            const tabsContainer = document.querySelector('.profile-tabs ul');
            if (tabsContainer) {
                const tabLinks = tabsContainer.querySelectorAll('.tab-link');
                const tabContents = document.querySelectorAll('.tab-content');

                tabsContainer.addEventListener('click', (e) => {
                    e.preventDefault();
                    const clickedTab = e.target.closest('.tab-link');

                    if (!clickedTab || clickedTab.classList.contains('active')) {
                        return;
                    }
                    
                    tabLinks.forEach(link => link.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    clickedTab.classList.add('active');
                    const tabId = clickedTab.dataset.tab;
                    const newActiveContent = document.getElementById(`tab-${tabId}`);
                    if (newActiveContent) {
                        newActiveContent.classList.add('active');
                    }
                });
            }
        }
        
        // --- INICIO: LÓGICA DE PERFIL "QUANTUM GLASS" (v5.1 - CORREGIDO) ---
        if (document.querySelector('.profile-qg-layout')) {
            // 1. Efecto Parallax para la portada
            const heroCover = document.getElementById('qg-hero-cover');
            if(heroCover) {
                window.addEventListener('scroll', () => {
                    const scrollY = window.scrollY;
                    heroCover.style.transform = `scale(1.1) translateY(${scrollY * 0.3}px)`;
                });
            }

            // 2. Animación de entrada para las tarjetas de la Sidebar
            const sidebarCards = document.querySelectorAll('.profile-qg-sidebar .profile-qg-card');
            if (sidebarCards.length > 0) {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            entry.target.style.transitionDelay = `${index * 100}ms`;
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });

                sidebarCards.forEach(card => {
                    observer.observe(card);
                });
            }

            // 3. Lógica de Pestañas Animadas
            const tabsContainer = document.querySelector('.profile-qg-tabs ul');
            if (tabsContainer) {
                const tabLinks = tabsContainer.querySelectorAll('.tab-link');
                const tabContents = document.querySelectorAll('.profile-qg-main .tab-content');

                tabsContainer.addEventListener('click', (e) => {
                    e.preventDefault();
                    const clickedTab = e.target.closest('.tab-link');

                    if (!clickedTab || clickedTab.classList.contains('active')) {
                        return;
                    }
                    
                    const currentActiveTab = tabsContainer.querySelector('.active');
                    const currentActiveContent = document.querySelector('.tab-content.active');
                    const tabId = clickedTab.dataset.tab;
                    const newActiveContent = document.getElementById(`tab-${tabId}`);

                    if (currentActiveContent && newActiveContent) {
                        currentActiveContent.style.opacity = '0';
                        setTimeout(() => {
                            currentActiveTab.classList.remove('active');
                            currentActiveContent.classList.remove('active');
                            currentActiveContent.style.opacity = '';
                            
                            clickedTab.classList.add('active');
                            newActiveContent.classList.add('active');
                            newActiveContent.style.opacity = '0';
                            
                            void newActiveContent.offsetWidth; 
                            
                            newActiveContent.style.transition = 'opacity 0.4s ease';
                            newActiveContent.style.opacity = '1';
                        }, 300);
                    }
                });
            }
        }
        // --- FIN: LÓGICA DE PERFIL "QUANTUM GLASS" ---

    });
    </script>
</body>
</html>