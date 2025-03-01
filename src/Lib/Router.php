<?php

namespace Lib;

use Controllers\CategoriaController;

class Router
{
    // Almacena las rutas disponibles y sus respectivos controladores
    private static $routes = [];

    /**
     * Registra una nueva ruta en el enrutador.
     *
     * @param string $method Método HTTP (GET, POST, etc.)
     * @param string $action Ruta específica a la que se accede.
     * @param callable $controller Función de controlador asociada a la ruta.
     */
    public static function add(string $method, string $action, callable $controller): void
    {
        // Elimina las barras inclinadas al principio y al final de la acción
        $action = trim($action, '/');
        
        // Registra la ruta en el arreglo estático según el método HTTP y la acción
        self::$routes[$method][$action] = $controller;
    }

    /**
     * Procesa la solicitud entrante y llama al controlador correspondiente.
     */
    public static function dispatch(): void
    {
        // Obtiene el método de la solicitud (GET, POST, etc.)
        $method = $_SERVER['REQUEST_METHOD'];

        // Obtiene la URI completa de la solicitud
        $fullAction = $_SERVER['REQUEST_URI'];

        // Define la ruta base de la aplicación (se utiliza para remover cualquier prefijo de la URL)
        $basePath = "/DWES/Tienda_Raul_PachecoRopero";
        
        // Obtiene solo la parte de la acción (ruta) de la URL
        $action = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Si la URL contiene la ruta base, la elimina de la acción
        if (strpos($action, $basePath) === 0) {
            $action = substr($action, strlen($basePath));
        }

        // Elimina las barras inclinadas al principio y al final de la acción
        $action = trim($action, '/');

        // Verifica si no hay sesión de usuario activa, pero existe una cookie con el correo del usuario
        if (!isset($_SESSION['login']) && isset($_COOKIE['user_email'])) {
            // Crea un modelo de usuario con el correo almacenado en la cookie
            $usuarioModel = new \Models\Usuario(null, '', '', $_COOKIE['user_email'], '', '');
            
            // Busca al usuario en la base de datos por su correo
            $user = $usuarioModel->getByEmail($_COOKIE['user_email']);
            
            // Si se encuentra un usuario, se inicia la sesión
            if ($user) {
                $_SESSION['login'] = $user;
            }
        }

        // Si la ruta está registrada en las rutas disponibles, ejecuta el controlador correspondiente
        if (isset(self::$routes[$method][$action])) {
            // Llama al controlador de la ruta utilizando call_user_func
            echo call_user_func(self::$routes[$method][$action]);
        } else {
            // Si la ruta no está registrada, muestra un mensaje de error 404
            echo "404 - Ruta no encontrada<br>";
        }
    }
}