<?php
// ARCHIVO: pie_quimera.php (v5.2 - Corrección de Event Listeners)
?>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;

        // --- LÓGICA GLOBAL DE LA PLANTILLA (VERIFICADA) ---
        const navToggle = document.getElementById('nav-toggle'); 
        if(navToggle) {
            navToggle.addEventListener('click', (e) => {
                e.preventDefault();
                body.classList.toggle('nav-expanded');
            });
        }
        
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
        
        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        if(document.querySelector('.home-layout')) {

            const feedGrid = document.querySelector('.feed-grid');
            const postTemplates = document.getElementById('post-templates');
            const gridColumns = feedGrid.querySelectorAll('.feed-grid-col');

            // --- FUNCIÓN PARA AÑADIR LOS EVENTOS A LAS TARJETAS ---
            function attachCardEventListeners() {
                document.querySelectorAll('.feed-grid .post-card').forEach(card => {
                    // Prevenir doble asignación de eventos
                    if (card.dataset.eventsAttached) return;

                    const likeButton = card.querySelector('.like-button');
                    const commentButton = card.querySelector('.comment-button');
                    const saveButton = card.querySelector('.save-button');
                    const commentsSection = card.querySelector('.post-comments-section');

                    if (likeButton) { 
                        likeButton.addEventListener('click', (e) => { 
                            e.stopPropagation();
                            likeButton.classList.toggle('active'); 
                        }); 
                    }
                    if (commentButton && commentsSection) { 
                        commentButton.addEventListener('click', (e) => { 
                            e.stopPropagation();
                            commentsSection.classList.toggle('open'); 
                        }); 
                    }
                    if (saveButton) { 
                        saveButton.addEventListener('click', (e) => {
                            e.stopPropagation(); 
                            saveButton.classList.toggle('active'); 
                        }); 
                    }
                    card.dataset.eventsAttached = 'true';
                });
            }

            // --- FUNCIÓN PARA EL LAYOUT MASONRY ---
            function distributePosts() {
                if (!feedGrid || !postTemplates || gridColumns.length === 0) return;
                
                const posts = Array.from(postTemplates.children);
                columns = [gridColumns[0], gridColumns[1]];
                columns.forEach(col => col.innerHTML = '');

                if (window.innerWidth <= 768) {
                    // En móvil, todo a una columna
                    posts.forEach(post => {
                        columns[0].appendChild(post.cloneNode(true));
                    });
                } else {
                    // En escritorio, distribuir en 2 columnas
                    posts.forEach((post, index) => {
                        columns[index % 2].appendChild(post.cloneNode(true));
                    });
                }
                // IMPORTANTE: Asignar los eventos DESPUÉS de clonar y añadir los posts al DOM
                attachCardEventListeners();
            }

            window.addEventListener('load', distributePosts);
            window.addEventListener('resize', distributePosts);
            
            // --- TEXTO CINÉTICO (VERIFICADO) ---
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
    });
    </script>
</body>
</html>