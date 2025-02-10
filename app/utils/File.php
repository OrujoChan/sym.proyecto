<?php

namespace dwes\app\utils;

use dwes\app\exceptions\FileException;
use Exception;

class File
{


    private $file;
    private $fileName;

    /**
     * param string $fileName
     * param array $arrTypes
     * @throws FileException
     */
    public function __construct(string $fileName, array $arrTypes)
    {
        $this->file = $_FILES[$fileName];
        $this->fileName = '';
        if (!isset($this->file)) {

            throw new Exception('Error en la subida');
        }
        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            switch ($this->file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    // Error de tamaño
                    throw new FileException('Error de tamaño');
                case UPLOAD_ERR_PARTIAL:
                    // Error de archivo incompleto
                    throw new FileException('Error de archivo incompleto');
                default:
                    // Error en la subida
                    throw new FileException('Error en la subida');
                    break;
            }
            if (in_array($this->file['type'], $arrTypes) === false) {
                // Error de tipo
                throw new FileException('Error de tipo');
            }
        }
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function saveUploadFile(string $rutaDestino)
    {
        if (is_uploaded_file($this->file['tmp_name']) === false)
            throw new FileException('El archivo no ha sido subido mediante un formulario.');
        $this->fileName = $this->file['name'];
        $ruta = $rutaDestino . $this->fileName;
        if (is_file($ruta) === true) {
            $idUnico = time();
            $this->fileName = $idUnico . "_" . $this->fileName;
            $ruta = $rutaDestino . $this->fileName;
        }
        if (
            move_uploaded_file($this->file['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' . $ruta) ===
            false
        )
            throw new FileException('No se puede mover el archivo a su destino');
    }
}
