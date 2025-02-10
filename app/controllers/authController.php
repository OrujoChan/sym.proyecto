<?php

namespace dwes\app\controllers;

use dwes\app\core\helpers\FlashMessage;
use dwes\app\core\Response;
use dwes\app\exceptions\ValidationException;
use dwes\app\repository\UsuarioRepository;
use dwes\app\core\App;
use dwes\app\core\Security;
use dwes\app\entity\Usuario;
use dwes\app\utils\File;
use dwes\app\exceptions\FileException;

class authController
{
    public function login()
    {
        $errores = FlashMessage::get('login-error', []);
        $username = FlashMessage::get('username');
        Response::renderView('login', 'layout', compact('errores', 'username'));
    }

    public function logout()
    {
        if (isset($_SESSION['loguedUser'])) {
            $_SESSION['loguedUser'] = null;
            unset($_SESSION['loguedUser']);
        }
        App::get('router')->redirect('login');
    }

    public function checkLogin()
    {
        try {
            if (!isset($_POST['username']) || empty($_POST['username']))
                throw new ValidationException('Debes introducir el usuario y el password');
            FlashMessage::set('username', $_POST['username']);

            if (!isset($_POST['password']) || empty($_POST['password']))
                throw new ValidationException('Debes introducir el usuario y el password');

            $usuario = App::getRepository(UsuarioRepository::class)->findOneBy([
                'username' => $_POST['username']
            ]);
            if (!is_null($usuario) && Security::checkPassword($_POST['password'], $usuario->getPassword())) {
                // Guardamos el usuario en la sesión y redireccionamos a la página principal
                $_SESSION['loguedUser'] = $usuario->getId();
                FlashMessage::unset('username');
                App::get('router')->redirect('cartas');
            }
            throw new ValidationException('El usuario y el password introducidos no existen');
        } catch (ValidationException $validationException) {
            FlashMessage::set('login-error', [$validationException->getMessage()]);
            App::get('router')->redirect('login'); // Redireccionamos al login
        }
    }

    public function registro()
    {
        $errores = FlashMessage::get('registro-error', []);
        $mensaje = FlashMessage::get('mensaje');
        $username = FlashMessage::get('username');
        Response::renderView('registro', 'layout', compact('errores', 'username'));
    }

    public function checkRegistro()
    {
        try {
            session_start();

            if (isset($_POST['captcha']) && ($_POST['captcha'] != "")) {
                if ($_SESSION['captchaGenerado'] != $_POST['captcha']) {
                    throw new ValidationException("¡Ha introducido un código de seguridad incorrecto! Inténtelo de nuevo.");
                }
            } else {
                throw new ValidationException("Introduzca el código de seguridad.");
            }

            if (!isset($_POST['username']) || empty($_POST['username']))
                throw new ValidationException('El nombre de usuario no puede estar vacío');

            FlashMessage::set('username', $_POST['username']);
            if (!isset($_POST['password']) || empty($_POST['password']))
                throw new ValidationException('El password de usuario no puede estar vacío');
            if (!isset($_POST['re-password']) || empty($_POST['re-password']) || $_POST['password'] !== $_POST['re-password'])
                throw new ValidationException('Los dos password deben ser iguales');
            $password = Security::encrypt($_POST['password']);;
            $usuario = new Usuario();
            $usuario->setUsername($_POST['username']);
            $usuario->setRole('ROLE_USER');
            $usuario->setPassword($password);
            App::getRepository(UsuarioRepository::class)->save($usuario);
            FlashMessage::unset('username');
            $mensaje = "Se ha creado el usuario: " . $usuario->getUsername();
            App::get('logger')->add($mensaje);
            FlashMessage::set('mensaje', $mensaje);
            App::get('router')->redirect('login');
        } catch (ValidationException $validationException) {
            FlashMessage::set('registro-error', [$validationException->getMessage()]);
            App::get('router')->redirect('registro');
        }
    }

