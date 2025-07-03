<?php 
    // ARCHIVO: inicio.php (v6.7.3 - Corrección Definitiva de Overflow)

    include 'plantilla_quimera.php';
    
    // Datos de prueba
    $posts = [
        [ 'autor_nombre' => 'Elena Codes', 'type' => 'wide', 'contenido' => 'El layout móvil y los botones de acción han sido corregidos de forma definitiva. Todo funciona y se ve como debería.', 'imagen' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop', 'comments' => [['user' => 'Carlos Dev', 'text' => 'Ahora sí. Impecable.']]],
        [ 'autor_nombre' => 'Ana Design', 'type' => 'vertical', 'contenido' => 'Probando la funcionalidad de comentarios en un post vertical. El hover de lujo está de vuelta y funciona en todos los botones.', 'imagen' => 'https://images.unsplash.com/photo-1511300636412-01634217b4e6?q=80&w=1887&auto=format&fit=crop', 'comments' => [['user' => 'David UX', 'text' => 'Me encanta el efecto de hover.'], ['user' => 'Elena Codes', 'text' => 'Gracias! Fue un detalle importante.']]],
        [ 'autor_nombre' => 'Carlos Dev', 'type' => 'normal', 'contenido' => 'Un post de solo texto.', 'imagen' => null, 'comments' => []],
        [ 'autor_nombre' => 'David UX', 'type' => 'normal', 'contenido' => 'Cada tarjeta se adapta a su contenido sin romper el layout general.', 'imagen' => null, 'comments' => []],
    ];
    $tendencias = ['#QuimeraProject', '#StableBuild', '#FinalFix', '#UX'];
?>

<style>
    .home-layout { display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: flex-start; }
    .feed-container { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; align-items: flex-start; }
    .sidebar { position: sticky; top: 16px; }
    .post-card { display: flex; flex-direction: column; gap: 16px; background: var(--c-glass-bg); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 24px; }
    .post-card[data-type="wide"] { grid-column: 1 / -1; }
    .post-header { display: flex; align-items: center; gap: 12px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
    .post-author-name { font-weight: 600; }
    .post-body .post-content { line-height: 1.6; color: var(--c-text-secondary); }
    .post-image-container { border-radius: var(--radius-md); overflow: hidden; margin-top: 8px; max-height: 550px; }
    .post-image { width: 100%; height: 100%; display: block; object-fit: cover; }
    .post-card[data-type="vertical"] .post-image-container { max-height: 500px; aspect-ratio: 4 / 5; }
    .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--c-glass-border); padding-top: 16px; margin-top: auto; }
    .post-actions-main { display: flex; gap: 8px; }
    .action-button { position: relative; display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; background: transparent; border: none; color: var(--c-text-secondary); cursor: pointer; transition: color var(--transition-fast) ease; }
    .action-button svg { width: 22px; height: 22px; stroke: currentColor; stroke-width: 2; fill: none; transition: transform 0.3s ease; z-index: 2; }
    .action-button::before, .action-button::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 50%; transition: all 0.4s ease; }
    .action-button::before { background: hsla(0, 0%, 100%, 0.1); opacity: 0; transform: scale(0.8); }
    .action-button::after { background: radial-gradient(circle, hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.5) 0%, transparent 70%); opacity: 0; transform: scale(0.5); filter: blur(8px); }
    .action-button:hover { color: var(--c-text); }
    .action-button:hover svg { transform: scale(1.1); }
    .action-button:hover::before { opacity: 1; transform: scale(1); }
    .action-button:hover::after { opacity: 1; transform: scale(1.2); }
    .action-button.active { color: var(--c-accent); }
    .action-button.active svg { fill: var(--c-accent); }
    .post-comments-section { max-height: 0; overflow: hidden; transition: all .5s ease-in-out; opacity: 0; border-top: 1px solid var(--c-glass-border); }
    .post-comments-section.open { max-height: 500px; margin-top: 16px; padding-top: 16px; padding-bottom: 16px; opacity: 1; }
    .comments-wrapper { display: flex; flex-direction: column; gap: 16px; height: 100%; }
    .comments-list { overflow-y: auto; flex-grow: 1; padding-right: 8px; margin-right: -8px; }
    .comment { display: flex; align-items: flex-start; gap: 12px; padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid var(--c-glass-border); font-size: 0.9rem; line-height: 1.5; }
    .comments-list .comment:last-child { border-bottom: none; margin-bottom: 0; }
    .comment-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .comment-author { font-weight: 600; color: var(--c-text); display: block; margin-bottom: 2px; }
    .comment-text { color: var(--c-text-secondary); }
    .comment-form { display: flex; align-items: center; gap: 12px; flex-shrink: 0; padding-top: 16px; border-top: 1px solid var(--c-glass-border); }
    .current-user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
    .comment-input { flex-grow: 1; min-width: 0; background: hsla(0,0%,100%,0.05); border: 1px solid var(--c-glass-border); border-radius: 16px; padding: 10px 16px; color: var(--c-text); font-size: 0.9rem; outline: none; transition: all var(--transition-fast) ease; }
    .comment-input::placeholder { color: var(--c-text-secondary); opacity: 0.8; }
    .comment-input:focus { border-color: var(--c-accent); box-shadow: 0 0 0 3px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.3); }
    .comment-submit-button { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: var(--c-accent); border: none; border-radius: 50%; color: var(--c-accent-text); cursor: pointer; flex-shrink: 0; transition: all var(--transition-fast) ease; }
    .comment-submit-button:hover { transform: scale(1.05); box-shadow: 0 4px 12px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.4); }
    .comment-submit-button svg { width: 18px; height: 18px; }
    .trends-container { background: var(--c-glass-bg); border-radius: var(--radius-lg); padding: 24px; }
    .trends-container h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 10px; }
    .trends-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 16px; }
    .trends-list a { color: var(--c-text-secondary); text-decoration: none; font-weight: 500; display: inline-block; }
    .kinetic-text:hover .char { animation: kinetic-scramble 0.8s ease-out forwards; }
    .char { display: inline-block; }
    @keyframes kinetic-scramble { 0%{transform:translate(0,0)} 50%{transform:translate(var(--dx),var(--dy)) rotate(var(--r))} 100%{transform:translate(0,0)} }

    @media (max-width: 1024px) {
        .home-layout { grid-template-columns: 1fr; }
        .sidebar { display: none; }
        .feed-container { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .post-card[data-type="wide"] { grid-column: 1 / -1; }
        .post-card {
            padding: 12px;
        }
        .post-avatar {
            width: 40px;
            height: 40px;
        }
        .action-button {
            width: 40px;
            height: 40px;
        }
        .action-button svg {
            width: 20px;
            height: 20px;
        }
    }
</style>

<div class="home-layout">
    <div class="feed-container">
        <?php foreach ($posts as $index => $post): ?>
            <article class="post-card" data-type="<?php echo htmlspecialchars($post['type']); ?>">
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
                        <button class="action-button like-button" title="Me gusta"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></button>
                        <button class="action-button comment-button" title="Comentar"><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10z"></path></svg></button>
                    </div>
                    <div class="post-actions-secondary">
                        <button class="action-button save-button" title="Guardar"><svg viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg></button>
                    </div>
                </footer>
                <section class="post-comments-section">
                    <div class="comments-wrapper">
                        <div class="comments-list">
                            <?php if (!empty($post['comments'])): ?>
                                <?php foreach ($post['comments'] as $comment): ?>
                                    <div class="comment">
                                        <img src="https://randomuser.me/api/portraits/lego/<?php echo rand(0, 8); ?>.jpg" alt="Avatar de usuario" class="comment-avatar">
                                        <div class="comment-content">
                                            <span class="comment-author"><?php echo htmlspecialchars($comment['user']); ?></span>
                                            <span class="comment-text"><?php echo htmlspecialchars($comment['text']); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <form class="comment-form" action="#" method="POST" onsubmit="event.preventDefault();">
                            <img src="https://randomuser.me/api/portraits/men/11.jpg" alt="Tu Avatar" class="current-user-avatar">
                            <input type="text" class="comment-input" placeholder="Escribe un comentario...">
                            <button type="submit" class="comment-submit-button" title="Publicar comentario">
                                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
                            </button>
                        </form>
                    </div>
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