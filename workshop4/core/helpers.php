<?php

/**
 * Construye la URL de una ruta de la aplicación, ej: url('courses/edit', ['id' => 3])
 */
function url(string $route, array $params = []): string
{
    $url = '/index.php?route=' . $route;
    return $params ? $url . '&' . http_build_query($params) : $url;
}

/**
 * Redirige a una ruta de la aplicación y termina la ejecución
 */
function redirect(string $route, array $params = []): void
{
    header('Location: ' . url($route, $params));
    exit;
}

/**
 * Escapa un valor para imprimirlo de forma segura en HTML
 */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/**
 * Indica si la ruta actual es alguna de las indicadas (se usa para marcar la pestaña activa del menú)
 */
function isRoute(string ...$routes): bool
{
    return in_array(currentRoute(), $routes, true);
}

function currentRoute(): string
{
    $route = $_GET['route'] ?? 'login';
    return is_string($route) ? trim($route, '/') : 'login';
}
