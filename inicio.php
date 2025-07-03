<?php 
    // ARCHIVO: inicio.php (v4.1 - Hover de Lujo Estable)

    include 'plantilla_quimera.php';
    
    // Datos de prueba
    $posts = [
        [ 'autor_nombre' => 'Elena Codes', 'type' => 'wide', 'contenido' => 'El efecto holográfico ha sido eliminado, ahora tenemos un hover más sutil y elegante.', 'imagen' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop', 'comments' => [['user' => 'Test', 'text' => 'Genial!']]],
        [ 'autor_nombre' => 'Ana Design', 'type' => 'vertical', 'contenido' => 'El destello en la imagen y el aura de los botones se han mantenido para una experiencia premium.', 'imagen' => 'https://images.unsplash.com/photo-1511300636412-01634217b4e6?q=80&w=1887&auto=format&fit=crop', 'comments' => []],
        [ 'autor_nombre' => 'Carlos Dev', 'type' => 'normal', 'contenido' => 'Un post de solo texto, que fluye en la primera columna disponible.', 'imagen' => null, 'comments' => []],
    ];
    $tendencias = ['#QuimeraProject', '#StableUX', '#FutureWeb'];
?>

<style>
    .home-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: flex-start; }
    .sidebar { position: sticky; top: 16px; }
    .feed-container { column-count: 2; column-gap: 24px; }
    .post-card { margin-bottom: 24px; break-inside: avoid; width: 100%; }
    .post-card.post-type-wide { column-span: all; }

    .post-card {
        background: var(--c-glass-bg); backdrop-filter: blur(var(--blur-light, 16px));
        border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px;
        position: relative; overflow: hidden;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .post-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    
    .post-image-container {
        position: relative; border-radius: var(--radius-md);
        overflow: hidden; margin-top: 8px;
    }
    .post-image-container::after {
        content: ''; position: absolute; top: 0; left: -150%; width: 70%; height: 100%;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
        transform: skewX(-25deg);
        transition: left 0.8s ease-in-out;
    }
    .post-card:hover .post-image-container::after { left: 150%; }

    .post-card { display: flex; flex-direction: column; gap: 16px; }
    .post-header { display: flex; align-items: center; gap: 12px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
    .post-author-name { font-weight: 600; }
    .post-body .post-content { line-height: 1.6; color: var(--c-text-secondary); }
    .post-image { width: 100%; display: block; }
    .post-type-vertical .post-image { max-height: 500px; width: auto; margin: 0 auto; }
    .post-type-wide .post-image-container { max-height: 450px; }
    
    .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--c-glass-border); padding-top: 16px; margin-top: auto; }
    .post-actions-main { display: flex; gap: 8px; }
    .action-button { position: relative; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; background: transparent; border: none; color: var(--c-text-secondary); cursor: pointer; transition: color var(--transition-fast) ease; }
    .action-button svg { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2; transition: transform 0.3s ease; z-index: 2; }
    .action-button::before, .action-button::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 50%; transition: all 0.4s ease; }
    .action-button::before { background: hsla(0, 0%, 100%, 0.1); opacity: 0; transform: scale(0.8); }
    .action-button::after { background: radial-gradient(circle, hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.5) 0%, transparent 70%); opacity: 0; transform: scale(0.5); filter: blur(8px); }
    .action-button:hover { color: var(--c-text); }
    .action-button:hover svg { transform: scale(1.1); }
    .action-button:hover::before { opacity: 1; transform: scale(1); }
    .action-button:hover::after { opacity: 1; transform: scale(1.2); }
    .action-button.active { color: var(--c-accent); }
    .action-button.active svg { stroke: var(--c-accent); fill: var(--c-accent); }
    
    .post-comments-section { max-height: 0; overflow: hidden; transition: max-height 0.5s ease-in-out, margin-top 0.5s ease-in-out; }
    .post-comments-section.open { max-height: 500px; margin-top: 16px; }
    
    .trends-container { background: var(--c-glass-bg); border-radius: var(--radius-lg); padding: 24px; }
    .trends-container h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 10px; }
    .trends-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 16px; }
    .trends-list a { color: var(--c-text-secondary); text-decoration: none; font-weight: 500; display: inline-block; }
    .kinetic-text-container a:hover .char { animation: kinetic-scramble 0.8s ease-out forwards; }
    .char { display: inline-block; }
    @keyframes kinetic-scramble { 0%{transform:translate(0,0)} 50%{transform:translate(var(--dx),var(--dy)) rotate(var(--r))} 100%{transform:translate(0,0)} }

    @media (max-width: 1024px) { .home-layout { grid-template-columns: 1fr; } .sidebar { display: none; } }
    @media (max-width: 768px) { .feed-container { column-count: 1; } }
</style>

<div class="home-layout">
    <div class="feed-container">
        <?php foreach ($posts as $index => $post): ?>
            <article class="post-card post-type-<?php echo htmlspecialchars($post['type']); ?>">
                <header class="post-header">
                     <img src="https://randomuser.me/api/portraits/lego/<?php echo $index; ?>.jpg" alt="Avatar" class="post-avatar">
                     <span class="post-author-name"><?php echo htmlspecialchars($post['autor_nombre']); ?></span>
                </header>
                <div class="post-body">
                    <p class="post-content"><?php echo htmlspecialchars($post['contenido']); ?></p>
                    <?php if (isset($post['imagen']) && $post['imagen']): ?>
                        <div class="post-image-container">
                            <img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="Imagen del post" class="post-image">
                        </div>
                    <?php endif; ?>
                </div>
                <footer class="post-footer">
                    <div class="post-actions-main">
                        <button class="action-button like-button" title="Me gusta"><svg fill="none" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></button>
                        <button class="action-button comment-button" title="Comentar"><svg fill="none" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10z"></path></svg></button>
                    </div>
                    <div class="post-actions-secondary">
                        <button class="action-button save-button" title="Guardar"><svg fill="none" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg></button>
                    </div>
                </footer>
                <section class="post-comments-section">
                    <?php if (!empty($post['comments'])): ?>
                        <?php foreach ($post['comments'] as $comment): ?>
                            <div class="comment">
                                <img src="https://randomuser.me/api/portraits/thumb/men/75.jpg" alt="Avatar" class="comment-avatar">
                                <div class="comment-body">
                                    <div class="comment-user"><?php echo htmlspecialchars($comment['user']); ?></div>
                                    <p class="comment-text"><?php echo htmlspecialchars($comment['text']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="text-align: center; color: var(--c-text-secondary); font-size: 0.9rem;">No hay comentarios todavía.</p>
                    <?php endif; ?>
                </section>
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