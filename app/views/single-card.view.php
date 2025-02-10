<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <title>MagicDB - Trade your cards</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Poppins:wght@200;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../public/lib/animate/animate.min.css" rel="stylesheet">
    <link href="../public/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../public/css/style.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="col-mb-2 md-2">
            <div class="card shadow">
                <img src="/public/img/cartas/<?= $imagen->getImagen() ?>"
                    class="card-img-top"
                    alt="<?= $imagen->getDescripcion() ?>"
                    title="<?= $imagen->getDescripcion() ?>">
                <div class=" card-body">
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
        <button onclick="window.history.back();" class="btn btn-primary m-4">Go Back</button>
    </div>








    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>