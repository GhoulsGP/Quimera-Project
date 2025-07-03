<?php
// ARCHIVO: pie_quimera.php (v4.1 - Hover de Lujo Estable)
?>
        </main>
    </div>
    <audio id="audio-click" src="/sounds/click.mp3" preload="auto"></audio>
    <audio id="audio-like" src="/sounds/like.mp3" preload="auto"></audio>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const body = document.body;
        // LÓGICA GLOBAL DE LA PLANTILLA
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
                    if (target.dataset.theme === 'theme-aurora') setGenerativeTheme();
                }
            });
        }
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

        // SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO
        if(document.querySelector('.home-layout')) {
            // Lógica de Interacción de Tarjetas
            document.querySelectorAll('.post-card').forEach(card => {
                const likeButton = card.querySelector('.like-button');
                const commentButton = card.querySelector('.comment-button');
                const saveButton = card.querySelector('.save-button');
                const commentsSection = card.querySelector('.post-comments-section');

                if (likeButton) { likeButton.addEventListener('click', () => { likeButton.classList.toggle('active'); playSound(document.getElementById('audio-like')); }); }
                if (commentButton && commentsSection) { commentButton.addEventListener('click', () => { commentsSection.classList.toggle('open'); playSound(audioClick); }); }
                if (saveButton) { saveButton.addEventListener('click', () => { saveButton.classList.toggle('active'); playSound(audioClick); }); }
            });

            // Texto Cinético
            document.querySelectorAll('.kinetic-text').forEach(text => {
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
            
            // Sistema de Partículas
            const canvas = document.getElementById('particle-canvas');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                let particles = [];
                window.addEventListener('mousemove', (e) => {
                    const mouse = { x: e.x, y: e.y };
                    particles.forEach(p => {
                        const dx = mouse.x - p.x;
                        const dy = mouse.y - p.y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        if (distance < 100) {
                            const force = (100 - distance) / 100;
                            p.x -= (dx / distance) * force * 0.5;
                            p.y -= (dy / distance) * force * 0.5;
                        }
                    });
                });
                class Particle {
                    constructor() {
                        this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 0.4 + 0.1;
                        this.speedX = Math.random() * 0.5 - 0.25; this.speedY = Math.random() * 0.5 - 0.25;
                        this.color = `hsla(var(--c-accent-h), var(--c-accent-s), 80%, 0.7)`;
                    }
                    update() {
                        this.x += this.speedX; this.y += this.speedY;
                        if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                        if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
                    }
                    draw() {
                        ctx.fillStyle = this.color;
                        ctx.beginPath(); ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2); ctx.fill();
                    }
                }
                function initParticles() {
                    particles = [];
                    const particleCount = Math.floor(canvas.width / 50);
                    for (let i = 0; i < particleCount; i++) { particles.push(new Particle()); }
                }
                function animateParticles() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    particles.forEach(p => { p.update(); p.draw(); });
                    requestAnimationFrame(animateParticles);
                }
                initParticles(); animateParticles();
                window.addEventListener('resize', () => { canvas.width = window.innerWidth; canvas.height = window.innerHeight; initParticles(); });
            }
        }
    });
    </script>
</body>
</html>