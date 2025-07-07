<?php
// ARCHIVO: pie_quimera.php (v10.1 - Lógica de Perfil Añadida)
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
        
        // --- LÓGICA DE LA PALETA DE BÚSQUEDA (COMPLETA Y RESTAURADA) ---
        const searchTrigger = document.getElementById('search-trigger');
        const searchPalette = document.getElementById('search-palette');
        if (searchTrigger && searchPalette) {
            const searchBackdrop = searchPalette.querySelector('.search-backdrop');
            const searchInput = searchPalette.querySelector('#search-input-field');
            const searchResultsList = searchPalette.querySelector('#search-results-list');
            
            const openSearch = (e) => { e.preventDefault(); searchPalette.style.display = 'flex'; setTimeout(() => searchPalette.classList.add('open'), 10); searchInput.focus(); };
            const closeSearch = () => { searchPalette.classList.remove('open'); setTimeout(() => { searchPalette.style.display = 'none'; searchInput.value = ''; if(searchResultsList) searchResultsList.innerHTML = ''; }, 200); };
            
            searchTrigger.addEventListener('click', openSearch);
            searchBackdrop.addEventListener('click', closeSearch);

            const dummyUsers = [
                { name: 'Elena Codes', handle: '@elenacodes', avatar: '9' },
                { name: 'David UX', handle: '@davidux', avatar: '8' },
                { name: 'Ana Design', handle: '@anadesign', avatar: '7' },
                { name: 'Carlos Dev', handle: '@carlosdev', avatar: '6' },
                { name: 'Marco Polo', handle: '@marcop', avatar: '3' },
            ];

            searchInput.addEventListener('input', () => {
                if (!searchResultsList) return;
                searchResultsList.innerHTML = '';
                const query = searchInput.value.toLowerCase();
                if (query.length === 0) return;
                const filteredUsers = dummyUsers.filter(user => 
                    user.name.toLowerCase().includes(query) || user.handle.toLowerCase().includes(query)
                );
                filteredUsers.forEach((user, index) => {
                    const li = document.createElement('li');
                    li.className = 'search-result-item';
                    li.style.animationDelay = `${index * 0.05}s`;
                    li.style.transform = `translateY(10px)`;
                    li.innerHTML = `
                        <img src="https://randomuser.me/api/portraits/lego/${user.avatar}.jpg" alt="Avatar" class="result-avatar">
                        <div class="result-info">
                            <span class="result-name">${user.name}</span>
                            <span class="result-handle">${user.handle}</span>
                        </div>
                    `;
                    searchResultsList.appendChild(li);
                });
            });
        }

        // --- LÓGICA DE NOTIFICACIONES ---
        const notificationsTrigger = document.getElementById('notifications-trigger');
        const notificationsPopover = document.getElementById('notifications-popover');
        const mainNav = document.getElementById('main-nav');
        if (notificationsTrigger && notificationsPopover && mainNav) {
            const notificationsList = document.getElementById('notifications-list');
            const dummyNotifications = [
                { type: 'like', by: ['Elena Codes', 'David UX', 'Ana Design', 'Carlos Dev'], post: 'tu post "UX de Lujo"', count: 4, avatar: '9' },
                { type: 'comment', by: 'Marco Polo', on: 'tu post "Arquitectura CSS"', text: '¡Excelente análisis de la arquitectura! Muy claro.', avatar: '3' },
                { type: 'follow', by: 'Jane Dev', avatar: '4' }
            ];
            const renderNotifications = () => {
                if(!notificationsList) return;
                notificationsList.innerHTML = '';
                dummyNotifications.forEach(n => {
                    const li = document.createElement('li');
                    li.className = 'notification-item';
                    let contentHTML = '';
                    if (n.type === 'like') {
                        contentHTML = `<img src="https://randomuser.me/api/portraits/lego/${n.avatar}.jpg" alt="Avatar" class="notification-avatar"><div class="notification-content"><b>${n.by[0]}</b> y <b>${n.count - 1} personas más</b> han indicado que les gusta ${n.post}.</div>`;
                    } else if (n.type === 'comment') {
                        contentHTML = `<img src="https://randomuser.me/api/portraits/lego/${n.avatar}.jpg" alt="Avatar" class="notification-avatar"><div class="notification-content"><b>${n.by}</b> ha comentado en ${n.on}:<span class="post-quote">${n.text}</span><div class="notification-footer"><button class="inline-action-button">Responder</button></div></div>`;
                    } else if (n.type === 'follow') {
                        contentHTML = `<img src="https://randomuser.me/api/portraits/lego/${n.avatar}.jpg" alt="Avatar" class="notification-avatar"><div class="notification-content"><b>${n.by}</b> ha comenzado a seguirte.</div>`;
                    }
                    li.innerHTML = contentHTML;
                    notificationsList.appendChild(li);
                });
            };
            notificationsTrigger.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                const triggerRect = notificationsTrigger.getBoundingClientRect();
                const navRect = mainNav.getBoundingClientRect();
                const topPosition = triggerRect.top - navRect.top;
                notificationsPopover.style.top = `${topPosition}px`;
                const isOpen = notificationsPopover.classList.toggle('open');
                if (isOpen) {
                    renderNotifications();
                }
            });
            document.addEventListener('click', (e) => {
                if (!notificationsPopover.contains(e.target) && !notificationsTrigger.contains(e.target)) {
                    notificationsPopover.classList.remove('open');
                }
            });
        }

        // --- LÓGICA DEL CENTRO DE MENSAJES ---
        const messagesTrigger = document.getElementById('messages-trigger');
        const messageCenter = document.getElementById('message-center');
        if (messagesTrigger && messageCenter) {
            const mcBackdrop = messageCenter.querySelector('.mc-backdrop');
            const openMessageCenter = () => { messageCenter.style.display = 'flex'; setTimeout(() => messageCenter.classList.add('open'), 10); };
            const closeMessageCenter = () => { messageCenter.classList.remove('open'); setTimeout(() => messageCenter.style.display = 'none', 400); };
            messagesTrigger.addEventListener('click', (e) => { e.preventDefault(); openMessageCenter(); });
            if (mcBackdrop) { mcBackdrop.addEventListener('click', closeMessageCenter); }
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && messageCenter.classList.contains('open')) { closeMessageCenter(); } });
        }
        
        // --- LÓGICA DE INTERACCIÓN DE POSTS ---
        const feedContainer = document.querySelector('.feed-container, .profile-main-content'); // Selector actualizado
        if(feedContainer) {
            feedContainer.addEventListener('click', (e) => {
                const likeButton = e.target.closest('.like-button');
                const saveButton = e.target.closest('.save-button');
                const commentButton = e.target.closest('.comment-button');

                if (likeButton) { likeButton.classList.toggle('active'); }
                if (saveButton) { saveButton.classList.toggle('active'); }
                if (commentButton) {
                    const postCard = commentButton.closest('.post-card');
                    if (postCard) {
                        const commentsSection = postCard.querySelector('.post-comments-section');
                        if (commentsSection) { commentsSection.classList.toggle('open'); }
                    }
                }
            });
        }

        // --- LÓGICA DE PERFIL DE USUARIO (PESTAÑAS) ---
        const profileTabsContainer = document.querySelector('.profile-tabs');
        if (profileTabsContainer) {
            const tabLinks = profileTabsContainer.querySelectorAll('.tab-link');
            const tabContents = document.querySelectorAll('.tab-content');

            tabLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    const tabId = link.dataset.tab;

                    // Desactivar todas las pestañas y contenidos
                    tabLinks.forEach(l => l.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));

                    // Activar la pestaña y contenido seleccionados
                    link.classList.add('active');
                    document.getElementById(`tab-${tabId}`).classList.add('active');
                });
            });
        }
    });
    </script>
</body>
</html>