<?php

namespace dwes\app\controllers;

use dwes\app\core\App;
use dwes\app\repository\CardRepository;
use dwes\app\core\Response;
use dwes\app\exceptions\NotFoundException;
use dwes\app\exceptions\AppException;
use dwes\app\core\helpers\FlashMessage;
use dwes\app\utils\File;
use dwes\app\entity\imagen;
use dwes\app\exceptions\QueryException;
use dwes\app\database\QueryBuilder;
use Exception;

class PagesController
{
    /**
     * @throws QueryException
     */
    public function index()
    {
        Response::renderView(
            'index',
            'layout',
        );
    }
    public function cartas()
    {
        // Default values for variables
        $errores = [];
        $imagenes = [];

        try {
            // Query to fetch all images (or cards in your case)
            $queryBuilder = new QueryBuilder('cartas', 'dwes\app\entity\Imagen');
            $imagenes = $queryBuilder->findAll();
        } catch (QueryException $queryException) {
            $errores[] = $queryException->getMessage();
        } catch (Exception $e) {
            $errores[] = $e->getMessage();
        }

        // Render the view and pass the variables
        Response::renderView(
            'cartas',
            'layout',
            compact('errores', 'imagenes')
        );
    }
    public function nueva()
    {
        // Default values for the form fields
        $nombre = '';
        $descripcion = '';
        $categoria = '';
        $precio = 0;
        $errores = FlashMessage::get('new-event-error', []);
        $mensaje = FlashMessage::get('mensaje');

        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the values from the POST request
            $nombre = trim(htmlspecialchars($_POST['nombre']));
            $descripcion = trim(htmlspecialchars($_POST['descripcion']));
            $categoria = trim(htmlspecialchars($_POST['categoria']));
            $precio = trim(htmlspecialchars($_POST['precio']));

            // Additional processing for the file upload and database
            $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
            $imagen = new File('imagen', $tiposAceptados);
            $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_CARTAS);
            App::get('logger')->add("Se ha guardado una imagen: " . $imagen->getFileName());
            $conexion = App::getConnection();
            $sql = "INSERT INTO cartas (nombre, descripcion, imagen, precio, categoria) VALUES (:nombre,:descripcion,:imagen,:precio,:categoria)";
            $pdoStatement = $conexion->prepare($sql);
            $parametros = [
                ':nombre' => $nombre,
                ':descripcion' => $descripcion,
                ':imagen' => $imagen->getFileName(),
                ':precio' => $precio,
                ':categoria' => $categoria
            ];
            if ($pdoStatement->execute($parametros) === false)
                $errores[] = "No se ha podido guardar la imagen en la base de datos";
            else {
                $descripcion = "";
                $mensaje = "Se ha guardado la imagen correctamente";
            }
        }

        // Render the view and pass the variables
        Response::renderView(
            'nueva',
            'layout',
            compact('errores', 'mensaje', 'nombre', 'descripcion', 'categoria', 'precio')
        );
    }
    public function register()
    {
        require __DIR__ . '/register.php';
    }

    public function show($id)
    {
        $imagenesRepository = App::getRepository(CardRepository::class);
        $imagen = $imagenesRepository->find($id);
        Response::renderView(
            'single-card',
            'layout',
            compact('imagen', 'imagenesRepository')
        );
    }
}
