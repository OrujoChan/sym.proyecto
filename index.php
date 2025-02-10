<?php
require_once __DIR__ . '/vendor/autoload.php';

use dwes\app\core\App;
use dwes\app\exceptions\NotFoundException;
use dwes\app\core\Request;
use dwes\app\exceptions\AppException;

try {
    require_once 'app/core/bootstrap.php';
    App::get('router')->direct(Request::uri(), Request::method());
} catch (AppException $AppException) {
    $AppException->handleError();
}
