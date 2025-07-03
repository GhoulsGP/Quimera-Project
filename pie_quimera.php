<?php
// ARCHIVO: pie_quimera.php (v7.5 - Corrección de Arquitectura de Notificaciones)
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

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;

        // --- LÓGICA GLOBAL DE LA PLANTILLA (VERIFICADA Y ESCALADA) ---
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
        
        // --- LÓGICA DE LA PALETA DE BÚSQUEDA ---
        const searchTrigger = document.getElementById('search-trigger');
        const searchPalette = document.getElementById('search-palette');
        const searchBackdrop = document.getElementById('search-backdrop');
        const searchInput = document.getElementById('search-input-field');
        const searchResultsList = document.getElementById('search-results-list');

        if (searchTrigger && searchPalette) {
            const openSearch = (e) => {
                e.preventDefault();
                searchPalette.classList.add('open');
                searchInput.focus();
            };
            const closeSearch = () => {
                searchPalette.classList.remove('open');
                searchInput.value = '';
                if(searchResultsList) searchResultsList.innerHTML = '';
            };
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
                notificationsList.innerHTML = '';
                dummyNotifications.forEach(n => {
                    const li = document.createElement('li');
                    li.className = 'notification-item';
                    let contentHTML = '';
                    if (n.type === 'like') {
                        contentHTML = `
                            <img src="https://randomuser.me/api/portraits/lego/${n.avatar}.jpg" alt="Avatar" class="notification-avatar">
                            <div class="notification-content">
                                <b>${n.by[0]}</b> y <b>${n.count - 1} personas más</b> han indicado que les gusta ${n.post}.
                            </div>`;
                    } else if (n.type === 'comment') {
                        contentHTML = `
                            <img src="https://randomuser.me/api/portraits/lego/${n.avatar}.jpg" alt="Avatar" class="notification-avatar">
                            <div class="notification-content">
                                <b>${n.by}</b> ha comentado en ${n.on}:
                                <span class="post-quote">${n.text}</span>
                                <div class="notification-footer">
                                    <button class="inline-action-button">Responder</button>
                                </div>
                            </div>`;
                    } else if (n.type === 'follow') {
                        contentHTML = `
                             <img src="https://randomuser.me/api/portraits/lego/${n.avatar}.jpg" alt="Avatar" class="notification-avatar">
                            <div class="notification-content">
                                <b>${n.by}</b> ha comenzado a seguirte.
                            </div>`;
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
                    notificationsTrigger.classList.add('has-new');
                    renderNotifications();
                } else {
                    notificationsTrigger.classList.remove('has-new');
                }
            });

            document.addEventListener('click', (e) => {
                if (!notificationsPopover.contains(e.target) && !notificationsTrigger.contains(e.target)) {
                    notificationsPopover.classList.remove('open');
                    notificationsTrigger.classList.remove('has-new');
                }
            });
        }

        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        if(document.querySelector('.home-layout')) {
            // ... (resto del código sin cambios)
        }
    });
    </script>
</body>
</html>