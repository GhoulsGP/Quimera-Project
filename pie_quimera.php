</main> </div> <script>
document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const navToggle = document.getElementById('nav-toggle');

    // Lógica para expandir/colapsar la navegación
    navToggle.addEventListener('click', () => {
        body.classList.toggle('nav-expanded');
    });

    // Lógica del cambiador de temas (mejorada)
    const themeSwitcher = document.getElementById('theme-switcher');
    themeSwitcher.addEventListener('click', (e) => {
        const target = e.target.closest('.theme-button');
        if (target) {
            const theme = target.dataset.theme;
            body.className = body.classList.contains('nav-expanded') 
                ? `theme-${theme.split('-')[1]} nav-expanded` 
                : `theme-${theme.split('-')[1]}`;

            themeSwitcher.querySelector('.active').classList.remove('active');
            target.classList.add('active');
        }
    });
});
</script>
</body>
</html>