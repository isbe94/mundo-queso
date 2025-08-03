<?php
require_once __DIR__ . '/../../config/config.php';

$page_title = "Registro";
$page_css = "signup.css";
$errors = [];
$success_message = '';
$form_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar y validar datos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

    // Guardar datos del formulario para rellenar en caso de error
    $form_data = [
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'correo' => $correo,
        'usuario' => $usuario
    ];

    // Validaciones
    if (empty($nombre)) {
        $errors['nombre'] = 'El nombre es obligatorio';
    } elseif (strlen($nombre) < 2) {
        $errors['nombre'] = 'El nombre debe tener al menos 2 caracteres';
    }

    if (empty($apellidos)) {
        $errors['apellidos'] = 'Los apellidos son obligatorios';
    } elseif (strlen($apellidos) < 2) {
        $errors['apellidos'] = 'Los apellidos deben tener al menos 2 caracteres';
    }

    if (empty($correo)) {
        $errors['correo'] = 'El correo electrónico es obligatorio';
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errors['correo'] = 'El formato del correo electrónico no es válido';
    }

    if (empty($usuario)) {
        $errors['usuario'] = 'El nombre de usuario es obligatorio';
    } elseif (strlen($usuario) < 3) {
        $errors['usuario'] = 'El usuario debe tener al menos 3 caracteres';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $usuario)) {
        $errors['usuario'] = 'El usuario solo puede contener letras, números y guiones bajos';
    }

    if (empty($contrasena)) {
        $errors['contrasena'] = 'La contraseña es obligatoria';
    } elseif (strlen($contrasena) < 6) {
        $errors['contrasena'] = 'La contraseña debe tener al menos 6 caracteres';
    }

    if ($contrasena !== $confirmar_contrasena) {
        $errors['confirmar_contrasena'] = 'Las contraseñas no coinciden';
    }

    // Si no hay errores, proceder con el registro
    if (empty($errors)) {
        $usuarioExiste = false;
        $correoExiste = false;

        if (is_file($csvUsers)) {
            $usuarios = file($csvUsers);
            foreach ($usuarios as $u) {
                $datos = explode(',', trim($u));
                if (isset($datos[3]) && $datos[3] == $usuario) {
                    $errors['usuario'] = 'El nombre de usuario "' . $usuario . '" ya existe';
                    $usuarioExiste = true;
                }
                if (isset($datos[2]) && $datos[2] == $correo) {
                    $errors['correo'] = 'El correo electrónico ya está registrado';
                    $correoExiste = true;
                }
            }
        }

        if (!$usuarioExiste && !$correoExiste) {
            $contraseña_hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $usuarios_file = fopen($csvUsers, 'a');
            fputcsv($usuarios_file, array($nombre, $apellidos, $correo, $usuario, $contraseña_hash));
            fclose($usuarios_file);

            $_SESSION['mensaje_registro'] = 'Registro exitoso. Ya puedes iniciar sesión.';
            header("Location: ./login.php");
            exit();
        }
    }
}

