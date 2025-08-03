<?php
ob_start();
session_start();

require_once __DIR__ . '/../config/config.php';

include BASE_PATH . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Anónimo';
    $fecha = date('Y-m-d H:i:s');
    $likes = rand(1, 50);
    $totalLikes += $likes;
    $totalComentarios = rand(0, 20);

    $imagenNombre = '';
    $rutaImagen = '';

    // Manejo de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorioSubida = BASE_PATH . '/assets/uploads/';
        if (!file_exists($directorioSubida)) {
            mkdir($directorioSubida, 0755, true);
        }

        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagenNombre = uniqid('img_') . '.' . $extension;
        $rutaImagen = $directorioSubida . $imagenNombre;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
    }

    // Guardar en CSV
    $archivoCSV = BASE_PATH . '/pages/posts.csv';
    if (!file_exists(dirname($archivoCSV))) {
        mkdir(dirname($archivoCSV), 0755, true);
    }

    $fila = [$fecha, $usuario, $titulo, $descripcion, $imagenNombre, $totalLikes, $totalComentarios];
    $f = fopen($archivoCSV, 'a');
    fputcsv($f, $fila);
    fclose($f);

    header("Location: " . BASE_URL . "pages/security/perfil.php");
    exit;
}
?>

<div class="container py-5 container_posts">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
            <h2 class="fw-bold mb-3 text-dark">Crea una Nueva Publicación</h2>
            <p class="text-muted">Comparte tu receta de queso con la comunidad</p>
        </div>
    </div>

    <form action="" method="post" enctype="multipart/form-data" class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="imagen" class="form-label fw-semibold">Imagen de la receta</label>
                        <div class="mb-3 border rounded p-2 text-center shadow-sm bg-light">
                            <img src="<?= BASE_URL ?>assets/img/img.jpg" class="img-fluid rounded" alt="Vista previa" style="max-height: 200px;">
                        </div>
                        <input type="file" name="imagen" id="imagen" class="form-control">
                    </div>
                </div>

                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div class="form-group">
                        <label for="titulo" class="form-label fw-semibold">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>

                    <div class="form-group mt-4">
                        <label for="floatingTextarea" class="form-label fw-semibold">Descripción</label>
                        <textarea class="form-control" placeholder="Describe tu receta..." name="descripcion" id="floatingTextarea" style="height: 120px;"></textarea>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" name="submit" class="btn btn-lg btn-primary px-5 shadow">
                    Publicar
                </button>
            </div>
        </div>
    </form>
</div>

<?php include BASE_PATH . '/includes/footer.php'; ?>