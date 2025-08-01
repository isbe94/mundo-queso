<?php
    session_start();


    if (isset($_POST['submit'])) {
        if(is_file('usuarios.csv')) {
            $usuarios = file('usuarios.csv');
            foreach($usuarios as $usuario) {
                $datos = explode(',', $usuario);
                // echo '<pre>'; 
                // print_r($datos); 
                // echo '</pre>';
            
                if (trim($datos[3]) == trim($_POST['usuario']) && password_verify($_POST['contrasena'], trim($datos[4]))) {
                    $_SESSION['usuario'] = $_POST['usuario'];
                    header("Location: ../../index.php");
                    exit;
                }
            }
            
        }
        $mensaje = '<div class="text-danger fw-semibold text-center mb-2"> Nombre de usuario o Contraseña incorrecta </div>';
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Iniciar Sesión</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="../css/style.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Pacifico&display=swap" rel="stylesheet">    

    </head>
    
    <body class="body_login">
        <!-- Encabezado de la página -->
        <?php include('..\includes\navbar.php')?>

        <div class="container container_login mb-4">
            <h4 class="fw-bold mb-4 text-center">Inicia sesión para postear tus recetas</h4>

            <?php if (isset($mensaje)) { echo $mensaje; } ?>
            <?php if (isset($_SESSION['mensaje_registro'])) { echo $_SESSION['mensaje_registro']; }?>
            
            <form action="" method="post">
                <div class="row mb-4">
                    <div class="col">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="usuario" class="">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" require>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="contrasena" class="">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" require>
                        </div>
                        <p class="fs-6 mt-4 text-center" id="registrar"><strong>Si no tienes una cuenta, puedes registrarte <a href="signup.php">aquí</a></strong></p>
                    
                    </div>   
                </div>
                
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-secondary">Iniciar</button>
                </div>
            </form>

            
        </div>
    </body>

    <div class="fixed-bottom">
        <?php include '../includes/footer.php' ?>
    </div>

</html>