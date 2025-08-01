<?php
session_start();


include '../includes/header.php';
include '../includes/navbar.php'; ?>
?>


<div class="container container_posts">
    <div class="row mb-4">
        <h4 class="fw-bold text-center">Crea una Nueva Publicación</h4>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group mb-3">

                    <img src="img/img.jpg" class="" alt="">
                    <input type="file" name="imagen" id="imagen" class="form-control">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="titulo" class="">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" require>
                </div>
                <div class="form-group mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"
                            style="height: 100px"></textarea>
                        <label for="floatingTextarea">Descripción</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-secondary">Publicar</button>
        </div>
    </form>
</div>


<?php include '../includes/footer.php' ?>