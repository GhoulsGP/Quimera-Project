<?php
// ARCHIVO: pie_quimera.php (v3.2 - Funcionalidad Completa)
?>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;

        // --- LÓGICA GLOBAL DE LA PLANTILLA (RESTAURADA Y VERIFICADA) ---
        // 1. Menú expandible
        const navToggle = document.getElementById('nav-toggle'); 
        if(navToggle) {
            navToggle.addEventListener('click', (e) => {
                e.preventDefault();
                body.classList.toggle('nav-expanded');
            });
        }
        
        // 2. Cambiador de Tema
        const themeSwitcher = document.getElementById('theme-switcher');
        if (themeSwitcher) {
            themeSwitcher.addEventListener('click', (e) => {
                const target = e.target.closest('.theme-button');
                if (target) {
                    const theme = target.dataset.theme;
                    body.className = body.classList.contains('nav-expanded') ? `${theme} nav-expanded` : theme;
                    
                    themeSwitcher.querySelector('.active')?.classList.remove('active');
                    target.classList.add('active');
                    
                    if (theme === 'theme-aurora') setGenerativeTheme();
                }
            });
        }

        // 3. Botón de Sonido
        let soundsEnabled = false;
        const soundToggle = document.getElementById('sound-toggle');
        const soundOnIcon = document.getElementById('sound-on-icon');
        const soundOffIcon = document.getElementById('sound-off-icon');

        if (soundToggle) {
            soundToggle.addEventListener('click', (e) => {
                e.preventDefault();
                soundsEnabled = !soundsEnabled;
                soundOnIcon.style.display = soundsEnabled ? 'block' : 'none';
                soundOffIcon.style.display = soundsEnabled ? 'none' : 'block';
            });
        }

        // 4. Tema Generativo (Ciclo Día/Noche)
        function setGenerativeTheme() {
            const hour = new Date().getHours();
            let accentHue;
            if (hour >= 5 && hour < 12) { accentHue = 190; } // Mañana
            else if (hour >= 12 && hour < 18) { accentHue = 260; } // Tarde
            else if (hour >= 18 && hour < 22) { accentHue = 30; } // Atardecer
            else { accentHue = 220; } // Noche
            document.documentElement.style.setProperty('--c-accent-h', accentHue);
        }
        if (body.classList.contains('theme-aurora')) {
            setGenerativeTheme();
        }


        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        if(document.querySelector('.home-layout')) {
            
            // Lógica de Interacción de Tarjetas (Like, Comentar, Guardar)
            const postCards = document.querySelectorAll('.post-card');
            postCards.forEach(card => {
                const likeButton = card.querySelector('.like-button');
                const commentButton = card.querySelector('.comment-button');
                const saveButton = card.querySelector('.save-button');
                const commentsSection = card.querySelector('.post-comments-section');

                if (likeButton) {
                    likeButton.addEventListener('click', () => { likeButton.classList.toggle('active'); });
                }
                if (commentButton && commentsSection) {
                    commentButton.addEventListener('click', () => { commentsSection.classList.toggle('open'); });
                }
                if (saveButton) {
                    saveButton.addEventListener('click', () => { saveButton.classList.toggle('active'); });
                }
            });

            // Texto Cinético (RESTAURADO Y VERIFICADO)
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