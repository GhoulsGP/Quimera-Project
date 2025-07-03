<?php
// ARCHIVO: pie_quimera.php (v4.3 - Funcionalidad Completa)
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
                    const theme = target.dataset.theme;
                    body.classList.add(theme);
                    themeSwitcher.querySelector('.active')?.classList.remove('active');
                    target.classList.add('active');
                    if (theme === 'theme-aurora') setGenerativeTheme();
                }
            });
        }

        let soundsEnabled = false;
        const soundToggle = document.getElementById('sound-toggle');
        const soundOnIcon = document.getElementById('sound-on-icon');
        const soundOffIcon = document.getElementById('sound-off-icon');
        function playSound(soundId) {
            if (soundsEnabled) {
                const audioElement = document.getElementById(soundId);
                if(audioElement) {
                    audioElement.currentTime = 0;
                    audioElement.play().catch(e => console.error("Error al reproducir sonido:", e));
                }
            }
        }
        if (soundToggle) {
            soundToggle.addEventListener('click', (e) => {
                e.preventDefault();
                soundsEnabled = !soundsEnabled;
                soundOnIcon.style.display = soundsEnabled ? 'block' : 'none';
                soundOffIcon.style.display = soundsEnabled ? 'none' : 'block';
                playSound('audio-click');
            });
        }
        
        function setGenerativeTheme() {
            const hour = new Date().getHours();
            let accentHue;
            if (hour >= 5 && hour < 12) { accentHue = 190; }
            else if (hour >= 12 && hour < 18) { accentHue = 260; }
            else if (hour >= 18 && hour < 22) { accentHue = 30; }
            else { accentHue = 220; }
            document.documentElement.style.setProperty('--c-accent-h', accentHue);
        }
        if (body.classList.contains('theme-aurora')) {
            setGenerativeTheme();
        }

        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO (VERIFICADOS) ---
        if(document.querySelector('.home-layout')) {
            
            // Lógica de Interacción de Tarjetas (Like, Comentar, Guardar)
            document.querySelectorAll('.post-card').forEach(card => {
                const likeButton = card.querySelector('.like-button');
                const commentButton = card.querySelector('.comment-button');
                const saveButton = card.querySelector('.save-button');
                const commentsSection = card.querySelector('.post-comments-section');

                if (likeButton) { likeButton.addEventListener('click', () => { likeButton.classList.toggle('active'); }); }
                if (commentButton && commentsSection) { commentButton.addEventListener('click', () => { commentsSection.classList.toggle('open'); }); }
                if (saveButton) { saveButton.addEventListener('click', () => { saveButton.classList.toggle('active'); }); }
            });

            // Texto Cinético
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