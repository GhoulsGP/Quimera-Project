<?php
// ARCHIVO: pie_quimera.php
?>
        </main> </div> <script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- SCRIPT GLOBAL PARA MENÚ Y TEMAS ---
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
                    // Lógica robusta para cambiar clases de tema sin afectar a otras
                    body.classList.remove('theme-aurora', 'theme-dark', 'theme-light');
                    const theme = target.dataset.theme;
                    body.classList.add(theme);
                    
                    themeSwitcher.querySelector('.active')?.classList.remove('active');
                    target.classList.add('active');
                }
            });
        }

        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        // Solo se ejecutan si estamos en una página con la clase '.home-layout'
        if(document.querySelector('.home-layout')) {
            // Animaciones de entrada
            const animatedItems = document.querySelectorAll('.animated-item');
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
                animatedItems.forEach(item => item.classList.add('is-visible'));
            }

            // Script para Cristal Líquido (Ripple)
            const rippleCards = document.querySelectorAll('.post-card');
            rippleCards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    card.style.setProperty('--ripple-x', x + 'px');
                    card.style.setProperty('--ripple-y', y + 'px');
                });
            });

            // Script para Texto Cinético
            const kineticTexts = document.querySelectorAll('.kinetic-text');
            kineticTexts.forEach(text => {
                // Evita que el script se ejecute dos veces en el mismo texto
                if (text.classList.contains('kinetic-processed')) return;

                const originalText = text.textContent;
                const letters = originalText.split('').map(letter => {
                    // Asigna valores aleatorios para la animación a cada letra
                    const dx = (Math.random() - 0.5) * 20;
                    const dy = (Math.random() - 0.5) * 20;
                    const r = (Math.random() - 0.5) * 30;
                    return `<span class="char" style="--dx:${dx}px; --dy:${dy}px; --r:${r}deg;">${letter}</span>`;
                }).join('');
                text.innerHTML = letters;
                text.classList.add('kinetic-processed');
            });

            // Script para Aurora Interactiva
            document.body.addEventListener('click', (e) => {
                // Evita que la aurora reaccione si se hace clic en un botón o enlace
                if (e.target.closest('a, button')) return;

                const blobs = document.querySelectorAll('.aurora-blob');
                blobs.forEach(blob => {
                    blob.style.transition = 'transform 0.5s ease-out';
                    const currentScale = blob.style.transform.match(/scale\(([^)]+)\)/);
                    const scaleValue = currentScale ? parseFloat(currentScale[1]) : 1;
                    blob.style.transform = `scale(${scaleValue * 1.2})`;
                    setTimeout(() => { blob.style.transform = `scale(${scaleValue})`; }, 500);
                });
            });
        }
    });
    </script>
</body>
</html>