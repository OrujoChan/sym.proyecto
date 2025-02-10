<div id="profile-picture-update" class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-lg p-4">
                    <h2 class="text-center text-primary">Cambiar Imagen de Perfil</h2>
                    <hr>
                    <form action="/profile/update-picture" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="imagen" class="form-label">Selecciona una imagen:</label>
                            <input class="form-control" type="file" name="imagen" id="imagen" required>
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