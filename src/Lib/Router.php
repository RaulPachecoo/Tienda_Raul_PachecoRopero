<?php

namespace Lib;

class Router
{
    private static $routes = [];

    public static function add(string $method, string $action, callable $controller): void
    {
        $action = trim($action, '/');
        self::$routes[$method][$action] = $controller;
    }

    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $fullAction = $_SERVER['REQUEST_URI'];

        $basePath = "/DWES/Tienda_Raul_PachecoRopero";
        $action = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Elimina el basePath solo si está presente
        if (strpos($action, $basePath) === 0) {
            $action = substr($action, strlen($basePath));
        }

        $action = trim($action, '/');

        if (isset(self::$routes[$method][$action])) {
            echo call_user_func(self::$routes[$method][$action]);
        } else {
            echo "404 - Ruta no encontrada<br>";
        }
    }
}
