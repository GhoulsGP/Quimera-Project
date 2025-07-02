<?php 
    // FASE 1: Front-end con datos de prueba.
    // Más adelante, estos datos vendrán de tu base de datos.
    $stories = [
        ['avatar' => 'https://randomuser.me/api/portraits/women/65.jpg', 'nombre' => 'Ana'],
        ['avatar' => 'https://randomuser.me/api/portraits/men/32.jpg', 'nombre' => 'Carlos'],
        ['avatar' => 'https://randomuser.me/api/portraits/women/44.jpg', 'nombre' => 'Beatriz'],
        ['avatar' => 'https://randomuser.me/api/portraits/men/45.jpg', 'nombre' => 'David'],
        ['avatar' => 'https://randomuser.me/api/portraits/women/26.jpg', 'nombre' => 'Elena'],
        ['avatar' => 'https://randomuser.me/api/portraits/men/75.jpg', 'nombre' => 'Fernando'],
        ['avatar' => 'https://randomuser.me/api/portraits/women/88.jpg', 'nombre' => 'Gloria'],
    ];

    $posts = [
        [
            'autor_nombre' => 'Elena Codes',
            'autor_avatar' => 'https://randomuser.me/api/portraits/women/26.jpg',
            'tiempo' => 'Hace 5 minutos',
            'contenido' => '¡Explorando nuevos horizontes con el diseño Quimera! La combinación de cristal y aurora es simplemente de otro nivel. #WebDesign #UIUX #QuimeraProject',
            'imagen' => 'https://images.unsplash.com/photo-1555949963-ff98c8726514?q=80&w=2070&auto=format&fit=crop',
            'likes' => 124,
            'comentarios' => 12,
        ],
        [
            'autor_nombre' => 'Carlos Dev',
            'autor_avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
            'tiempo' => 'Hace 1 hora',
            'contenido' => 'Día productivo de código. A veces, la solución más simple es la más elegante. ¿Alguien más siente esa satisfacción al refactorizar código viejo? #Programming #DeveloperLife',
            'imagen' => null,
            'likes' => 89,
            'comentarios' => 23,
        ],
    ];

    $tendencias = ['#QuimeraProject', '#Tech', '#DesignInspiration', '#FutureIsNow', '#Crypto'];
    
    // Incluimos la cabecera y la navegación de nuestra plantilla
    include 'plantilla_quimera.php'; 
?>

<style>
    .home-layout {
        display: grid;
        grid-template-columns: 1fr 320px; /* Columna principal y sidebar */
        gap: 32px;
        align-items: flex-start;
    }
    .main-feed { display: flex; flex-direction: column; gap: 32px; }
    .sidebar { position: sticky; top: 16px; }

    /* 1. Sistema de Stories */
    .stories-container {
        background: var(--c-glass-bg);
        backdrop-filter: blur(var(--blur-light));
        border: 1px solid var(--c-glass-border);
        border-radius: var(--radius-lg);
        padding: 16px;
    }
    .stories-scroll {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        -ms-overflow-style: none; /* IE and Edge */
        scrollbar-width: none; /* Firefox */
    }
    .stories-scroll::-webkit-scrollbar { display: none; } /* Chrome, Safari, Opera */
    
    .story-item { text-align: center; cursor: pointer; }
    .story-avatar {
        width: 64px; height: 64px; border-radius: 50%;
        padding: 3px;
        background: linear-gradient(45deg, var(--c-accent), hsl(190, 80%, 60%));
        margin-bottom: 8px;
        transition: transform var(--transition-fast) ease;
    }
    .story-avatar img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 2px solid var(--c-bg); }
    .story-item:hover .story-avatar { transform: scale(1.1); }
    .story-name { font-size: 0.8rem; font-weight: 500; color: var(--c-text-secondary); }

    /* 2. Crear Publicación */
    .create-post-box {
        display: flex; align-items: center; gap: 16px;
        background: var(--c-glass-bg);
        backdrop-filter: blur(var(--blur-light));
        border: 1px solid var(--c-glass-border);
        border-radius: var(--radius-lg);
        padding: 16px 24px;
        cursor: pointer;
        transition: all var(--transition-fast) ease;
    }
    .create-post-box:hover { border-color: var(--c-glass-border-hover); }
    .create-post-avatar { width: 48px; height: 48px; border-radius: 50%; }
    .create-post-input {
        flex-grow: 1;
        background: transparent;
        border: none;
        color: var(--c-text-secondary);
        font-size: 1.1rem;
        font-weight: 500;
        outline: none;
    }

    /* 3. Feed y Tarjetas de Post */
    .post-card {
        background: var(--c-glass-bg);
        backdrop-filter: blur(var(--blur-light));
        border: 1px solid var(--c-glass-border);
        border-radius: var(--radius-lg);
        padding: 24px;
    }
    .post-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; }
    .post-author-info { font-weight: 600; }
    .post-author-info span { font-size: 0.8rem; color: var(--c-text-secondary); font-weight: 400; }
    .post-content { margin-bottom: 16px; line-height: 1.6; }
    .post-content a { color: var(--c-accent); text-decoration: none; font-weight: 600; }
    .post-image { width: 100%; border-radius: var(--radius-md); margin-bottom: 16px; }
    .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--c-glass-border); padding-top: 16px; }
    .post-actions { display: flex; gap: 24px; }
    .action-button { background: none; border: none; color: var(--c-text-secondary); display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: color var(--transition-fast), transform var(--transition-fast); }
    .action-button:hover { color: var(--c-accent); transform: scale(1.05); }
    .action-button.active { color: var(--c-accent); }
    .action-button svg { width: 22px; height: 22px; stroke-width: 2; }
    .action-button.active .heart-icon { fill: var(--c-accent); stroke: var(--c-accent); }
    .action-button.active .save-icon { fill: var(--c-accent); stroke: var(--c-accent); }

    /* 4. Barra de Tendencias */
    .trends-container {
        background: var(--c-glass-bg);
        backdrop-filter: blur(var(--blur-light));
        border: 1px solid var(--c-glass-border);
        border-radius: var(--radius-lg);
        padding: 24px;
    }
    .trends-container h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 8px; }
    .trends-list { list-style: none; display: flex; flex-direction: column; gap: 12px; }
    .trends-list a { color: var(--c-text-secondary); text-decoration: none; font-weight: 600; transition: color var(--transition-fast); }
    .trends-list a:hover { color: var(--c-accent); }
    
    @media (max-width: 1024px) {
        .home-layout { grid-template-columns: 1fr; }
        .sidebar { display: none; } /* Ocultamos la sidebar en pantallas más pequeñas */
    }
