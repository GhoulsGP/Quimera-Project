<?php 
    // ARCHIVO: inicio.php (Edición Sorpresa)

    // 1. Incluimos la cabecera (nuestro marco)
    include 'plantilla_quimera.php';
    
    // 2. Definimos los datos de prueba para esta página
    $stories = [
        ['avatar' => 'https://randomuser.me/api/portraits/women/65.jpg', 'nombre' => 'Ana'],
        ['avatar' => 'https://randomuser.me/api/portraits/men/32.jpg', 'nombre' => 'Carlos'],
        ['avatar' => 'https://randomuser.me/api/portraits/women/44.jpg', 'nombre' => 'Beatriz'],
    ];
    $posts = [
        [
            'autor_nombre' => 'Elena Codes', 'autor_avatar' => 'https://randomuser.me/api/portraits/women/26.jpg', 'tiempo' => 'Hace 5 min',
            'contenido' => 'Jugando con los nuevos efectos de #QuimeraProject. La web se siente viva.',
            'imagen' => 'https://images.unsplash.com/photo-1555949963-ff98c8726514?q=80&w=2070&auto=format&fit=crop',
            'likes' => 124, 'comentarios' => 12,
        ],
        [
            'autor_nombre' => 'Carlos Dev', 'autor_avatar' => 'https://randomuser.me/api/portraits/men/32.jpg', 'tiempo' => 'Hace 1 hora',
            'contenido' => 'El efecto de texto cinético es una locura. #CSS #JavaScript',
            'imagen' => null,
            'likes' => 89, 'comentarios' => 23,
        ],
    ];
    $tendencias = ['#QuimeraProject', '#NextGenUI', '#CreativeCoding', '#UXMagic', '#FutureWeb'];
?>

<style>
    .home-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 32px;
        align-items: flex-start;
    }
    .main-feed, .sidebar {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }
    .animated-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .animated-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* --- INOVACIÓN 1: CRISTAL LÍQUIDO - EFECTO "RIPPLE" --- */
    .post-card {
        position: relative;
        overflow: hidden;
        background: var(--c-glass-bg);
        backdrop-filter: blur(var(--blur-light, 16px));
        border: 1px solid var(--c-glass-border);
        border-radius: var(--radius-lg);
        padding: 24px;
    }
    .post-card::before {
        content: '';
        position: absolute;
        left: var(--ripple-x); 
        top: var(--ripple-y);
        width: 0;
        height: 0;
        background: radial-gradient(circle, hsla(0,0%,100%,0.2) 0%, transparent 80%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.7s, height 0.7s;
        opacity: 0;
    }
    .post-card:hover::before {
        width: 400px;
        height: 400px;
        opacity: 1;
        transition: width 0.7s, height 0.7s, opacity 0.7s;
    }

    /* --- INOVACIÓN 2: ICONOS CON "LATIDO" --- */
    .like-button:hover .heart-icon {
        animation: heart-beat 0.8s ease-in-out infinite;
    }
    @keyframes heart-beat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    .action-button {
        background: none;
        border: none;
        color: var(--c-text-secondary);
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-weight: 600;
    }
    .post-actions { display: flex; gap: 24px; }
    .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--c-glass-border); padding-top: 16px; margin-top: 16px;}
    .post-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; }
    .post-content { line-height: 1.6; }
    .post-content a { color: var(--c-accent); text-decoration: none; font-weight: 600; }
    .post-image { width: 100%; border-radius: var(--radius-md); margin-top: 16px; }


    /* --- INOVACIÓN 3: TEXTO CINÉTICO - LETRAS QUE DANZAN --- */
    .kinetic-text-container a { 
        color: var(--c-text-secondary);
        text-decoration: none;
        font-weight: 600; 
        display: inline-block;
    }
    .kinetic-text-container a:hover .char {
        animation: kinetic-scramble 0.8s ease-out forwards;
    }
    .char {
        display: inline-block;
    }
    @keyframes kinetic-scramble {
        0% { transform: translate(0,0) rotate(0); opacity: 1; }
        50% { transform: translate(var(--dx), var(--dy)) rotate(var(--r)); opacity: 0.5; }
        100% { transform: translate(0,0) rotate(0); opacity: 1; }
    }

    /* Estilos adicionales para stories y tendencias */
    .stories-container, .trends-container {
        background: var(--c-glass-bg); backdrop-filter: blur(var(--blur-light, 16px));
        border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 16px;
    }
    .stories-scroll { display: flex; gap: 16px; overflow-x: auto; }
    .stories-scroll::-webkit-scrollbar { display: none; }
    .story-item { text-align: center; cursor: pointer; }
    .story-avatar { width: 64px; height: 64px; border-radius: 50%; padding: 3px; background: linear-gradient(45deg, var(--c-accent), hsl(190, 80%, 60%)); }
    .story-avatar img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid var(--c-bg); }
    
    .trends-container h3 { margin-bottom: 16px; }
    .trends-list { list-style: none; display: flex; flex-direction: column; gap: 12px; }

    @media (max-width: 1024px) {
        .home-layout { grid-template-columns: 1fr; }
        .sidebar { display: none; }
    }
