<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MagicDB - Trade your cards</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


    <?php require_once __DIR__ . '/header.part.php'; ?>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->



    <div class="container-fluid bg-primary hero-header mb-5">
        <div class="container text-center">
            <h1 class="display-4 text-white mb-3 animated slideInDown">Añadir carta</h1>
        </div>
    </div>




    <div class="container-fluid py-5">
        <div class="container">
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
                <div class="alert alert-<?= empty($errores) ? 'info' : 'danger'; ?> alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                    <?php if (empty($errores)) : ?>
                        <p><?= $mensaje ?></p>
                    <?php else : ?>
                        <ul>
                            <?php foreach ($errores as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <form class="form-horizontal" action="/nueva" method="post"
                enctype="multipart/form-data">
                <div class="form-group">
                    <div class="col-xs-12">
                        <label class="label-control">Imagen</label>
                        <input class="form-control-file" type="file" name="imagen" id="imagen">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label class="label-control">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $nombre ?> ">
                        <label class="label-control">Categoria</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" value="<?= $categoria ?> ">
                        <label class="label-control">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="<?= $precio ?> ">
                        <label class="label-control">Descripción</label>
                        <textarea class="form-control" name="descripcion"><?= $descripcion ?></textarea>
                        <button class="pull-right btn btn-lg sr-button">ENVIAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





    <?php require_once __DIR__ . '/footer.part.php'; ?>

    <script src="../js/main.js"></script>
</body>

</html>