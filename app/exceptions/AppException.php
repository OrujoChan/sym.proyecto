<?php

namespace dwes\app\exceptions;

use dwes\app\core\Response;
use Exception;

class AppException extends Exception
{
    public function __construct(string $message = "", int $code = 500)
    {
        parent::__construct($message, $code);
    }
    private function getHttpHeaderMessage()
    {
        switch ($this->getCode()) {
            case 404:
                return '404 Página no encontrada';
            case 403:
                return '403 Prohibido el acceso';
            case 500:
                return '500 Error interno del servidor';
        }
    }
    public function handleError()
    {
        try {
            $httpHeaderMessage = $this->getHttpHeaderMessage();
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $httpHeaderMessage, true, $this->getCode());
            $errorMessage = $this->getMessage();
            Response::renderView(
                'error',
                'layout',
                compact('httpHeaderMessage', 'errorMessage')
            );
        } catch (Exception $exception) {
            die('Se ha producido un error en nuestro manejador de excepciones');
        }
    }
}
