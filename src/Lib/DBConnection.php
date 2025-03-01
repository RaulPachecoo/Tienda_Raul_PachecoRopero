<?php

namespace Lib;

use PDO;
use PDOException;

class DBConnection {
    private ?PDO $conexion = null;  // Almacena la conexión a la base de datos
    private ?\PDOStatement $resultado = null;  // Almacena el resultado de una consulta

    // Constructor que recibe las credenciales de la base de datos
    public function __construct(
        private string $servidor = SERVIDOR,  // Dirección del servidor de base de datos
        private string $usuario = USUARIO,  // Usuario para acceder a la base de datos
        private string $pass = PASS,  // Contraseña para acceder a la base de datos
        private string $base_datos = BASE_DATOS  // Nombre de la base de datos
    ) {
        $this->conexion = $this->conectar();  // Llama al método conectar para establecer la conexión
    }

    // Establece la conexión a la base de datos utilizando PDO
    private function conectar(): ?PDO {
        try {
            // Opciones de configuración de la conexión PDO
            $opciones = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",  // Establece la codificación de caracteres a utf8mb4
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Activa excepciones para errores en consultas
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Establece el modo de recuperación de datos a array asociativo
                PDO::ATTR_EMULATE_PREPARES => false  // Desactiva la emulación de sentencias preparadas para mejorar seguridad
            ];

            // Crea una nueva conexión PDO
            return new PDO(
                "mysql:host={$this->servidor};dbname={$this->base_datos};charset=utf8mb4",  // DSN de conexión
                $this->usuario,  // Usuario para la conexión
                $this->pass,  // Contraseña para la conexión
                $opciones  // Opciones de configuración
            );
        } catch (PDOException $e) {
            // En caso de error de conexión, se registra el error
            error_log("Error de conexión: " . $e->getMessage());
            return null;  // Retorna null si no se pudo conectar
        }
    }

    // Ejecuta una consulta SQL de solo lectura
    public function consulta(string $consultaSQL): bool {
        if (!$this->conexion) {
            return false;  // Si no hay conexión, retorna false
        }
        // Ejecuta la consulta y almacena el resultado
        $this->resultado = $this->conexion->query($consultaSQL);
        // Retorna true si la consulta fue exitosa, false en caso contrario
        return $this->resultado !== false;
    }

    // Extrae un solo registro del resultado de la consulta
    public function extraer_registro(): array|false {
        // Si hay un resultado, se extrae un solo registro, si no, se retorna false
        return $this->resultado ? $this->resultado->fetch() : false;
    }

    // Extrae todos los registros del resultado de la consulta
    public function extraer_todos(): array {
        // Si hay un resultado, se extraen todos los registros, si no, se retorna un array vacío
        return $this->resultado ? $this->resultado->fetchAll() : [];
    }

    // Devuelve la cantidad de filas afectadas por la última consulta
    public function filasAfectadas(): int {
        // Si hay un resultado, se retorna la cantidad de filas afectadas, sino retorna 0
        return $this->resultado ? $this->resultado->rowCount() : 0;
    }

    // Cierra la conexión y limpia el resultado
    public function close(): void {
        $this->conexion = null;  // Cierra la conexión
        $this->resultado = null;  // Limpia el resultado
    }

    // Prepara una consulta SQL para ejecutar de manera segura (sentencia preparada)
    public function prepare(string $sql): ?\PDOStatement {
        // Si la conexión es válida, prepara la sentencia SQL
        return $this->conexion ? $this->conexion->prepare($sql) : null;
    }

    // Devuelve la conexión PDO actual
    public function getConnection(): ?PDO {
        return $this->conexion;
    }

    // Devuelve el último ID insertado en la base de datos
    public function lastInsertId(): ?string {
        // Si hay conexión, retorna el último ID insertado, sino retorna null
        return $this->conexion ? $this->conexion->lastInsertId() : null;
    }
}
