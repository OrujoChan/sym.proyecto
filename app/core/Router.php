<?php

namespace dwes\app\core;

use dwes\app\exceptions\NotFoundException;
use dwes\app\exceptions\AuthenticationException;

class Router
{
    private $routes;

    private function __construct()
    {
        $this->routes = [
            'GET' => [],
            'POST' => []
        ];
    }

    public function get(string $uri, string $controller, $role = 'ROLE_ANONYMOUS'): void
    {
        $this->routes['GET'][$uri] = [
            'controller' => $controller,
            'role' => $role
        ];
    }
    public function post(string $uri, string $controller, $role = 'ROLE_ANONYMOUS'): void
    {
        $this->routes['POST'][$uri] = [
            'controller' => $controller,
            'role' => $role
        ];
    }

    public function redirect(string $path)
    {
        header('location: /' . $path);
        exit();
    }

    /**
     * @return Router
     */
    public static function load(string $file): Router
    {
        $router = new Router();
        require $file;
        return $router;
    }

    public function direct(string $uri, string $method): void
    {
        // Recorremos las rutas y separamos las dos partes: las rutas y sus controladores respectivamente
        foreach ($this->routes[$method] as $route => $routerData) {
            $controller = $routerData['controller'];
            $minRole = $routerData['role'];
            // Se cambia el contenido de la ruta por una forma que nos vendrá mejor
            $urlRule = $this->prepareRoute($route);
            if (preg_match($urlRule, $uri, $matches) === 1) {
                if (Security::isUserGranted($minRole) === false) {
                    if (!is_null(App::get('appUser'))) // Comprobamos si se está logueado
                        throw new AuthenticationException('Acceso no autorizado');
                    else
                        $this->redirect('login');
                } else {
                    $parameters = $this->getParametersRoute($route, $matches);
                    // Extraemos el nombre del controlador (nombre de la clase) del nombre del
                    // action (nombre del método a llamar) y los pasamos a 2 variables
                    list($controller, $action) = explode('@', $controller);
                    // Se encarga de crear un objeto de la clase controller y llama al action adecuado
                    if ($this->callAction($controller, $action, $parameters) === true)
                        return;
                }
            }
        }
        throw new NotFoundException("No se ha definido una ruta para la uri solicitada");
    }

    private function callAction(string $controller, string $action, array $parameters): bool
    {
        try {
            $controller = App::get('config')['project']['namespace'] . '\\app\\controllers\\' . $controller;
            $objController = new $controller();
            if (!method_exists($objController, $action))
                throw new NotFoundException("El controlador $controller no responde al action $action");
            // Llamamo al action del controlador pasándole los parámetros
            call_user_func_array(array($objController, $action), $parameters);
            return true;
        } catch (\TypeError $typeError) {
            return false;
        }
    }

    private function prepareRoute(string $route): string
    {
        // Convert parameters like ":id" into named capturing groups "(?P<id>[^/]+)"
        $urlRule = preg_replace('/:([^\/]+)/', '(?P<$1>[^/]+)', $route);

        // Ensure slashes are correctly escaped
        $urlRule = str_replace('/', '\/', $urlRule);


        // Correct regex format for matching URIs
        return '/^' . $urlRule . '$/';
    }
    private function getParametersRoute(string $route, array $matches)
    {
        preg_match_all('/:([^\/]+)/', $route, $parameterNames);
        $parameterNames = array_flip($parameterNames[1]);
        // Obtenemos el array de parámetros que hay que pasar al controlador
        return array_intersect_key($matches, $parameterNames);
    }
}
