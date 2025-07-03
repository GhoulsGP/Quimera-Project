<?php
// ARCHIVO: pie_quimera.php (v5.1 - Definitiva)
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

            // --- LÓGICA DE INTERACCIÓN DE TARJETAS (RESTAURADA) ---
            document.querySelectorAll('.post-card').forEach(card => {
                const likeButton = card.querySelector('.like-button');
                const commentButton = card.querySelector('.comment-button');
                const saveButton = card.querySelector('.save-button');
                
                if (likeButton) { likeButton.addEventListener('click', () => { likeButton.classList.toggle('active'); }); }
                if (commentButton) { commentButton.addEventListener('click', () => { /* Lógica de comentarios aquí */ }); }
                if (saveButton) { saveButton.addEventListener('click', () => { saveButton.classList.toggle('active'); }); }
            });

            // --- SCRIPT DE LAYOUT MASONRY (ESTABLE) ---
            const feedGrid = document.querySelector('.feed-grid');
            const postTemplates = document.getElementById('post-templates');
            const gridColumns = feedGrid.querySelectorAll('.feed-grid-col');

            function distributePosts() {
                if (!feedGrid || !postTemplates || gridColumns.length === 0) return;
                
                if (window.innerWidth <= 768) {
                    gridColumns[1].innerHTML = '';
                    if (gridColumns[0].children.length !== postTemplates.children.length) {
                        gridColumns[0].innerHTML = '';
                        Array.from(postTemplates.children).forEach(post => {
                            gridColumns[0].appendChild(post.cloneNode(true));
                        });
                    }
                    return;
                }
                
                const columns = [gridColumns[0], gridColumns[1]];
                columns.forEach(col => col.innerHTML = '');
                const posts = Array.from(postTemplates.children);

                posts.forEach((post, index) => {
                    columns[index % 2].appendChild(post.cloneNode(true));
                });
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