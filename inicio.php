<?php 
    // ARCHIVO: inicio.php (v3.1 - Botones de Lujo)

    include 'plantilla_quimera.php';
    
    $posts = [
        [ 'autor_nombre' => 'Elena Codes', 'type' => 'wide', 'contenido' => 'Este post es ancho y ahora, con column-span, ocupa todo el espacio horizontal antes de que el contenido continúe fluyendo debajo en dos columnas. Es una solución robusta.', 'imagen' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop'],
        [ 'autor_nombre' => 'Ana Design', 'type' => 'vertical', 'contenido' => 'Las imágenes verticales ahora encuentran su lugar en el flujo natural del layout de columnas. La altura de la tarjeta se adapta perfectamente.', 'imagen' => 'https://images.unsplash.com/photo-1511300636412-01634217b4e6?q=80&w=1887&auto=format&fit=crop'],
        [ 'autor_nombre' => 'Carlos Dev', 'type' => 'normal', 'contenido' => 'Un post de solo texto, que fluye en la primera columna disponible.', 'imagen' => null],
        [ 'autor_nombre' => 'David UX', 'type' => 'normal', 'contenido' => 'El layout de columnas es la técnica ideal para este tipo de contenido dinámico, evitando los huecos que generaba el grid anterior.', 'imagen' => null],
    ];
    $tendencias = ['#QuimeraProject', '#LayoutFix', '#CSSColumns', '#RobustDesign', '#FutureWeb'];
?>

<style>
    /* --- ESTRUCTURA PRINCIPAL (Estable) --- */
    .home-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: flex-start; }
    .sidebar { position: sticky; top: 16px; }
    .feed-container { column-count: 2; column-gap: 24px; }
    .post-card { margin-bottom: 24px; break-inside: avoid; width: 100%; }
    .post-card.post-type-wide { column-span: all; }

    /* --- ESTILOS DE TARJETA (Estables) --- */
    .post-card { display: flex; flex-direction: column; gap: 16px; background: var(--c-glass-bg); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px; }
    .post-header { display: flex; align-items: center; gap: 12px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
    .post-author-name { font-weight: 600; }
    .post-body .post-content { line-height: 1.6; color: var(--c-text-secondary); }
    .post-image-container { border-radius: var(--radius-md); overflow: hidden; margin-top: 8px; }
    .post-image { width: 100%; display: block; }
    .post-type-vertical .post-image { max-height: 500px; width: auto; margin: 0 auto; }
    .post-type-wide .post-image-container { max-height: 450px; }

    /* --- BOTONES DE ACCIÓN DE LUJO (NUEVO) --- */
    .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--c-glass-border); padding-top: 16px; margin-top: auto; }
    .post-actions-main { display: flex; gap: 8px; }
    .action-button {
        position: relative;
        display: flex; align-items: center; justify-content: center;
        width: 40px; height: 40px;
        background: transparent; border: none;
        color: var(--c-text-secondary);
        cursor: pointer;
        transition: color var(--transition-fast) ease;
    }
    .action-button svg {
        width: 22px; height: 22px;
        stroke: currentColor; stroke-width: 2;
        transition: transform 0.3s ease;
        z-index: 2;
    }
    .action-button::before, .action-button::after {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        border-radius: 50%;
        transition: all 0.4s ease;
    }
    .action-button::before { /* Capa de fondo */
        background: hsla(0, 0%, 100%, 0.1);
        opacity: 0;
        transform: scale(0.8);
    }
    .action-button::after { /* Capa de brillo */
        background: radial-gradient(circle, hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.5) 0%, transparent 70%);
        opacity: 0;
        transform: scale(0.5);
        filter: blur(8px);
    }
    .action-button:hover { color: var(--c-accent); }
    .action-button:hover svg { transform: scale(1.1); }
    .action-button:hover::before { opacity: 1; transform: scale(1); }
    .action-button:hover::after { opacity: 1; transform: scale(1.2); }
    .like-button.liked svg { stroke: var(--c-accent); fill: var(--c-accent); }

    /* --- TENDENCIAS Y TEXTO CINÉTICO (Estilos Restaurados) --- */
    .trends-container { background: var(--c-glass-bg); border-radius: var(--radius-lg); padding: 24px; }
    .trends-container h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 10px; }
    .trends-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 16px; }
    .trends-list a { color: var(--c-text-secondary); text-decoration: none; font-weight: 500; display: inline-block; }
    .trends-list a:hover .char { animation: kinetic-scramble 0.8s ease-out forwards; }
    .char { display: inline-block; }
    @keyframes kinetic-scramble { 0%{transform:translate(0,0)} 50%{transform:translate(var(--dx),var(--dy)) rotate(var(--r))} 100%{transform:translate(0,0)} }

    /* --- RESPONSIVE --- */
    @media (max-width: 1024px) { .home-layout { grid-template-columns: 1fr; } .sidebar { display: none; } }
    @media (max-width: 768px) { .feed-container { column-count: 1; } }
</style>

<div class="home-layout">
    <div class="feed-container">
        <?php foreach ($posts as $index => $post): ?>
            <article class="post-card post-type-<?php echo $post['type']; ?>">
                <header class="post-header">
                     <img src="https://randomuser.me/api/portraits/lego/<?php echo $index; ?>.jpg" alt="Avatar" class="post-avatar">
                     <span class="post-author-name"><?php echo htmlspecialchars($post['autor_nombre']); ?></span>
                </header>
                <div class="post-body">
                    <p class="post-content"><?php echo htmlspecialchars($post['contenido']); ?></p>
                    <?php if ($post['imagen']): ?>
                        <div class="post-image-container">
                            <img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="Imagen del post" class="post-image">
                        </div>
                    <?php endif; ?>
                </div>
                <footer class="post-footer">
                    <div class="post-actions-main">
                        <button class="action-button like-button" title="Me gusta">
                            <svg fill="none" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                        <button class="action-button" title="Comentar">
                            <svg fill="none" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10z"></path></svg>
                        </button>
                    </div>
                    <div class="post-actions-secondary">
                        <button class="action-button" title="Guardar">
                            <svg fill="none" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                        </button>
                    </div>
                </footer>
            </article>
        <?php endforeach; ?>
    </div>

    <aside class="sidebar">
        <div class="trends-container">
            <h3>Tendencias</h3>
            <ul class="trends-list kinetic-text-container">
                <?php foreach ($tendencias as $tendencia): ?>
                    <li><a href="#" class="kinetic-text"><?php echo htmlspecialchars($tendencia); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </aside>
</div>

<?php
    include 'pie_quimera.php'; 
?>