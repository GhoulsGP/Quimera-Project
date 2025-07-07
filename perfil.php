<?php 
    // ARCHIVO: perfil.php (v5.1 - Corrección de Regresión, CSS Integrado)

    include 'plantilla_quimera.php';

    $user = [
        'nombre' => 'Alex Thornton',
        'handle' => '@alex_thornton_ux',
        'avatar' => 'https://randomuser.me/api/portraits/men/75.jpg',
        'cover_image' => 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?q=80&w=2070&auto=format&fit=crop',
        'bio_long' => 'Crafting next-gen digital experiences. Passionate about clean interfaces, user-centric design, and the intersection of technology and art. My goal is to build products that are not only functional but also a joy to use.',
        'stats' => ['posts' => 128, 'followers' => '1.2M', 'following' => 450],
        'posts' => [
            ['type' => 'normal', 'contenido' => 'Exploring new component designs for the Quimera framework. The goal is maximum elegance with zero performance overhead.', 'imagen' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=2070&auto=format&fit=crop', 'comments' => [['user' => 'Elena Codes', 'text' => 'This looks promising!']]],
            ['type' => 'normal', 'contenido' => 'A deep dive into the psychology of user interaction. Fascinating stuff.', 'imagen' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726a?q=80&w=2070&auto=format&fit=crop', 'comments' => []]
        ]
    ];
?>

<style>
    /* === ARQUITECTURA "SPOTLIGHT LAYOUT" (LEGACY v4.0) === */
    @keyframes spotlight-fade-in {
        from { opacity: 0; transform: translateY(30px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .profile-hero {
        position: relative; width: 100%; height: 450px; display: flex; align-items: center;
        overflow: hidden; border-radius: var(--radius-lg);
    }
    .profile-hero-bg {
        position: absolute; top: 0; left: 0; width: 100%; height: 120%;
        object-fit: cover; z-index: 1; filter: brightness(0.7);
    }
    .profile-card-floating {
        position: relative; z-index: 2; margin-left: 5%; padding: 32px; width: 90%; max-width: 500px;
        background: hsla(215, 25%, 15%, 0.6); backdrop-filter: blur(var(--blur-heavy));
        border: 1px solid var(--c-glass-border); border-radius: var(--radius-xl);
        box-shadow: 0 16px 60px hsla(0, 0%, 0%, 0.3);
        opacity: 0; animation: spotlight-fade-in 0.8s 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .floating-card-header { display: flex; align-items: center; gap: 24px; }
    .floating-card-avatar { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid var(--c-glass-border); }
    .floating-card-title h1 { font-size: 2.2rem; font-weight: 800; color: var(--c-text); line-height: 1.2; }
    .floating-card-title .handle { font-size: 1.1rem; color: var(--c-text-secondary); }
    .floating-card-body { margin-top: 24px; }
    .floating-card-body .bio { font-size: 1rem; color: var(--c-text); line-height: 1.6; margin-bottom: 24px; }
    .floating-card-actions { display: flex; gap: 12px; }
    .profile-button { background: hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.8); color: var(--c-accent-text); border: none; border-radius: var(--radius-sm); padding: 12px 20px; font-weight: 600; cursor: pointer; transition: all 0.2s ease-out; font-size: 0.9rem; }
    .profile-button:hover { transform: scale(1.03); background: var(--c-accent); box-shadow: 0 4px 15px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.3); }
    .profile-button.secondary { background: hsla(0, 0%, 100%, 0.1); color: var(--c-text); }
    .profile-button.secondary:hover { background: hsla(0, 0%, 100%, 0.2); transform: scale(1.03); box-shadow: none; }
    
    .profile-content-body {
        padding-top: 24px; opacity: 0; animation: spotlight-fade-in 0.8s 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: flex-start;
    }
    .profile-tabs ul { list-style: none; display: flex; gap: 8px; border-bottom: 1px solid var(--c-glass-border); background: var(--c-glass-bg); border-radius: var(--radius-lg); padding: 8px; margin-bottom: 24px;}
    .profile-tabs .tab-link { padding: 12px 20px; font-weight: 600; color: var(--c-text-secondary); cursor: pointer; position: relative; border-radius: var(--radius-sm); transition: all 0.3s ease; }
    .profile-tabs .tab-link.active { color: var(--c-text); background: hsla(0,0%,100%,0.1); }
    .tab-content { display: none; }
    .tab-content.active { display: grid; gap: 24px; animation: spotlight-fade-in 0.5s ease; }
    
    .profile-sidebar { position: sticky; top: 16px; display: flex; flex-direction: column; gap: 24px; }
    .profile-card { background: var(--c-glass-bg); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px; }
    .profile-card h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 10px; font-weight: 600; }
    .profile-stats-list { display: flex; justify-content: space-around; }
    .stat-item { text-align: center; }
    .stat-value { font-size: 1.5rem; font-weight: 700; color: var(--c-text); }
    .stat-label { font-size: 0.9rem; color: var(--c-text-secondary); }

    /* --- INICIO DE ESTILOS DE COMPONENTES CONSOLIDADOS --- */
    .post-card { display: flex; flex-direction: column; gap: 16px; background: var(--c-glass-bg); border: 1px solid var(--c-glass-border); border-radius: var(--radius-lg); padding: 24px; }
    .post-header { display: flex; align-items: center; gap: 12px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
    .post-author-name { font-weight: 600; }
    .post-body .post-content { line-height: 1.6; color: var(--c-text-secondary); }
    .post-image-container { border-radius: var(--radius-md); overflow: hidden; margin-top: 8px; max-height: 550px; }
    .post-image { width: 100%; height: 100%; display: block; object-fit: cover; }
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
    .action-button.save-button.active svg { fill: var(--c-accent); }
    
    .post-comments-section { max-height: 0; overflow: hidden; transition: all .5s ease-in-out; opacity: 0; border-top: 1px solid var(--c-glass-border); }
    .post-comments-section.open { max-height: 500px; margin-top: 16px; padding-top: 16px; opacity: 1; }
    .comments-wrapper { display: flex; flex-direction: column; gap: 16px; }
    .comment { display: flex; align-items: flex-start; gap: 12px; padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid var(--c-glass-border); font-size: 0.9rem; line-height: 1.5; }
    .comments-wrapper .comment:last-child { border-bottom: none; margin-bottom: 0; }
    .comment-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
    .comment-author { font-weight: 600; color: var(--c-text); display: block; margin-bottom: 2px; }
    .comment-text { color: var(--c-text-secondary); }
    .comment-form { display: flex; align-items: center; gap: 12px; flex-shrink: 0; padding-top: 16px; border-top: 1px solid var(--c-glass-border); }
    .current-user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
    .comment-input { flex-grow: 1; min-width: 0; background: hsla(0,0%,100%,0.05); border: 1px solid var(--c-glass-border); border-radius: 16px; padding: 10px 16px; color: var(--c-text); font-size: 0.9rem; outline: none; transition: all var(--transition-fast) ease; }
    .comment-input:focus { border-color: var(--c-accent); box-shadow: 0 0 0 3px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.3); }
    .comment-submit-button { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: var(--c-accent); border: none; border-radius: 50%; color: var(--c-accent-text); cursor: pointer; flex-shrink: 0; transition: all var(--transition-fast) ease; }
    .comment-submit-button:hover { transform: scale(1.05); box-shadow: 0 4px 12px hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.4); }
    .comment-submit-button svg { width: 18px; height: 18px; }
    /* --- FIN DE ESTILOS DE COMPONENTES CONSOLIDADOS --- */

    @media (max-width: 1024px) {
        .profile-content-body { grid-template-columns: 1fr; }
        .profile-sidebar { position: static; }
    }
    @media (max-width: 768px) {
        .profile-hero { height: 350px; align-items: flex-end; padding-bottom: 24px; }
        .profile-card-floating { margin-left: auto; margin-right: auto; width: calc(100% - 32px); backdrop-filter: blur(var(--blur-light)); }
        .floating-card-header { flex-direction: column; text-align: center; gap: 12px; }
    }
</style>

<style>
    :root {
        --qg-blur: 24px;
        --qg-bg-color: hsla(220, 15%, 12%, 0.5);
        --qg-border-color: hsla(220, 15%, 70%, 0.15);
        --qg-glow-color: hsla(var(--c-accent-h), var(--c-accent-s), var(--c-accent-l), 0.2);
        --qg-transition-slow: 0.8s;
        --qg-transition-fast: 0.3s;
    }

    @keyframes qg-fade-in-up {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .profile-qg-layout {
        opacity: 0;
        animation: qg-fade-in-up 1s 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* --- Hero Section --- */
    .profile-qg-hero {
        width: 100%;
        height: 350px;
        position: relative;
        display: flex;
        align-items: flex-end;
        padding: 32px;
        border-radius: var(--radius-xl);
        overflow: hidden;
        margin-bottom: 32px;
    }
    .profile-qg-hero__cover {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        z-index: 1;
        transform: scale(1.1);
    }
    .profile-qg-hero__gradient {
        position: absolute;
        bottom: 0; left: 0;
        width: 100%; height: 70%;
        background: linear-gradient(to top, hsla(0,0%,0%,0.8), transparent);
        z-index: 2;
    }

    /* --- User Info Card (Floating) --- */
    .profile-qg-user-card {
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 24px;
        width: 100%;
    }
    .profile-qg-user-card__avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--qg-border-color);
        box-shadow: 0 8px 32px hsla(0,0%,0%,0.5), 0 0 0 1px var(--qg-border-color);
    }
    .profile-qg-user-card__info {
        flex-grow: 1;
        text-shadow: 0 2px 10px hsla(0,0%,0%,0.5);
    }
    .profile-qg-user-card__name {
        font-size: 3rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
    }
    .profile-qg-user-card__handle {
        font-size: 1.2rem;
        font-weight: 500;
        color: var(--c-text);
        opacity: 0.8;
    }
    .profile-qg-user-card__actions {
        display: flex;
        gap: 12px;
        margin-left: auto;
        align-self: center;
    }

    /* --- Main Content Body --- */
    .profile-qg-body {
        display: grid;
        grid-template-columns: 320px 1fr;
        grid-template-areas: "sidebar main";
        gap: 24px;
        align-items: flex-start;
    }
    .profile-qg-main { grid-area: main; }
    .profile-qg-sidebar { grid-area: sidebar; position: sticky; top: 16px; }
    
    /* --- Sidebar Components --- */
    .profile-qg-card {
        background: var(--qg-bg-color);
        backdrop-filter: blur(var(--qg-blur));
        border: 1px solid var(--qg-border-color);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: 0 8px 24px hsla(0,0%,0%,0.2);
        margin-bottom: 24px;
    }
    .profile-qg-sidebar .profile-qg-card {
        opacity: 0;
        transform: translateX(-20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .profile-qg-sidebar .profile-qg-card.is-visible {
        opacity: 1;
        transform: translateX(0);
    }
    .profile-qg-card__header {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--c-text);
        padding-bottom: 12px;
        margin-bottom: 16px;
        border-bottom: 1px solid var(--qg-border-color);
    }
    .profile-qg-bio p {
        color: var(--c-text-secondary);
        line-height: 1.6;
        font-size: 0.95rem;
    }
    .profile-qg-stats { display: flex; justify-content: space-between; text-align: center; }
    .profile-qg-stats__item .value { font-size: 1.5rem; font-weight: 700; color: var(--c-text); }
    .profile-qg-stats__item .label { font-size: 0.85rem; color: var(--c-text-secondary); text-transform: uppercase; letter-spacing: 0.5px;}

    /* --- Tabs --- */
    .profile-qg-tabs {
        display: flex;
        align-items: center;
        background: var(--qg-bg-color);
        backdrop-filter: blur(var(--qg-blur));
        border: 1px solid var(--qg-border-color);
        border-radius: var(--radius-lg);
        padding: 8px;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px hsla(0,0%,0%,0.2);
    }
    .profile-qg-tabs .tab-link {
        flex: 1;
        text-align: center;
        padding: 12px 20px;
        font-weight: 600;
        color: var(--c-text-secondary);
        cursor: pointer;
        border-radius: var(--radius-md);
        position: relative;
        transition: color var(--qg-transition-fast) ease;
    }
    .profile-qg-tabs .tab-link:hover { color: var(--c-text); }
    .profile-qg-tabs .tab-link.active {
        color: var(--c-text);
        background: hsla(0,0%,100%,0.1);
        box-shadow: 0 2px 8px hsla(0,0%,0%,0.3);
    }
    .tab-content { display: none; }
    .tab-content.active { display: grid; gap: 24px; }

    /* --- Responsive Adjustments --- */
    @media (max-width: 1024px) {
        .profile-qg-body {
            grid-template-columns: 1fr;
            grid-template-areas: "main" "sidebar";
        }
        .profile-qg-sidebar { position: static; }
    }
    @media (max-width: 768px) {
        .profile-qg-hero { height: auto; min-height: 300px; padding: 24px 16px; flex-direction: column; align-items: center; text-align: center; }
        .profile-qg-user-card { flex-direction: column; }
        .profile-qg-user-card__avatar { width: 120px; height: 120px; }
        .profile-qg-user-card__name { font-size: 2.2rem; }
        .profile-qg-user-card__actions { margin: 16px auto 0; }
    }
</style>


<div class="profile-qg-layout">
    
    <section class="profile-qg-hero" id="qg-hero">
        <img src="<?php echo htmlspecialchars($user['cover_image']); ?>" alt="Cover Image" class="profile-qg-hero__cover" id="qg-hero-cover">
        <div class="profile-qg-hero__gradient"></div>
        <div class="profile-qg-user-card">
            <img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="profile-qg-user-card__avatar">
            <div class="profile-qg-user-card__info">
                <h1 class="profile-qg-user-card__name"><?php echo htmlspecialchars($user['nombre']); ?></h1>
                <p class="profile-qg-user-card__handle"><?php echo htmlspecialchars($user['handle']); ?></p>
            </div>
            <div class="profile-qg-user-card__actions">
                <button class="profile-button">Seguir</button>
                <button class="profile-button secondary">Mensaje</button>
            </div>
        </div>
    </section>

    <div class="profile-qg-body">
        
        <aside class="profile-qg-sidebar">
            <div class="profile-qg-card profile-qg-bio">
                <h3 class="profile-qg-card__header">Sobre mi</h3>
                <p><?php echo htmlspecialchars($user['bio_long']); ?></p>
            </div>
            <div class="profile-qg-card profile-qg-stats">
                <div class="profile-qg-stats__item">
                    <div class="value"><?php echo htmlspecialchars($user['stats']['posts']); ?></div>
                    <div class="label">Posts</div>
                </div>
                <div class="profile-qg-stats__item">
                    <div class="value"><?php echo htmlspecialchars($user['stats']['followers']); ?></div>
                    <div class="label">Seguidores</div>
                </div>
                <div class="profile-qg-stats__item">
                    <div class="value"><?php echo htmlspecialchars($user['stats']['following']); ?></div>
                    <div class="label">Siguiendo</div>
                </div>
            </div>
        </aside>

        <main class="profile-qg-main">
            <nav class="profile-qg-tabs profile-tabs">
                <ul>
                    <li><a class="tab-link active" data-tab="posts">Posts</a></li>
                    <li><a class="tab-link" data-tab="media">Media</a></li>
                    <li><a class="tab-link" data-tab="likes">Likes</a></li>
                </ul>
            </nav>

            <div id="tab-posts" class="tab-content active">
                <?php foreach ($user['posts'] as $index => $post): ?>
                    <article class="post-card">
                        <header class="post-header"><img src="<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" class="post-avatar"><span class="post-author-name"><?php echo htmlspecialchars($user['nombre']); ?></span></header>
                        <div class="post-body">
                            <p class="post-content"><?php echo htmlspecialchars($post['contenido']); ?></p>
                            <?php if (isset($post['imagen']) && $post['imagen']): ?><div class="post-image-container"><img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="Imagen del post" class="post-image"></div><?php endif; ?>
                        </div>
                        <footer class="post-footer">
                            <div class="post-actions-main">
                                <button class="action-button like-button" title="Me gusta"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></button>
                                <button class="action-button comment-button" title="Comentar"><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v10z"></path></svg></button>
                            </div>
                            <div class="post-actions-secondary"><button class="action-button save-button" title="Guardar"><svg viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg></button></div>
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
            <div id="tab-media" class="tab-content"><div class="profile-qg-card"><h3>Media Content Placeholder</h3></div></div>
            <div id="tab-likes" class="tab-content"><div class="profile-qg-card"><h3>Likes Content Placeholder</h3></div></div>
        </main>

    </div>
</div>


<?php
    include 'pie_quimera.php'; 
?>