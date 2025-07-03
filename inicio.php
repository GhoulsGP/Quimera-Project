<?php 
    // ARCHIVO: inicio.php (v4.3 - Hover de Lujo Restaurado)

    include 'plantilla_quimera.php';
    
    // Datos de prueba
    $posts = [
        [ 
            'autor_nombre' => 'Elena Codes', 'type' => 'wide', 'contenido' => 'El hover de lujo de 3 capas en los botones está de vuelta. Funcional y elegante.', 'imagen' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop',
            'comments' => [
                ['user' => 'Carlos Dev', 'text' => 'Confirmado, todo vuelve a funcionar. Excelente.'],
            ]
        ],
        [ 
            'autor_nombre' => 'Ana Design', 'type' => 'vertical', 'contenido' => 'El texto cinético, los temas y el sonido funcionan a la perfección junto a las nuevas animaciones.', 'imagen' => 'https://images.unsplash.com/photo-1511300636412-01634217b4e6?q=80&w=1887&auto=format&fit=crop',
            'comments' => []
        ],
    ];
    $tendencias = ['#QuimeraProject', '#InteractiveUI', '#UX', '#FutureWeb'];
?>

<style>
    /* Estructura Principal y Layout */
    .home-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: flex-start; }
    .sidebar { position: sticky; top: 16px; }
    .feed-container { column-count: 2; column-gap: 24px; }
    .post-card { margin-bottom: 24px; break-inside: avoid; width: 100%; display: flex; flex-direction: column; gap: 16px; background: var(--c-glass-bg); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px; }
    .post-card.post-type-wide { column-span: all; }
    .post-header { display: flex; align-items: center; gap: 12px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
    .post-author-name { font-weight: 600; }
    .post-body .post-content { line-height: 1.6; color: var(--c-text-secondary); }
    .post-image-container { border-radius: var(--radius-md); overflow: hidden; margin-top: 8px; }
    .post-image { width: 100%; display: block; }
    .post-type-vertical .post-image { max-height: 500px; width: auto; margin: 0 auto; }
    .post-type-wide .post-image-container { max-height: 450px; }
    
    /* --- HOVER DE LUJO EN BOTONES (RESTAURADO Y VERIFICADO) --- */
    .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--c-glass-border); padding-top: 16px; margin-top: auto; }
    .post-actions-main { display: flex; gap: 8px; }
    .action-button {
        position: relative; display: flex; align-items: center; justify-content: center;
        width: 44px; height: 44px; background: transparent; border: none;
        color: var(--c-text-secondary); cursor: pointer; transition: color var(--transition-fast) ease;
    }
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
    
    /* --- SECCIÓN DE COMENTARIOS (RESPONSIVA) --- */
    .post-comments-section { max-height: 0; overflow: hidden; transition: max-height 0.5s ease-in-out, margin-top 0.5s ease-in-out, opacity 0.5s ease-in-out; opacity: 0; border-top: 1px solid var(--c-glass-border); }
    .post-comments-section.open { max-height: 500px; margin-top: 16px; padding-top: 16px; opacity: 1; }
    .comment { display: flex; gap: 12px; margin-bottom: 16px; align-items: flex-start; }
    .comment-avatar { width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0; }
    .comment-body { background: rgba(0,0,0,0.15); padding: 8px 12px; border-radius: var(--radius-md); width: 100%; }
    .comment-user { font-weight: 600; font-size: 0.9rem; }
    .comment-text { font-size: 0.9rem; color: var(--c-text-secondary); word-break: break-word; }
    .comment-form { display: flex; gap: 12px; align-items: center; margin-top: 16px; }
    .comment-input { flex-grow: 1; background: rgba(0,0,0,0.2); border: 1px solid var(--c-glass-border); border-radius: 99px; padding: 10px 16px; color: var(--c-text); font-size: 0.9rem; outline: none; transition: border-color var(--transition-fast); }
    .comment-input:focus { border-color: var(--c-accent); }
    .comment-send-btn { background: var(--c-accent); border: none; border-radius: 50%; width: 40px; height: 40px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: transform 0.2s; }
    .comment-send-btn:hover { transform: scale(1.1); }
    .comment-send-btn svg { stroke: var(--c-accent-text); width: 18px; height: 18px; }

    /* --- TENDENCIAS Y TEXTO CINÉTICO (VERIFICADO) --- */
    .trends-container { background: var(--c-glass-bg); border-radius: var(--radius-lg); padding: 24px; }
    .trends-container h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 10px; }
    .trends-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 16px; }
    .trends-list a { color: var(--c-text-secondary); text-decoration: none; font-weight: 500; display: inline-block; }
    .trends-list a:hover .char { animation: kinetic-scramble 0.8s ease-out forwards; }
    .char { display: inline-block; }
    @keyframes kinetic-scramble { 0%{transform:translate(0,0)} 50%{transform:translate(var(--dx),var(--dy)) rotate(var(--r))} 100%{transform:translate(0,0)} }
    
    @media (max-width: 1024px) { .home-layout { grid-template-columns: 1fr; } .sidebar { display: none; } }
    @media (max-width: 768px) { .feed-container { column-count: 1; } }
    @media (max-width: 480px) { main.content-area { padding: 16px; } .post-card { padding: 16px; } }
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
                    <?php endif; ?>
                    <form class="comment-form">
                        <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="Tu avatar" class="comment-avatar">
                        <input type="text" class="comment-input" placeholder="Añade un comentario...">
                        <button type="submit" class="comment-send-btn" title="Enviar"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 2L11 13"></path><path d="M22 2L15 22l-4-9-9-4 21-5z"></path></svg></button>
                    </form>
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