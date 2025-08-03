<?php

// --- INICIO DE LA CONFIGURACIÓN ---
// Se incluyen los ficheros de configuración y helpers
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers.php';

// Se define la ruta al fichero CSV y se obtienen las publicaciones
// NOTA: Se asume que el CSV ahora tiene las columnas: imagen, titulo, descripcion, autor, fecha
$csvFile = BASE_PATH . '/pages/posts.csv';
$publicaciones = obtenerPublicaciones($csvFile);
// --- FIN DE LA CONFIGURACIÓN ---

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

        <!-- Subtítulo -->
        <h2 class="text-center mb-4">Publicaciones Recientes</h2>

        <!-- Contenedor de todas las publicaciones -->
        <!-- MEJORA: Ajustado para mostrar 3 columnas en pantallas medianas y grandes -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 contenedor-publicaciones">
            
            <?php
            // Se recorre el array de publicaciones para generar cada tarjeta dinámicamente
            foreach ($publicaciones as $publicacion) {
                // --- Formateo de la fecha para mayor legibilidad ---
                $fechaFormateada = 'Fecha no disponible';
                if (!empty($publicacion["fecha"])) {
                    $timestamp = strtotime($publicacion["fecha"]);
                    if ($timestamp) {
                        // Se requiere que la extensión intl de PHP esté habilitada
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

                            <!-- Contenedor para metadatos (autor y fecha) que se alinea al fondo -->
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
            <ul class="pagination justify-content-center" id="paginacion"></ul>
        </nav>
    </div>
</section>