    public function profile()
    {
        // Check if user is logged in
        if (!isset($_SESSION['loguedUser'])) {
            App::get('router')->redirect('login');
        }

        // Retrieve user information
        $userId = $_SESSION['loguedUser'];
        $usuario = App::getRepository(UsuarioRepository::class)->find($userId);

        if (!$usuario) {
            throw new \Exception("Usuario no encontrado.");
        }

        // Render the profile view with the user data
        Response::renderView('profile', 'layout', [
            'username' => $usuario->getUsername(),
            'imagen' => $usuario->getImagen(),
        ]);
    }

    public function editProfilePicture()
    {
        if (!isset($_SESSION['loguedUser'])) {
            App::get('router')->redirect('login');
        }

        $userId = $_SESSION['loguedUser'];
        $usuario = App::getRepository(UsuarioRepository::class)->find($userId);

        Response::renderView('edit-profile-picture', 'layout', compact('usuario'));
    }

    public function updateProfilePicture()
    {
        try {

            if (!isset($_SESSION['loguedUser'])) {
                throw new ValidationException("No user is logged in.");
            }

            $usuarioId = $_SESSION['loguedUser'];
            $usuarioRepo = App::getRepository(UsuarioRepository::class);
            $usuario = $usuarioRepo->find($usuarioId);

            if (!$usuario) {
                throw new ValidationException("User not found.");
            }

            // Check if a file was uploaded
            if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
                throw new FileException("Error uploading file.");
            }

            $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
            $nuevaImagen = new File('imagen', $tiposAceptados);
            $nuevaImagen->saveUploadFile(Usuario::RUTA_IMAGENES_PERFIL);

            // Delete previous image if it exists
            $rutaImagenAnterior = $_SERVER['DOCUMENT_ROOT'] . Usuario::RUTA_IMAGENES_PERFIL . $usuario->getImagen();
            if (is_file($rutaImagenAnterior) && !empty($usuario->getImagen())) {
                unlink($rutaImagenAnterior);
            }

            // Update user image in database
            $usuario->setImagen($nuevaImagen->getFileName());
            $usuarioRepo->update($usuario);

            FlashMessage::set('success', "Imagen de perfil actualizada correctamente.");
            App::get('router')->redirect('profile');
        } catch (FileException $fileException) {
            FlashMessage::set('error', $fileException->getMessage());
            App::get('router')->redirect('profile/edit-picture');
        } catch (ValidationException $validationException) {
            FlashMessage::set('error', $validationException->getMessage());
            App::get('router')->redirect('profile/edit-picture');
        }
    }

    public function editProfileUsername()
    {
        if (!isset($_SESSION['loguedUser'])) {
            App::get('router')->redirect('login');
        }

        $userId = $_SESSION['loguedUser'];
        $usuario = App::getRepository(UsuarioRepository::class)->find($userId);

        Response::renderView('edit-profile-username', 'layout', compact('usuario'));
    }

    public function updateUsername()
    {
        try {
            if (!isset($_SESSION['loguedUser'])) {
                throw new ValidationException("No user is logged in.");
            }

            $usuarioId = $_SESSION['loguedUser'];
            $usuarioRepo = App::getRepository(UsuarioRepository::class);
            $usuario = $usuarioRepo->find($usuarioId);

            if (!$usuario) {
                throw new ValidationException("User not found.");
            }

            // Validate new username
            if (!isset($_POST['username']) || empty($_POST['username'])) {
                throw new ValidationException("El nombre de usuario no puede estar vacío.");
            }

            $newUsername = $_POST['username'];

            // Check if the new username already exists
            $existingUser = $usuarioRepo->findOneBy(['username' => $newUsername]);
            if ($existingUser && $existingUser->getId() !== $usuario->getId()) {
                throw new ValidationException("El nombre de usuario ya está en uso.");
            }

            // Update the username in the database
            $usuario->setUsername($newUsername);
            $usuarioRepo->update($usuario);

            // Update the session with the new username
            $_SESSION['loguedUser'] = $usuario->getId(); // Make sure the session is still valid

            // Set a success message
            FlashMessage::set('success', "Nombre de usuario actualizado correctamente.");
            App::get('router')->redirect('profile');
        } catch (ValidationException $validationException) {
            FlashMessage::set('error', $validationException->getMessage());
            App::get('router')->redirect('profile/edit-username');
        }
    }
}
