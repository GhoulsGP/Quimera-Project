<?php
// ARCHIVO: pie_quimera.php (v3.1)
?>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- LÓGICA GLOBAL DE LA PLANTILLA (Menú, Temas, etc.) ---
        const body = document.body;
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

            // --- LÓGICA PARA BOTONES DE ACCIÓN ---
            const likeButtons = document.querySelectorAll('.like-button');
            likeButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.classList.toggle('liked');
                });
            });

            // --- TEXTO CINÉTICO (RESTAURADO Y VERIFICADO) ---
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