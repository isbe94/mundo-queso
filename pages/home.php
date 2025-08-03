<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers.php';

$publicaciones = obtenerPublicaciones($csvPosts);

// Paginación 
$porPagina = 3;
$totalPublicaciones = count($publicaciones);
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max($paginaActual, 1); // evita valores < 1

$totalPaginas = ceil($totalPublicaciones / $porPagina);
$inicio = ($paginaActual - 1) * $porPagina;

// Reducir array de publicaciones para mostrar solo las correspondientes
$publicacionesMostradas = array_slice($publicaciones, $inicio, $porPagina);


?>

<!-- Sección de Principal -->
<section id="inicio" class="bg-light py-5">
    <div class="container">
        <!-- Título principal -->
        <div class="text-center mb-5">
            <h1 class="fw-bold display-5">
                Bienvenid@ <span class="welcome">a Mundo Queso</span>
            </h1>
            <p class="fst-italic text-muted">
                ¡Aprende las mejores recetas y dale un gusto a tu paladar!
            </p>
        </div>

        <h2 class="text-center mb-4">Publicaciones Recientes</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 contenedor-publicaciones" id="publicaciones">

            <?php
            foreach ($publicacionesMostradas as $publicacion) {
                $fechaFormateada = 'Fecha no disponible';
                if (!empty($publicacion["fecha"])) {
                    $timestamp = strtotime($publicacion["fecha"]);
                    if ($timestamp) {
                        $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                        $fechaFormateada = $formatter->format($timestamp);
                    }
                }

                // Se escapa el contenido para seguridad
                $imagen = htmlspecialchars($publicacion['imagen'], ENT_QUOTES, 'UTF-8');
                $titulo = htmlspecialchars($publicacion['titulo'], ENT_QUOTES, 'UTF-8');
                $descripcion = htmlspecialchars($publicacion['descripcion'], ENT_QUOTES, 'UTF-8');
                $autor = htmlspecialchars($publicacion['usuario'], ENT_QUOTES, 'UTF-8');

                // HEREDOC para un HTML más limpio
                echo <<<HTML
                <div class="col publicacion">
                    <div class="card h-100 shadow-sm">
                        <img src="assets/img/{$imagen}" class="card-img-top" alt="Imagen de {$titulo}">
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{$titulo}</h5>
                            <p class="card-text">{$descripcion}</p>

                            <div class="mt-auto pt-3 border-top">
                                <p class="card-text mb-1">
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-user fa-fw me-2"></i>
                                        <span>{$autor}</span>
                                    </small>
                                </p>
                                <p class="card-text mb-0">
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-calendar-alt fa-fw me-2"></i>
                                        <span>{$fechaFormateada}</span>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                HTML;
            }
            ?>
        </div>

        <!-- Paginación -->
        <nav class="mt-5" aria-label="Paginación de publicaciones">
            <ul class="pagination justify-content-center">
                <?php if ($paginaActual > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $paginaActual - 1 ?>#publicaciones">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= $i === $paginaActual ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $i ?>#publicaciones"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($paginaActual < $totalPaginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?= $paginaActual + 1 ?>#publicaciones">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</section>


<?php include BASE_PATH . '/includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        if (window.location.hash === '#publicaciones') {
            var $publicaciones = $('#publicaciones');
            if ($publicaciones.length) {
                $('html, body').animate({
                    scrollTop: $publicaciones.offset().top
                }, 100);
            }
        }
    });
</script>