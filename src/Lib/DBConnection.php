<?php

namespace Lib;

use PDO;
use PDOException;

class DBConnection {
    private ?PDO $conexion = null;
    private ?\PDOStatement $resultado = null;

    public function __construct(
        private string $servidor = SERVIDOR,
        private string $usuario = USUARIO,
        private string $pass = PASS,
        private string $base_datos = BASE_DATOS
    ) {
        $this->conexion = $this->conectar();
    }

    private function conectar(): ?PDO {
        try {
            $opciones = [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Activa excepciones
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retorno por defecto como array asociativo
                PDO::ATTR_EMULATE_PREPARES => false  // Mejora seguridad en consultas preparadas
            ];

            return new PDO(
                "mysql:host={$this->servidor};dbname={$this->base_datos};charset=utf8mb4",
                $this->usuario,
                $this->pass,
                $opciones
            );
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            return null;  // No detener la ejecución en producción
        }
    }

    public function consulta(string $consultaSQL): bool {
        if (!$this->conexion) {
            return false;
        }
        $this->resultado = $this->conexion->query($consultaSQL);
        return $this->resultado !== false;
    }

    public function extraer_registro(): array|false {
        return $this->resultado ? $this->resultado->fetch() : false;
    }

    public function extraer_todos(): array {
        return $this->resultado ? $this->resultado->fetchAll() : [];
    }

    public function filasAfectadas(): int {
        return $this->resultado ? $this->resultado->rowCount() : 0;
    }

    public function close(): void {
        $this->conexion = null;
        $this->resultado = null;
    }

    public function prepare(string $sql): ?\PDOStatement {
        return $this->conexion ? $this->conexion->prepare($sql) : null;
    }
}
