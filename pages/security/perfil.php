<?php
// Iniciamos la sesión
session_start();
// Comprobamos si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $usuarios = fopen("usuarios.csv", "r");
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

include '../../includes/header.php';
include '../../includes/navbar.php'; ?>

<div class="container p-5">
    <h1 class="text-secondary text-center fw-bold mb-4">Hola, <span
            class="text-warning text-opacity-50"><?php echo $_SESSION['usuario']; ?></span></h1>
    <div class="row d-flex justify-content-center mb-4">
        <div class="col-md-4">
            <h3 class="text-center mt-4 "> Tus Datos</h3>
            <label for="" class="col-form-label">Nombre</label>
            <span class="form-control"><?php echo $nombre; ?></span>

            <label for="" class="col-form-label">Apellidos</label>
            <span class="form-control"><?php echo $apellidos; ?></span>

            <label for="" class="col-form-label">Correo Electrónico</label>
            <span class="form-control mb-4"><?php echo $correo; ?></span>

        </div>
    </div>
    <div class="row mb-4">
        <h3 class="text-center"> Tus Publicaciones</h3>
        <div class="row row-cols-1 row-cols-md-5 g-7">
            <div class="col">
                <div class="card">
                    <img src="assets/img/1.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/2.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/3.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/4.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <img src="assets/img/5.jpeg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                            additional content. This content is a little bit longer.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="../index.php">Página Principal</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</div>

<?php include '../../includes/footer.php' ?>