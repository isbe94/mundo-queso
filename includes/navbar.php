<?php

   isset($_SESSION['usuario']) ? $postear = 'pages/posts.php' : $postear = 'pages/security/login.php';

?>


<header>
    <nav class="navbar navbar-expand-lg py-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><h4><img class="img-fluid rounded-circle" src="assets/img/14.jpeg"> El Mundo del Queso</h4></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" aria-current="page" href="<?= $postear?>">Postear</a>
                    </li>
                    <?php if (isset($_SESSION['usuario'])){?>
                    <li class="nav-item">
                        <p class="mt-2">Hola, <a class="link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="security/perfil.php"><strong><?php echo $_SESSION['usuario']; ?></strong></a></p>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-semibold" aria-current="page" href="../pages/security/logout.php">Cerrar Sesión</a>
                    </li>
                    <?php }?>
                </ul>
            </div>
        </div>                
    </nav>
</header>