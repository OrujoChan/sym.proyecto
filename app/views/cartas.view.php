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







    <!-- Hero Start -->
    <div class="container-fluid bg-primary hero-header mb-5">
        <div class="container text-center">
            <h1 class="display-4 text-white mb-3 animated slideInDown">Base de datos de cartas</h1>
        </div>
    </div>
    <!-- Hero End -->

    <?php if (!empty($errores)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errores as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row">
            <?php foreach ($imagenes as $imagen) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <a href="cartas/<?= $imagen->getId() ?>"><img src="/public/img/cartas/<?= $imagen->getImagen() ?>"
                                class="card-img-top"
                                alt="<?= $imagen->getDescripcion() ?>"
                                title="<?= $imagen->getDescripcion() ?>"></a>
                        <div class="card-body">
                            <h5 class="card-title"><?= $imagen->getNombre() ?></h5>
                            <p class="card-text"><strong>Categoría:</strong> <?= $imagen->getCategoria() ?></p>
                            <p class="card-text"><strong>Descripción:</strong> <?= $imagen->getDescripcion() ?></p>
                            <p class="card-text"><strong>Precio:</strong> <?= number_format($imagen->getPrecio(), 2) ?> €</p>
                            <p class="card-text"><strong>Fecha de adición:</strong>
                                <?= $imagen->getFechaAdicion() ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>





    <?php require_once __DIR__ . '/footer.part.php'; ?>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>