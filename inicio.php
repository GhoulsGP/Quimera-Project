<?php 
    // ARCHIVO: inicio.php (v3.0 - Solución CSS Columns)

    include 'plantilla_quimera.php';
    
    // Datos de prueba
    $posts = [
        [ 'autor_nombre' => 'Elena Codes', 'type' => 'wide', 'contenido' => 'Este post es ancho y ahora, con column-span, ocupa todo el espacio horizontal antes de que el contenido continúe fluyendo debajo en dos columnas. Es una solución robusta.', 'imagen' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=2070&auto=format&fit=crop'],
        [ 'autor_nombre' => 'Ana Design', 'type' => 'vertical', 'contenido' => 'Las imágenes verticales ahora encuentran su lugar en el flujo natural del layout de columnas. La altura de la tarjeta se adapta perfectamente.', 'imagen' => 'https://images.unsplash.com/photo-1511300636412-01634217b4e6?q=80&w=1887&auto=format&fit=crop'],
        [ 'autor_nombre' => 'Carlos Dev', 'type' => 'normal', 'contenido' => 'Un post de solo texto, que fluye en la primera columna disponible.', 'imagen' => null],
        [ 'autor_nombre' => 'David UX', 'type' => 'normal', 'contenido' => 'El layout de columnas es la técnica ideal para este tipo de contenido dinámico, evitando los huecos que generaba el grid anterior.', 'imagen' => null],
    ];
    $tendencias = ['#QuimeraProject', '#LayoutFix', '#CSSColumns', '#RobustDesign', '#FutureWeb'];
?>

<style>
    /* --- ESTRUCTURA PRINCIPAL --- */
    .home-layout {
        display: grid;
        grid-template-columns: 1fr 300px; /* Columna de contenido + Sidebar */
        gap: 24px;
        align-items: flex-start;
    }
    .sidebar { position: sticky; top: 16px; }

    /* --- SOLUCIÓN DE MAQUETACIÓN: CSS COLUMNS --- */
    .feed-container {
        column-count: 2; /* Crea un layout de 2 columnas */
        column-gap: 24px; /* Espacio entre columnas */
    }
    .post-card {
        margin-bottom: 24px; /* Espacio vertical entre tarjetas */
        break-inside: avoid; /* Evita que una tarjeta se parta entre dos columnas */
        width: 100%; /* La tarjeta ocupa el ancho de su columna */
    }
    .post-card.post-type-wide {
        column-span: all; /* Hace que el post ancho ocupe TODAS las columnas */
    }

    /* --- ESTILOS DE TARJETA (ESTABLES) --- */
    .post-card {
        display: flex; flex-direction: column; gap: 16px;
        background: var(--c-glass-bg);
        border: 1px solid var(--c-glass-border);
        border-radius: var(--radius-lg); padding: 24px;
    }
    .post-header { display: flex; align-items: center; gap: 12px; }
    .post-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; }
    .post-author-name { font-weight: 600; }
    .post-body .post-content { line-height: 1.6; color: var(--c-text-secondary); }
    .post-image-container { border-radius: var(--radius-md); overflow: hidden; margin-top: 8px; }
    .post-image { width: 100%; display: block; }
    .post-type-vertical .post-image { max-height: 500px; width: auto; margin: 0 auto; }
    .post-type-wide .post-image-container { max-height: 450px; }
    .post-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--c-glass-border); padding-top: 16px; margin-top: auto; }

    /* --- TENDENCIAS Y TEXTO CINÉTICO (ESTILOS RESTAURADOS) --- */
    .trends-container { background: var(--c-glass-bg); border-radius: var(--radius-lg); padding: 24px; }
    .trends-container h3 { margin-bottom: 16px; border-bottom: 1px solid var(--c-glass-border); padding-bottom: 10px; }
    .trends-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 16px; }
    .trends-list a { color: var(--c-text-secondary); text-decoration: none; font-weight: 500; display: inline-block; }
    .trends-list a:hover .char { animation: kinetic-scramble 0.8s ease-out forwards; }
    .char { display: inline-block; }
    @keyframes kinetic-scramble { 0%{transform:translate(0,0)} 50%{transform:translate(var(--dx),var(--dy)) rotate(var(--r))} 100%{transform:translate(0,0)} }

    /* --- RESPONSIVE --- */
    @media (max-width: 1024px) {
        .home-layout { grid-template-columns: 1fr; }
        .sidebar { display: none; }
    }
    @media (max-width: 768px) {
        .feed-container { column-count: 1; } /* El feed pasa a una sola columna */
    }
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