</style>

<div class="home-layout">
    <div class="main-feed">
        <section class="stories-container animated-item">
            <div class="stories-scroll">
                <?php foreach ($stories as $story): ?>
                    <div class="story-item">
                        <div class="story-avatar">
                            <img src="<?= htmlspecialchars($story['avatar']) ?>" alt="Avatar">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php foreach ($posts as $post): ?>
            <article class="post-card animated-item">
                <header class="post-header">
                    <img src="<?= htmlspecialchars($post['autor_avatar']) ?>" alt="Avatar" class="post-avatar">
                    <div>
                        <strong><?= htmlspecialchars($post['autor_nombre']) ?></strong>
                        <div style="font-size: 0.8rem; color: var(--c-text-secondary);"><?= htmlspecialchars($post['tiempo']) ?></div>
                    </div>
                </header>
                <div class="post-content">
                    <p><?= preg_replace('/(#[a-zA-Z0-9_]+)/', '<a href="#">$1</a>', htmlspecialchars($post['contenido'])) ?></p>
                </div>
                <?php if (isset($post['imagen']) && $post['imagen']): ?>
                    <img src="<?= htmlspecialchars($post['imagen']) ?>" alt="Imagen del post" class="post-image">
                <?php endif; ?>
                <footer class="post-footer">
                    <div class="post-actions">
                        <button class="action-button like-button">
                             <svg class="heart-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                             <span><?= $post['likes'] ?></span>
                        </button>
                        <button class="action-button">
                             <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10z"></path></svg>
                             <span><?= $post['comentarios'] ?></span>
                        </button>
                    </div>
                </footer>
            </article>
        <?php endforeach; ?>
    </div>

    <aside class="sidebar animated-item">
        <div class="trends-container">
            <h3>Tendencias</h3>
            <ul class="trends-list kinetic-text-container">
                <?php foreach ($tendencias as $tendencia): ?>
                    <li><a href="#" class="kinetic-text"><?= htmlspecialchars($tendencia) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Animaciones de entrada
    const animatedItems = document.querySelectorAll('.animated-item');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('is-visible');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        animatedItems.forEach(item => observer.observe(item));
    } else {
        animatedItems.forEach(item => item.classList.add('is-visible'));
    }

    // Script para Cristal Líquido
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
        const originalText = text.textContent;
        const letters = originalText.split('').map(letter => `<span class="char">${letter}</span>`).join('');
        text.innerHTML = letters;
        
        Array.from(text.children).forEach(char => {
            char.style.setProperty('--dx', `${(Math.random() - 0.5) * 20}px`);
            char.style.setProperty('--dy', `${(Math.random() - 0.5) * 20}px`);
            char.style.setProperty('--r', `${(Math.random() - 0.5) * 30}deg`);
        });
    });
});
</script>

<?php
    // Incluimos el pie de página
    include 'pie_quimera.php'; 
?>