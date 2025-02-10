<!-- Navbar Start -->
<div class="container-fluid sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <a href="/cartas" class="navbar-brand">
                <h2 class="text-white">MagicDB</h2>
            </a>
            <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                    <a href="/cartas" class="nav-item nav-link active">Home</a>
                    <a href="/nueva" class="nav-item nav-link active">Añadir</a>

                    <?php if (is_null($app['user'])) : ?>
                        <a href="/login" class="nav-item nav-link">Login</a>
                        <a href="/registro" class="nav-item nav-link">Register</a>

                    <?php else : ?>
                        <a href="/profile" class="nav-item nav-link">Perfil</a>
                        <a href="/logout" class="nav-item nav-link">
                            Logout - <?= $app['user']->getUsername() ?>
                        </a>
                    <?php endif; ?>

                </div>
                <a href="" class="btn btn-dark py-2 px-4 d-none d-lg-inline-block">Shop Now</a>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->