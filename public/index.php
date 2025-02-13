<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Cargar Composer
require_once __DIR__ . '/../config/config.php';  // Cargar configuración
require_once __DIR__ . '/../src/Lib/DBConnection.php'; // Cargar la clase DBConnection

use Lib\DBConnection;

// Crear una instancia de la conexión
$db = new DBConnection();

// Verificar conexión
if ($db) {
    echo "<h2>✅ Conexión exitosa a la base de datos</h2>";

    // Realizar una consulta de prueba
    if ($db->consulta("SELECT DATABASE() AS db_name")) {
        $resultado = $db->extraer_registro();
        echo "<p>📌 Base de datos actual: <strong>" . $resultado['db_name'] . "</strong></p>";
    } else {
        echo "<p>❌ Error en la consulta.</p>";
    }
} else {
    echo "<h2>❌ Error al conectar a la base de datos</h2>";
}

$db->close(); // Cerrar conexión
