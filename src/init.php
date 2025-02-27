<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Obtener la ruta solicitada (sin parámetros GET)
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Rutas donde no se debe cargar header/footer
$excludedRoutes = [
    "/Usuario/login",
    "/Usuario/registro"
];

// Verifica si la ruta actual está en las excluidas
$excludeHeaderFooter = false;
foreach ($excludedRoutes as $route) {
    if (strpos($requestUri, $route) !== false) {
        $excludeHeaderFooter = true;
        break;
    }
}

// Incluir header si no está en las rutas excluidas
if (!$excludeHeaderFooter) {
    require_once './src/Views/layout/header.php';
}

// Cargar enrutador
use Routes\Routes;
Routes::index();  // Ejecutar rutas

// Incluir footer solo si no está en las rutas excluidas
if (!$excludeHeaderFooter) {
    require_once './src/Views/layout/footer.php';
}
?>