include BASE_PATH . '/includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="register-container">
                <!-- Header del formulario -->
                <div class="register-header text-center mb-4">
                    <div class="register-icon mb-3">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h1 class="register-title mb-2">Crear Cuenta</h1>
                    <p class="register-subtitle text-muted">
                        Únete a la comunidad de Mundo Queso
                    </p>
                </div>

                <!-- Formulario -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                    class="register-form needs-validation" novalidate>

                    <!-- Nombre y Apellidos -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control <?php echo isset($errors['nombre']) ? 'is-invalid' : ''; ?>"
                                    id="nombre"
                                    name="nombre"
                                    placeholder="Nombre"
                                    value="<?php echo htmlspecialchars($form_data['nombre'] ?? ''); ?>"
                                    required>
                                <label for="nombre">
                                    <i class="fas fa-user me-2"></i>Nombre
                                </label>
                                <?php if (isset($errors['nombre'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <?php echo $errors['nombre']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control <?php echo isset($errors['apellidos']) ? 'is-invalid' : ''; ?>"
                                    id="apellidos"
                                    name="apellidos"
                                    placeholder="Apellidos"
                                    value="<?php echo htmlspecialchars($form_data['apellidos'] ?? ''); ?>"
                                    required>
                                <label for="apellidos">
                                    <i class="fas fa-user me-2"></i>Apellidos
                                </label>
                                <?php if (isset($errors['apellidos'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <?php echo $errors['apellidos']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="form-floating mb-3">
                        <input type="email"
                            class="form-control <?php echo isset($errors['correo']) ? 'is-invalid' : ''; ?>"
                            id="correo"
                            name="correo"
                            placeholder="correo@ejemplo.com"
                            value="<?php echo htmlspecialchars($form_data['correo'] ?? ''); ?>"
                            required>
                        <label for="correo">
                            <i class="fas fa-envelope me-2"></i>Correo Electrónico
                        </label>
                        <?php if (isset($errors['correo'])): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $errors['correo']; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Usuario -->
                    <div class="form-floating mb-3">
                        <input type="text"
                            class="form-control <?php echo isset($errors['usuario']) ? 'is-invalid' : ''; ?>"
                            id="usuario"
                            name="usuario"
                            placeholder="usuario123"
                            value="<?php echo htmlspecialchars($form_data['usuario'] ?? ''); ?>"
                            required>
                        <label for="usuario">
                            <i class="fas fa-at me-2"></i>Nombre de Usuario
                        </label>
                        <?php if (isset($errors['usuario'])): ?>
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $errors['usuario']; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contraseñas -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password"
                                    class="form-control <?php echo isset($errors['contrasena']) ? 'is-invalid' : ''; ?>"
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
                                <?php if (isset($errors['contrasena'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <?php echo $errors['contrasena']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="password"
                                    class="form-control <?php echo isset($errors['confirmar_contrasena']) ? 'is-invalid' : ''; ?>"
                                    id="confirmar_contrasena"
                                    name="confirmar_contrasena"
                                    placeholder="Confirmar Contraseña"
                                    required>
                                <label for="confirmar_contrasena">
                                    <i class="fas fa-lock me-2"></i>Confirmar
                                </label>
                                <div class="password-toggle">
                                    <i class="fas fa-eye" onclick="togglePassword('confirmar_contrasena')"></i>
                                </div>
                                <?php if (isset($errors['confirmar_contrasena'])): ?>
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <?php echo $errors['confirmar_contrasena']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Indicador de fortaleza de contraseña -->
                    <div class="password-strength mb-3" id="passwordStrength" style="display: none;">
                        <div class="strength-meter">
                            <div class="strength-meter-fill"></div>
                        </div>
                        <small class="strength-text"></small>
                    </div>

                    <!-- Botón de registro -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-lg register-btn">
                            <span class="btn-text">
                                <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                            </span>
                            <span class="btn-loading" style="display: none;">
                                <i class="fas fa-spinner fa-spin me-2"></i>Creando cuenta...
                            </span>
                        </button>
                    </div>

                    <!-- Link a login -->
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            ¿Ya tienes una cuenta?
                            <a href="./login.php" class="text-decoration-none fw-semibold">
                                Inicia sesión aquí
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
    $(document).ready(function() {
        const $form = $('.register-form');
        const $passwordInput = $('#contrasena');
        const $confirmPasswordInput = $('#confirmar_contrasena');
        const $strengthIndicator = $('#passwordStrength');
        const $submitBtn = $('.register-btn');

        // Validación de fortaleza de contraseña
        $passwordInput.on('input', function() {
            const password = $(this).val();
            const strength = calculatePasswordStrength(password);
            updatePasswordStrength(strength);

            if (password.length > 0) {
                $strengthIndicator.show();
            } else {
                $strengthIndicator.hide();
            }
        });

        // Validación de confirmación de contraseña
        $confirmPasswordInput.on('input', function() {
            const password = $passwordInput.val();
            const confirmPassword = $(this).val();

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            } else {
                $(this).removeClass('is-valid is-invalid');
            }
        });

        // Envío del formulario con loading
        $form.on('submit', function(e) {
            if (this.checkValidity()) {
                const $btnText = $submitBtn.find('.btn-text');
                const $btnLoading = $submitBtn.find('.btn-loading');

                $btnText.hide();
                $btnLoading.show();
                $submitBtn.prop('disabled', true);
            }
        });

        function calculatePasswordStrength(password) {
            let strength = 0;

            if (password.length >= 6) strength += 1;
            if (password.length >= 10) strength += 1;
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;

            return Math.min(strength, 3);
        }

        function updatePasswordStrength(strength) {
            const strengthClasses = ['strength-weak', 'strength-medium', 'strength-strong'];
            const strengthTexts = ['Débil', 'Media', 'Fuerte'];

            $strengthIndicator.attr('class', 'password-strength mb-3');

            if (strength > 0) {
                $strengthIndicator.addClass(strengthClasses[strength - 1]);
                $strengthIndicator.find('.strength-text').text('Fortaleza: ' + strengthTexts[strength - 1]);
            } else {
                $strengthIndicator.find('.strength-text').text('');
            }
        }
    });

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