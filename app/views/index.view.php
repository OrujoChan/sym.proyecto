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


    <?php require_once __DIR__ . '/nav.part.php'; ?>





    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <h1 class="text-primary mb-3"><span class="fw-light text-dark">From Our</span> Blog Articles</h1>
                <p class="mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat, nibh erat tempus risus.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="blog-item border h-100 p-4">
                        <img class="img-fluid mb-4" src="../public/img/blog-1.jpg" alt="">
                        <a href="" class="h5 lh-base d-inline-block">Foods that are good for your hair growing</a>
                        <div class="d-flex text-black-50 mb-2">
                            <div class="pe-3">
                                <small class="fa fa-eye me-1"></small>
                                <small>9999 Views</small>
                            </div>
                            <div class="pe-3">
                                <small class="fa fa-comments me-1"></small>
                                <small>9999 Comments</small>
                            </div>
                        </div>
                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat.</p>
                        <a href="" class="btn btn-outline-primary px-3">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="blog-item border h-100 p-4">
                        <img class="img-fluid mb-4" src="../public/img/blog-2.jpg" alt="">
                        <a href="" class="h5 lh-base d-inline-block">How to take care of hair naturally</a>
                        <div class="d-flex text-black-50 mb-2">
                            <div class="pe-3">
                                <small class="fa fa-eye me-1"></small>
                                <small>9999 Views</small>
                            </div>
                            <div class="pe-3">
                                <small class="fa fa-comments me-1"></small>
                                <small>9999 Comments</small>
                            </div>
                        </div>
                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat.</p>
                        <a href="" class="btn btn-outline-primary px-3">Read More</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="blog-item border h-100 p-4">
                        <img class="img-fluid mb-4" src="../public/img/blog-3.jpg" alt="">
                        <a href="" class="h5 lh-base d-inline-block">How to use our natural & organic shampoo</a>
                        <div class="d-flex text-black-50 mb-2">
                            <div class="pe-3">
                                <small class="fa fa-eye me-1"></small>
                                <small>9999 Views</small>
                            </div>
                            <div class="pe-3">
                                <small class="fa fa-comments me-1"></small>
                                <small>9999 Comments</small>
                            </div>
                        </div>
                        <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aliquet, erat non malesuada consequat.</p>
                        <a href="" class="btn btn-outline-primary px-3">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->





    <?php require_once __DIR__ . '/footer.part.php'; ?>



    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>