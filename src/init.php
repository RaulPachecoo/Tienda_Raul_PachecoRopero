<?php
// Cargar el autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

// Cargar configuración
require_once __DIR__ . '/../config/config.php';
require_once 'Views/layout/header.php';
require_once 'Views/layout/footer.php';  

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Cargar enrutador principal
use Routes\Routes;
Routes::index();
?>
