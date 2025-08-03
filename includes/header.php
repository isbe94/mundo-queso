<?php
require_once __DIR__ . '/../config/config.php';
$postear = isset($_SESSION['usuario']) ? BASE_URL . 'pages/posts.php' : BASE_URL . 'pages/security/login.php';
$favicon = BASE_URL . 'assets/icons/cheese.ico';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= htmlspecialchars($favicon, ENT_QUOTES, 'UTF-8') ?>" type="image/x-icon">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>Mundo Queso</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="<?= BASE_URL ?>assets/css/style.css" rel="stylesheet">
    <?php if (isset($page_css)): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/<?= $page_css ?>" />
    <?php endif; ?>
</head>

<body>
    <!-- Header -->
    <header class="header-main shadow-sm sticky-top">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container">
                <!-- Logo y título -->
                <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>index.php">
                    <div class="logo-container">
                        <i class="fas fa-cheese fs-2"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 brand-title">Mundo Queso</h4>
                    </div>
                </a>

                <!-- Botón responsive -->
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Alternar navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menú -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center mb-2 mb-lg-0 gap-2">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item dropdown me-3">
                                <a class="nav-link dropdown-toggle user-greeting d-flex align-items-center gap-2"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="d-none d-md-inline">Hola, <?= $_SESSION['usuario'] ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a class="dropdown-item" href="<?= BASE_URL ?>pages/security/perfil.php">
                                            <i class="fas fa-user-circle me-2"></i>Mi Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-cog me-2"></i>Configuración
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= BASE_URL ?>pages/security/logout.php">
                                            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <a class="nav-link nav-btn" href="<?= BASE_URL ?>index.php">
                                <i class="fas fa-home me-2"></i>Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link nav-btn" href="#">
                                <i class="fas fa-cheese me-2"></i>Productos
                            </a>
                        </li>

                        <?php if (isset($_SESSION['usuario'])): ?>
                            <li class="nav-item">
                                <a class="nav-link nav-btn btn-post" href="<?= $postear ?>">
                                    <i class="fas fa-plus me-2"></i>Postear
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link nav-btn btn-login" href="<?= BASE_URL ?>pages/security/login.php">
                                    <i class="fas fa-user me-2"></i>Iniciar Sesión
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-btn btn-register" href="<?= BASE_URL ?>pages/security/signup.php">
                                    <i class="fas fa-user-plus me-2"></i>Registrarse
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">