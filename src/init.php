<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Obtener la URL solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$excludedRoutes = [
    "/DWES/Tienda_Raul_PachecoRopero/Usuario/login",
    "/DWES/Tienda_Raul_PachecoRopero/Usuario/registro"
];

// Solo incluir header y footer si la página NO es login ni registro
if (!in_array($requestUri, $excludedRoutes)) {
    require_once './src/Views/layout/header.php';  // Incluir header
}

// Cargar enrutador
use Routes\Routes;
Routes::index();  // Ejecutar rutas

// Solo incluir footer si la página NO es login ni registro
if (!in_array($requestUri, $excludedRoutes)) {
    require_once './src/Views/layout/footer.php';  // Incluir footer
}
?>
