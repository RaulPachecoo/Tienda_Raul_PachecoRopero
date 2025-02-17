<?php

use Dotenv\Dotenv;

// Cargar el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Definir constantes usando los valores del .env
define('SERVIDOR', $_ENV['DB_HOST'] ?? 'localhost');
define('USUARIO', $_ENV['DB_USER'] ?? 'root');
define('PASS', $_ENV['DB_PASSWORD'] ?? '');
define('BASE_DATOS', $_ENV['DB_NAME'] ?? 'tienda');

// Otras configuraciones
define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://localhost/DWES/Tienda_Ra%c3%bal_PachecoRopero/');
define('CONTROLLER_DEFAULT', $_ENV['CONTROLLER_DEFAULT'] ?? 'usuarioController');
define('ACTION_DEFAULT', $_ENV['ACTION_DEFAULT'] ?? 'registro');
