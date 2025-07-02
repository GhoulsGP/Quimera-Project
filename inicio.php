<?php 
    // ARCHIVO: inicio.php (v1.7 - Corrección Definitiva)

    include 'plantilla_quimera.php';
    
    // Datos de prueba
    $posts = [
        [ 'autor_nombre' => 'Elena Codes', 'type' => 'wide', 'contenido' => 'Este post es ancho porque tiene una imagen destacada.', 'imagen' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop'],
        [ 'autor_nombre' => 'Carlos Dev', 'type' => 'normal', 'contenido' => 'Un post de solo texto, más compacto.', 'imagen' => null],
        [ 'autor_nombre' => 'Ana Design', 'type' => 'vertical', 'contenido' => 'Ahora los posts con imágenes verticales no son tan gigantes y quedan mucho mejor.', 'imagen' => 'https://images.unsplash.com/photo-1511300636412-01634217b4e6?q=80&w=1887&auto=format&fit=crop'],
    ];
    $tendencias = ['#QuimeraProject', '#NextGenUI', '#CreativeCoding', '#UXMagic', '#FutureWeb'];
?>

<style>
    /* Estilos específicos de la página de inicio */
    .home-layout {
        display: grid;
        grid-template-columns: repeat(2, 1fr) 320px;
        gap: 32px;
        align-items: flex-start;
    }

    /* Tarjeta para Crear Publicación */
    #create-post-card {
        grid-column: 1 / 3;
        background: var(--c-glass-bg);
        backdrop-filter: blur(var(--blur-light, 16px));
        border: 1px solid var(--c-glass-border);
        border-radius: var(--radius-lg);
        padding: 24px;
        transition: all 0.4s ease;
        cursor: pointer;
    }
    #create-post-card:hover { border-color: var(--c-glass-border-hover); }
    #create-post-card.expanded { cursor: default; }
    .create-post-compact { display: flex; align-items: center; gap: 16px; }
    .create-post-avatar { width: 48px; height: 48px; border-radius: 50%; }
    .create-post-placeholder { flex-grow: 1; color: var(--c-text-secondary); font-size: 1.1rem; font-weight: 500; }
    .create-post-expanded-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease-in-out, margin-top 0.5s ease-in-out;
    }
    #create-post-card.expanded .create-post-expanded-content {
        max-height: 300px;
        margin-top: 24px;
    }
    .create-post-textarea {
        width: 100%; min-height: 100px; background: rgba(0,0,0,0.1);
        border: 1px solid transparent; border-radius: var(--radius-md);
        padding: 16px; color: var(--c-text); font-size: 1.1rem;
        resize: vertical; outline: none; transition: border-color var(--transition-fast);
    }
    .create-post-textarea:focus { border-color: var(--c-accent); }
    .create-post-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 16px; }
    .action-icons { display: flex; gap: 16px; }
    .action-icons svg { stroke: var(--c-text-secondary); cursor: pointer; transition: stroke var(--transition-fast); }
    .action-icons svg:hover { stroke: var(--c-accent); }
    .quimera-button {
        padding: 10px 24px; font-weight: 600; cursor: pointer;
        border-radius: var(--radius-sm); border: none; background: var(--c-accent);
        color: var(--c-accent-text); transition: transform 0.2s;
    }
    .quimera-button:hover { transform: scale(1.05); }

    /* Estilos del resto de la página */
    .animated-item {
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .animated-item.prepare-animation {
        opacity: 0;
        transform: translateY(20px);
    }
    .animated-item.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .post-card { grid-column: span 1; }
    .post-card.post-wide { grid-column: span 2; }
    .sidebar { grid-column: 3 / 4; grid-row: 1 / span 20; position: sticky; top: 16px; }
    .post-card.post-vertical { display: flex; flex-direction: row; align-items: center; gap: 20px; }
    .post-vertical .post-image-container { flex: 1 1 40%; height: 250px; }
    .post-vertical .post-image { height: 100%; object-fit: cover; }
    .post-vertical .post-body { flex: 1 1 60%; }
    .trends-container { background: var(--c-glass-bg); backdrop-filter: blur(var(--blur-light, 16px)); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px; }
    .trends-container h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 10px; font-weight: 600;}
    .trends-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 16px; }
    .trends-list a { color: var(--c-text-secondary); text-decoration: none; font-weight: 500; transition: color var(--transition-fast); }
    .trends-list a:hover { color: var(--c-accent); }
    .post-card { transition: all 0.4s ease; background: var(--c-glass-bg); backdrop-filter: blur(var(--blur-light, 16px)); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px; }
    .post-image-container { border-radius: var(--radius-md); overflow: hidden; margin-top: 16px;}
    .post-image { width: 100%; display: block; }
    .post-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; }

    @media (max-width: 1200px) { .home-layout { grid-template-columns: repeat(2, 1fr) 280px; } }
    @media (max-width: 768px) {
        .home-layout { grid-template-columns: 1fr; }
        .post-card.post-wide, .post-card.post-vertical, #create-post-card { grid-column: span 1; }
        .sidebar { display: none; }
        .post-card.post-vertical { flex-direction: column; }
    }
</style>

<div class="home-layout">
    <section id="create-post-card" class="animated-item">
        <div class="create-post-compact">
            <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="Tu avatar" class="create-post-avatar">
            <div class="create-post-placeholder">¿En qué estás pensando, Creador?</div>
        </div>
        <div class="create-post-expanded-content">
            <textarea class="create-post-textarea" placeholder="Desata tu creatividad..."></textarea>
            <div class="create-post-actions">
                <div class="action-icons">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 12.5a2.5 2.5 0 01-2.5 2.5h-14a2.5 2.5 0 01-2.5-2.5v-5a2.5 2.5 0 012.5-2.5h14a2.5 2.5 0 012.5 2.5v5z"></path><path d="M6.5 12.5l3-3a2 2 0 013 0l4 4"></path><circle cx="15.5" cy="8.5" r="1.5"></circle></svg>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0112 2a8 8 0 018 8.2c0 7.3-8 11.8-8 11.8z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <button class="quimera-button">Publicar</button>
            </div>
        </section>

    <?php foreach ($posts as $index => $post): ?>
        <?php
            $post_classes = 'post-card animated-item';
            if ($post['type'] === 'wide') { $post_classes .= ' post-wide'; }
            if ($post['type'] === 'vertical') { $post_classes .= ' post-vertical'; }
        ?>
        <article class="<?php echo $post_classes; ?>">
            <header class="post-header">
                 <img src="https://randomuser.me/api/portraits/lego/<?php echo $index+2; ?>.jpg" alt="Avatar" class="post-avatar">
                 <strong><?php echo htmlspecialchars($post['autor_nombre']); ?></strong>
            </header>
            <div class="post-body">
                <p><?php echo htmlspecialchars($post['contenido']); ?></p>
                <?php if ($post['imagen']): ?>
                    <div class="post-image-container">
                        <img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="Imagen del post" class="post-image">
                    </div>
                <?php endif; ?>
            </div>
        </article>
    <?php endforeach; ?>

    <aside class="sidebar animated-item">
        <div class="trends-container">
            <h3>Tendencias para ti</h3>
            <ul class="trends-list">
                <?php foreach ($tendencias as $tendencia): ?>
                    <li><a href="#"><?php echo htmlspecialchars($tendencia); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
</div>

<?php
    include 'pie_quimera.php'; 
?>