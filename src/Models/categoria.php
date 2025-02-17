<?php

namespace Models; 
use Lib\DBConnection; 
use PDO; 
use PDOException;

class Categoria {
    private int $id; 
    private string $nombre; 
    private DBConnection $db; 

    public function __construct() {
        $this->db = new DBConnection(); 
    }

    // Getters y Setters
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    public static function getAll(): array {
        try {
            $db = new DBConnection(); // Crear la conexión correctamente
            $stmt = $db->prepare("SELECT * FROM categorias ORDER BY id DESC");
            $stmt->execute();
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
    
            return $categorias; // Devuelve [] si no hay categorías
        } catch (PDOException $e) {
            error_log("Error en getAll(): " . $e->getMessage()); // Registrar el error
            return []; // Devuelve un array vacío en caso de error
        }
    }
    

    public function createCategoria(string $nombre): bool {
        try {
            $stmt = $this->db->prepare("SELECT 1 FROM categorias WHERE nombre = :nombre");
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                $insert = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
                $insert->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $insert->execute();
                $insert->closeCursor();
            }
            $stmt->closeCursor();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public static function getCategoriaById(int $id): array|false {
        $categoria = new self();
        try {
            $stmt = $categoria->db->prepare("SELECT * FROM categorias WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $result ?: false;
        } catch (PDOException) {
            return false;
        }
    }

    public function updateCategoria(int $id, string $nombre): bool {
        try {
            $stmt = $this->db->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id");
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException) {
            return false;
        }
    }

    public function deleteCategoria(int $id): bool {
        try {
            $producto = new Producto();
            $productos = $producto->getProductosByCategoria($id);
            foreach ($productos as $item) {
                $producto->deleteProducto($item['id']);
            }
            $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException) {
            return false;
        }
    }
}
