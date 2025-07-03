<?php
// ARCHIVO: pie_quimera.php (v6.0 - Definitiva)
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

            // --- LÓGICA DE INTERACCIÓN DE TARJETAS (RESTAURADA Y VERIFICADA) ---
            document.querySelectorAll('.post-card').forEach(card => {
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
            });

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