</style>

<div class="home-layout">
    <div class="main-feed">
        <section class="stories-container">
            <div class="stories-scroll">
                <?php foreach ($stories as $story): ?>
                    <div class="story-item">
                        <div class="story-avatar">
                            <img src="<?= htmlspecialchars($story['avatar']) ?>" alt="Avatar de <?= htmlspecialchars($story['nombre']) ?>">
                        </div>
                        <span class="story-name"><?= htmlspecialchars($story['nombre']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="create-post-box">
            <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="Tu avatar" class="create-post-avatar">
            <div class="create-post-input">Crea una nueva publicación...</div>
        </section>

        <?php foreach ($posts as $post): ?>
            <article class="post-card">
                <header class="post-header">
                    <img src="<?= htmlspecialchars($post['autor_avatar']) ?>" alt="Avatar del autor" class="post-avatar">
                    <div>
                        <div class="post-author-info"><?= htmlspecialchars($post['autor_nombre']) ?></div>
                        <span><?= htmlspecialchars($post['tiempo']) ?></span>
                    </div>
                </header>
                <div class="post-content">
                    <p><?= preg_replace('/(#[a-zA-Z0-9_]+)/', '<a href="#">$1</a>', htmlspecialchars($post['contenido'])) ?></p>
                </div>
                <?php if ($post['imagen']): ?>
                    <img src="<?= htmlspecialchars($post['imagen']) ?>" alt="Imagen del post" class="post-image">
                <?php endif; ?>
                <footer class="post-footer">
                    <div class="post-actions">
                        <button class="action-button like-button">
                            <svg class="heart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            <span><?= $post['likes'] ?></span>
                        </button>
                        <button class="action-button">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10z"></path></svg>
                            <span><?= $post['comentarios'] ?></span>
                        </button>
                    </div>
                    <button class="action-button save-button">
                        <svg class="save-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                        <span>Guardar</span>
                    </button>
                </footer>
            </article>
        <?php endforeach; ?>
    </div>

    <aside class="sidebar">
        <div class="trends-container">
            <h3>Tendencias</h3>
            <ul class="trends-list">
                <?php foreach ($tendencias as $tendencia): ?>
                    <li><a href="#"><?= htmlspecialchars($tendencia) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Lógica para botones de Like y Guardar
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', (e) => {
            const currentButton = e.currentTarget;
            if (currentButton.classList.contains('like-button') || currentButton.classList.contains('save-button')) {
                currentButton.classList.toggle('active');
            }
        });
    });
});
</script>

<?php 
    // Incluimos el pie de página de nuestra plantilla
    include 'pie_quimera.php'; 
?>