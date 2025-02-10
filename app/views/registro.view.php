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

    <div id="login" class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="container">
            <div class="col-md-6 offset-md-3">
                <div class="card shadow-lg border-0 rounded-lg p-4">
                    <h2 class="text-center text-success">Registro</h2>
                    <hr>
                    <?php include __DIR__ . '/show-error.part.view.php' ?>
                    <form class="form-horizontal" action="/check-registro" method="post">
                        <div class="form-group">
                            <label class="label-control">Username</label>
                            <input class="form-control" type="text" name="username" value="<?= $username ?? '' ?>">
                        </div>
                        <div class="form-group">
                            <label class="label-control">Password</label>
                            <input class="form-control" name="password" type="password">
                        </div>
                        <div class="form-group">
                            <label class="label-control">Repeat password</label>
                            <input class="form-control" name="re-password" type="password">
                        </div>
                        <div class="form-group text-center">
                            <label class="label-control d-block">Insert Captcha</label>
                            <img class="border rounded mb-2" src="/app/utils/captcha.php" id='captcha'>
                            <input class="form-control text-center" name="captcha" type="text">
                        </div>
                        <button class="btn btn-success btn-lg btn-block">ENVIAR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>