<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $contraseña = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

        if (empty(trim($nombre)) || empty(trim($apellidos)) || empty(trim($correo)) || empty(trim($usuario)) || empty(trim($_POST['contrasena']))) {
            $mensaje_campos = '<div class="fw-semibold text-center mt-4 mb-2 text-light">Complete todos los campos. Por favor.</div>';
        } else {
            
            $usuarioExiste = False;
            if(is_file('usuarios.csv')) {
                $usuarios = file('usuarios.csv');
                
                foreach($usuarios as $u) {
                    $datos = explode(',', $u);
                    
                    if ($datos[3] == $_POST['usuario']) {
                        $error = '<div class="fw-bold text-center mt-4 mb-2 text-danger">El nombre de usuario "'.$_POST['usuario'].'" ya existe. Por favor, elige otro.</div>';
                        $usuarioExiste = True;
                        break;
                    }
                }    
            }
            
            if ($usuarioExiste == False) {
                $usuarios = fopen('usuarios.csv', 'a');
                //si el usuario no existe se abre el fichero csv para añadirlo
                //se añade nuevo elemento
                fputcsv($usuarios, array($nombre, $apellidos, $correo, $usuario, $contraseña));
                //se cierra el fichero
                fclose($usuarios);
                $mensaje_registro = '<div class="fw-bold text-center mt-4 mb-2 text-light"> Registro Exitoso. Inicie Sesión.</div>';
                $_SESSION['mensaje_registro'] = $mensaje_registro;
                header("Location: .\login.php");
                exit();
               
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registrarse</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="../css/style.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Pacifico&display=swap" rel="stylesheet">
    </head>
    <body class="body_signup">

        <!-- Encabezado de la página -->
        <?php include('..\includes\navbar.php')?>

        <div class="container container_signup" >
            <h1 class="fw-bold mb-4 text-center">Registro</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">                
                <div class="row">    
                    
                    <div class="col">

                        <div class="input-group mb-3">    
                            <label class="input-group-text" for="nombre" class="">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" require>
                        </div>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="apellidos" class="">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" require>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="correo" class="">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" require>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="" class="">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" require>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="" class="">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" require>
                        </div>

                        <?php if (isset($mensaje_campos)) { echo $mensaje_campos; } ?>
                        <?php if (isset($error)) { echo $error; } ?>
                        <?php if (isset($mensaje_registro)) { echo $mensaje_registro; } ?>

                        <div class="text-center">
                            <input class="btn btn-secondary mt-2" type="submit" value="Registrarse">
                        </div>
                   
                    </div>
                </div>
            </form>
        </div>
        
        
        <!-- Pie de página -->
        <div class="fixed-bottom">
            <?php include('..\includes\footer.php')?>
        </div>

    </body>
</html>
