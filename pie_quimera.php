<?php
// ARCHIVO: pie_quimera.php (v2.3 - Solución CSS Columns)
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
        // ... (resto del script de la plantilla que es estable y correcto) ...

        // --- SCRIPTS ESPECÍFICOS DE LA PÁGINA DE INICIO ---
        if(document.querySelector('.home-layout')) {

            // EL SCRIPT DE MASONRY HA SIDO ELIMINADO. LA MAQUETACIÓN AHORA SE CONTROLA 100% CON CSS.

            // --- RESTAURADO Y VERIFICADO: SCRIPT DE TEXTO CINÉTICO ---
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