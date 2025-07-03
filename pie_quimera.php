<?php
// ARCHIVO: pie_quimera.php (v5.0 - Maquetación Definitiva)
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

            // --- SOLUCIÓN MASONRY CON JAVASCRIPT ---
            const feedGrid = document.querySelector('.feed-grid');
            const postTemplates = document.getElementById('post-templates');
            const gridColumns = feedGrid.querySelectorAll('.feed-grid-col');

            function distributePosts() {
                if (!feedGrid || !postTemplates || gridColumns.length === 0) return;

                // En pantallas pequeñas, todo a una columna.
                if (window.innerWidth <= 768) {
                    gridColumns[1].innerHTML = ''; // Vaciar segunda columna por si acaso
                    // Mover todos los posts a la primera columna si no están ya ahí
                    if (gridColumns[0].children.length !== postTemplates.children.length) {
                        gridColumns[0].innerHTML = '';
                        Array.from(postTemplates.children).forEach(post => {
                            gridColumns[0].appendChild(post.cloneNode(true));
                        });
                    }
                    return;
                }

                // En escritorio, distribuir en 2 columnas
                const columns = [gridColumns[0], gridColumns[1]];
                columns.forEach(col => col.innerHTML = ''); // Limpiar columnas
                const posts = Array.from(postTemplates.children);

                posts.forEach((post, index) => {
                    // Distribuir alternando entre la columna 0 y la 1
                    columns[index % 2].appendChild(post.cloneNode(true));
                });
            }

            // Esperar a que todo cargue para que las alturas sean correctas
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