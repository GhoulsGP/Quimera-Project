<?php
// ARCHIVO: pie_quimera.php (v3.2)
?>
        </main>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- LÓGICA GLOBAL DE LA PLANTILLA (Estable) ---
        const body = document.body;
        const navToggle = document.getElementById('nav-toggle'); 
        if(navToggle) {
            navToggle.addEventListener('click', (e) => {
                e.preventDefault();
                body.classList.toggle('nav-expanded');
            });
        }
        // ... (resto del script de plantilla, temas, sonido, etc.) ...

        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        if(document.querySelector('.home-layout')) {
            // ... (script de animación de entrada y texto cinético sin cambios) ...

            // --- NUEVO: LÓGICA DE INTERACCIÓN DE TARJETAS ---
            const postCards = document.querySelectorAll('.post-card');
            postCards.forEach(card => {
                const likeButton = card.querySelector('.like-button');
                const commentButton = card.querySelector('.comment-button');
                const saveButton = card.querySelector('.save-button');
                const commentsSection = card.querySelector('.post-comments-section');

                // 1. Botón de Like
                if (likeButton) {
                    likeButton.addEventListener('click', () => {
                        likeButton.classList.toggle('active');
                    });
                }

                // 2. Botón de Comentar (despliega la sección)
                if (commentButton && commentsSection) {
                    commentButton.addEventListener('click', () => {
                        commentButton.classList.toggle('active');
                        commentsSection.classList.toggle('open');
                    });
                }
                
                // 3. Botón de Guardar
                if (saveButton) {
                    saveButton.addEventListener('click', () => {
                        saveButton.classList.toggle('active');
                    });
                }
            });
        }
    });
    </script>
</body>
</html>