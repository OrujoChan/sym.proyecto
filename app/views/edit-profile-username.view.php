<?php

use dwes\app\core\helpers\FlashMessage; ?>

<div id="profile-username-update" class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-lg p-4">
                    <h2 class="text-center text-primary">Cambiar Nombre de Perfil</h2>
                    <hr>
                    <form action="/profile/update-username" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="username" class="form-label">Selecciona un nuevo nombre de usuario:</label>
                            <input class="form-control" type="text" name="username" id="username"
                                required value="<?php echo isset($usuario) ? $usuario->getUsername() : ''; ?>">
                        </div>
                        <button class="btn btn-primary btn-lg btn-block mt-3">Actualizar</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/profile" class="btn btn-outline-secondary">Volver al perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>