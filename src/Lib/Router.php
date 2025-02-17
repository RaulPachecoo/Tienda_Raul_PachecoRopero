<?php
namespace Lib;

class Router {   

    private static array $routes = [];

    /**
     * Agrega una ruta al enrutador
     * 
     * @param string $method Método HTTP (GET, POST, etc.)
     * @param string $action Ruta asociada
     * @param callable $controller Función a ejecutar
     */
    public static function add(string $method, string $action, Callable $controller):void{
        //die($action);
        $action = trim($action, '/');
       
        self::$routes[$method][$action] = $controller;
       
    }

    /**
     * Procesa la solicitud actual y ejecuta la ruta correspondiente
     */
    public static function dispatch():void {
        $method = $_SERVER['REQUEST_METHOD']; 
        //print_r($_SERVER);die($method);
        $action = preg_replace('/Tienda/','',$_SERVER['REQUEST_URI']);
       //$_SERVER['REQUEST_URI'] almacena la cadena de texto que hay después del nombre del host en la URL
        $action = trim($action, '/');
        $param = null;
        preg_match('/[0-9]+$/', $action, $match);
        if(!empty($match)){
            $param = $match[0];
            $action=preg_replace('/'.$match[0].'/',':id',$action);//quitamos la primera parte que se repite siempre (clinicarouter)
        }
        $fn = self::$routes[$method][$action] ??null;
        if ($fn) {
            $callback = self::$routes[$method][$action];

            echo call_user_func($callback, $param);
        }

    }
}
?>
