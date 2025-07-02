<?php
// ARCHIVO: pie_quimera.php (v1.5 - Corrección de Visibilidad)
?>
        </main>
    </div>

    <audio id="audio-click" src="/sounds/click.mp3" preload="auto"></audio>
    <audio id="audio-like" src="/sounds/like.mp3" preload="auto"></audio>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;
        // --- LÓGICA GLOBAL DE LA PLANTILLA ---
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

        // --- LÓGICA DE PAISAJISMO SONORO ---
        let soundsEnabled = false;
        const audioClick = document.getElementById('audio-click');
        const soundToggle = document.getElementById('sound-toggle');
        const soundOnIcon = document.getElementById('sound-on-icon');
        const soundOffIcon = document.getElementById('sound-off-icon');
        function playSound(audioElement) {
            if (soundsEnabled && audioElement) {
                audioElement.currentTime = 0;
                audioElement.play().catch(e => console.error("Error al reproducir sonido:", e));
            }
        }
        if (soundToggle) {
            soundToggle.addEventListener('click', (e) => {
                e.preventDefault();
                soundsEnabled = !soundsEnabled;
                soundOnIcon.style.display = soundsEnabled ? 'block' : 'none';
                soundOffIcon.style.display = soundsEnabled ? 'none' : 'block';
                playSound(audioClick);
            });
        }

        // --- LÓGICA DE TEMA GENERATIVO ---
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

        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        if(document.querySelector('.home-layout')) {
            // Lógica de Animación de Entrada Segura
            const animatedItems = document.querySelectorAll('.animated-item');
            animatedItems.forEach(item => { item.classList.add('prepare-animation'); });
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => { entry.target.classList.add('is-visible'); }, index * 100);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.1 });
                animatedItems.forEach(item => observer.observe(item));
            } else {
                animatedItems.forEach(item => { item.classList.remove('prepare-animation'); });
            }
            
            // Lógica para Tarjeta de Crear Publicación
            const createPostCard = document.getElementById('create-post-card');
            if (createPostCard) {
                const createPostTextarea = createPostCard.querySelector('.create-post-textarea');
                createPostCard.addEventListener('click', () => {
                    if (!createPostCard.classList.contains('expanded')) {
                        createPostCard.classList.add('expanded');
                        createPostTextarea.focus();
                    }
                });
            }
        }
    });
    </script>
</body>
</html>