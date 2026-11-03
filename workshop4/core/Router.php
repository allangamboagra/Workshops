<?php

/**
 * Asocia cada ruta (método HTTP + nombre) con el método de un controlador
 */
class Router
{
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $route, string $controller, string $action): void
    {
        $this->routes['GET'][$route] = [$controller, $action];
    }

    public function post(string $route, string $controller, string $action): void
    {
        $this->routes['POST'][$route] = [$controller, $action];
    }

    public function dispatch(string $method, string $route): void
    {
        $handler = $this->routes[$method][$route] ?? null;

        if ($handler === null) {
            http_response_code(404);
            exit('Page not found.');
        }

        [$controllerClass, $action] = $handler;
        require_once BASE_PATH . '/controllers/' . $controllerClass . '.php';

        (new $controllerClass())->$action();
    }
}
