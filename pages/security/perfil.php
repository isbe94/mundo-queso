<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers.php';

$page_title = "Mi Perfil";
$page_css = "perfil.css";
$publicacionesUsuario = obtenerPublicacionesUsuario($csvPosts , $_SESSION["usuario"]);
$totalPublicaciones = count($publicacionesUsuario) > 0 ? count($publicacionesUsuario) : 0;
$totalLikes = 0;
$totalComentarios = 0;

// Comprobamos si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $usuarios = fopen($csvUsers, "r");
    while (!feof($usuarios)) {
        $usuario = fgetcsv($usuarios);
        if ($usuario[3] === $_SESSION["usuario"]) {
            $nombre = $usuario[0];
            $apellidos = $usuario[1];
            $correo = $usuario[2];
            break;
        }
    }
    fclose($usuarios);
} else {
    // Redireccionamos al usuario a la página de inicio de sesión
    echo 'No tiene acceso a esta página.';
    echo '<p>Para acceder, por favor inicie sesión:</p>
    <a href="login.php">Iniciar sesión</a>
    <p>Si no tienes una cuenta, puede registrarse:</p>
    <a href="signup.php">Registrarse</a>';
    exit();
}

function tiempo_transcurrido($fecha)
{
    $ahora = new DateTime();
    $publicado = new DateTime($fecha);
    $intervalo = $ahora->diff($publicado);

    if ($intervalo->y > 0) return 'Hace ' . $intervalo->y . ' año(s)';
    if ($intervalo->m > 0) return 'Hace ' . $intervalo->m . ' mes(es)';
    if ($intervalo->d > 0) return 'Hace ' . $intervalo->d . ' día(s)';
    if ($intervalo->h > 0) return 'Hace ' . $intervalo->h . ' hora(s)';
    if ($intervalo->i > 0) return 'Hace ' . $intervalo->i . ' minuto(s)';
    return 'Hace unos segundos';
};

foreach($publicacionesUsuario as $pubUser){
     
    $totalLikes += $pubUser['likes'];
    $totalComentarios += $pubUser['comentarios'];
}

include BASE_PATH . '/includes/header.php';
?>

<div class="container">
    <!-- Header del perfil -->
    <div class="profile-header text-center mb-5">
        <div class="profile-avatar mb-3">
            <div class="avatar-circle">
                <i class="fas fa-user"></i>
            </div>
            <div class="avatar-status">
                <i class="fas fa-circle text-success"></i>
            </div>
        </div>
        <h1 class="profile-welcome mb-2">
            Hola, <span class="username-highlight"><?php echo $_SESSION['usuario']; ?></span>
        </h1>
        <p class="profile-subtitle text-muted">Bienvenido a tu panel personal de Mundo Queso</p>
    </div>

    <div class="row">
        <!-- Datos del usuario -->
        <div class="col-lg-4 mb-4">
            <div class="profile-card">
                <div class="profile-card-header">
                    <h3 class="profile-card-title">
                        <i class="fas fa-user-circle me-2"></i>Tus Datos
                    </h3>
                </div>
                <div class="profile-card-body">
                    <div class="profile-field mb-3">
                        <label class="profile-label">
                            <i class="fas fa-user me-2"></i>Nombre
                        </label>
                        <div class="profile-value"><?php echo $nombre; ?></div>
                    </div>

                    <div class="profile-field mb-3">
                        <label class="profile-label">
                            <i class="fas fa-user-tag me-2"></i>Apellidos
                        </label>
                        <div class="profile-value"><?php echo $apellidos; ?></div>
                    </div>

                    <div class="profile-field mb-4">
                        <label class="profile-label">
                            <i class="fas fa-envelope me-2"></i>Correo Electrónico
                        </label>
                        <div class="profile-value"><?php echo $correo; ?></div>
                    </div>

                    <div class="profile-actions">
                        <button class="btn btn-outline-primary btn-sm w-100 mb-2" disabled>
                            <i class="fas fa-edit me-2"></i>Editar Perfil
                            <small class="d-block text-muted">(Próximamente)</small>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="stats-card mt-4">
                <div class="stats-header">
                    <h5 class="stats-title">
                        <i class="fas fa-chart-bar me-2"></i>Estadísticas
                    </h5>
                </div>
                <div class="stats-body">
                    <div class="stat-item">
                        <div class="stat-number"><?= $totalPublicaciones ?></div>
                        <div class="stat-label">Publicaciones</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?= $totalLikes ?></div>
                        <div class="stat-label">Me Gusta</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?= $totalComentarios ?></div>
                        <div class="stat-label">Comentarios</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Publicaciones -->
        <div class="col-lg-8">
            <div class="publications-section">
                <div class="publications-header mb-4">
                    <h3 class="publications-title">
                        <i class="fas fa-images me-2"></i>Tus Publicaciones
                    </h3>
                    <a class="btn btn-primary btn-sm" href="<?= BASE_URL ?>pages/posts.php">
                        <i class="fas fa-plus me-2"></i>Nueva Publicación
                    </a>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php if (count($publicacionesUsuario) > 0): ?>
                        <?php foreach ($publicacionesUsuario as $publicacion): ?>
                            <?php
                            $fechaFormateada = tiempo_transcurrido($publicacion['fecha']);
                            ?>
                            <div class="col">
                                <div class="publication-card h-100">
                                    <div class="publication-image">
                                        <img src="<?= BASE_URL ?>assets/img/<?= htmlspecialchars($publicacion['imagen']) ?>" alt="<?= htmlspecialchars($publicacion['titulo']) ?>">
                                        <div class="publication-overlay">
                                            <div class="publication-actions">
                                                <button class="btn btn-light btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-light btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="publication-content d-flex flex-column">
                                        <h5 class="publication-title"><?= htmlspecialchars($publicacion['titulo']) ?></h5>
                                        <p class="publication-text"><?= htmlspecialchars($publicacion['descripcion']) ?></p>
                                        <div class="publication-meta mt-auto">
                                            <span class="publication-date">
                                                <i class="fas fa-calendar me-1"></i><?= $fechaFormateada ?>
                                            </span>
                                            <span class="publication-likes">
                                                <i class="fas fa-heart me-1"></i><?= $publicacion['likes'] ?> likes
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col mx-auto">
                            <p class="text-muted">Aún no has publicado nada.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación -->
    <div class="profile-navigation text-center mt-5">
        <div class="navigation-buttons">
            <a href="<?= BASE_URL ?>index.php" class="btn btn-outline-primary me-3 principal">
                <i class="fas fa-home me-2"></i>Inicio
            </a>
            <a href="logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
            </a>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/includes/footer.php'; ?>