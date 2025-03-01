<?php

// Cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('SERVIDOR', $_ENV['DB_HOST']);
define('USUARIO', $_ENV['DB_USER']);
define('PASS', $_ENV['DB_PASSWORD']);
define('BASE_DATOS', $_ENV['DB_NAME']);

define('BASE_URL', 'http://localhost/DWES/Tienda_Raul_PachecoRopero/');

