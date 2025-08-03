<?php
session_start();
require_once __DIR__ . '/../../config/config.php';

$page_title = "Iniciar Sesión";
$page_css = "login.css";

if (isset($_POST['submit'])) {
    if (is_file($csvUsers)) {
        $usuarios = file($csvUsers);
        foreach ($usuarios as $usuario) {
            $datos = explode(',', $usuario);
            if (trim($datos[3]) == trim($_POST['usuario']) && password_verify($_POST['contrasena'], trim($datos[4]))) {
                $_SESSION['usuario'] = $_POST['usuario'];
                header("Location: ../../index.php");
                exit;
            }
        }
    }
    $mensaje = '<div class="text-danger fw-semibold text-center mb-2"> Nombre de usuario o Contraseña incorrecta </div>';
}

include BASE_PATH . '/includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="login-container">
                <!-- Header del formulario -->
                <div class="login-header text-center mb-4">
                    <div class="login-icon mb-3">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <h1 class="login-title mb-2">Bienvenido de vuelta</h1>
                    <p class="login-subtitle text-muted">
                        Inicia sesión para compartir tus recetas favoritas
                    </p>
                </div>

                <!-- Mensajes -->
                <?php if (isset($mensaje)) {
                    echo $mensaje;
                } ?>
                <?php if (isset($_SESSION['mensaje_registro'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>' .
                        $_SESSION['mensaje_registro'] .
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                          </div>';
                    unset($_SESSION['mensaje_registro']);
                } ?>

                <!-- Formulario -->
                <form action="" method="post" class="login-form">

                    <!-- Usuario -->
                    <div class="form-floating mb-3">
                        <input type="text"
                            class="form-control"
                            id="usuario"
                            name="usuario"
                            placeholder="Usuario"
                            required>
                        <label for="usuario">
                            <i class="fas fa-user me-2"></i>Usuario
                        </label>
                    </div>

                    <!-- Contraseña -->
                    <div class="form-floating mb-3">
                        <input type="password"
                            class="form-control"
                            id="contrasena"
                            name="contrasena"
                            placeholder="Contraseña"
                            required>
                        <label for="contrasena">
                            <i class="fas fa-lock me-2"></i>Contraseña
                        </label>
                        <div class="password-toggle">
                            <i class="fas fa-eye" onclick="togglePassword('contrasena')"></i>
                        </div>
                    </div>

                    <!-- Botón de login -->
                    <div class="d-grid mb-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg login-btn">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </button>
                    </div>

                    <!-- Link a registro -->
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            ¿No tienes una cuenta?
                            <a href="./register.php" class="text-decoration-none fw-semibold register-link">
                                Regístrate aquí
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/includes/footer.php'; ?>

<script>
    function togglePassword(inputId) {
        const $input = $('#' + inputId);
        const $icon = $input.parent().find('.password-toggle i');

        if ($input.attr('type') === 'password') {
            $input.attr('type', 'text');
            $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $input.attr('type', 'password');
            $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }
</script>