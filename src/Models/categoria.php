<?php

namespace Models; 
use Lib\DBConnection; 
use PDO; 
use PDOException;

class Categoria {
    private int $id; // Identificador único de la categoría
    private string $nombre; // Nombre de la categoría
    private DBConnection $db; // Instancia de la clase DBConnection para realizar consultas a la base de datos

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        $this->db = new DBConnection(); // Crea una nueva instancia de DBConnection
    }

    // Getter para el id de la categoría
    public function getId(): int {
        return $this->id; // Devuelve el id de la categoría
    }

    // Setter para el id de la categoría
    public function setId(int $id): self {
        $this->id = $id; // Establece el id de la categoría
        return $this; // Permite encadenar métodos
    }

    // Getter para el nombre de la categoría
    public function getNombre(): string {
        return $this->nombre; // Devuelve el nombre de la categoría
    }

    // Setter para el nombre de la categoría
    public function setNombre(string $nombre): self {
        $this->nombre = $nombre; // Establece el nombre de la categoría
        return $this; // Permite encadenar métodos
    }

    // Método estático para obtener todas las categorías
    public static function getAll(): array {
        try {
            $db = new DBConnection(); // Crear la conexión a la base de datos
            $stmt = $db->prepare("SELECT * FROM categorias ORDER BY id DESC"); // Prepara la consulta SQL
            $stmt->execute(); // Ejecuta la consulta
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los resultados como un array asociativo
            $stmt->closeCursor(); // Cierra el cursor después de la ejecución

            return $categorias; // Devuelve las categorías, o un array vacío si no hay categorías
        } catch (PDOException $e) {
            error_log("Error en getAll(): " . $e->getMessage()); // Registra cualquier error en el log
            return []; // Devuelve un array vacío si ocurre un error
        }
    }

    // Método para crear una nueva categoría
    public function createCategoria(string $nombre): bool {
        try {
            // Verifica si la categoría ya existe
            $stmt = $this->db->prepare("SELECT 1 FROM categorias WHERE nombre = :nombre");
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR); // Asocia el parámetro :nombre
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $stmt->closeCursor(); // Cierra el cursor si la categoría ya existe
                return false; // La categoría ya existe, no se puede crear
            }

            $stmt->closeCursor(); // Cierra el cursor después de la comprobación
            // Si la categoría no existe, procede a crearla
            $insert = $this->db->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
            $insert->bindValue(':nombre', $nombre, PDO::PARAM_STR); // Asocia el parámetro :nombre
            $insert->execute(); // Ejecuta la consulta de inserción
            $insert->closeCursor(); // Cierra el cursor después de la inserción
            return true; // La categoría se ha creado correctamente
        } catch (PDOException) {
            return false; // En caso de error, retorna false
        }
    }

    // Método estático para obtener una categoría por su id
    public static function getCategoriaById(int $id): array|false {
        $categoria = new self(); // Crea una instancia de la clase Categoria
        try {
            // Prepara la consulta para obtener la categoría por id
            $stmt = $categoria->db->prepare("SELECT * FROM categorias WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Asocia el parámetro :id
            $stmt->execute(); // Ejecuta la consulta
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Obtiene el resultado como un array asociativo
            $stmt->closeCursor(); // Cierra el cursor después de la ejecución
            return $result ?: false; // Devuelve el resultado o false si no se encuentra
        } catch (PDOException) {
            return false; // En caso de error, retorna false
        }
    }

    // Método para actualizar una categoría
    public function updateCategoria(int $id, string $nombre): bool {
        try {
            // Prepara la consulta para actualizar el nombre de la categoría
            $stmt = $this->db->prepare("UPDATE categorias SET nombre = :nombre WHERE id = :id");
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR); // Asocia el parámetro :nombre
            $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Asocia el parámetro :id
            $stmt->execute(); // Ejecuta la consulta de actualización
            return $stmt->rowCount() > 0; // Devuelve true si se actualizó al menos una fila, false en caso contrario
        } catch (PDOException) {
            return false; // En caso de error, retorna false
        }
    }

    // Método para eliminar una categoría
    public function deleteCategoria(int $id): bool {
        try {
            $producto = new Producto(); // Crea una instancia de la clase Producto
            // Obtiene todos los productos de la categoría a eliminar
            $productos = $producto->getProductosByCategoria($id);
            foreach ($productos as $item) {
                // Elimina cada producto de la categoría antes de eliminar la categoría
                $producto->deleteProducto($item['id']);
            }
            // Prepara la consulta para eliminar la categoría
            $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Asocia el parámetro :id
            $stmt->execute(); // Ejecuta la consulta de eliminación
            return $stmt->rowCount() > 0; // Devuelve true si se eliminó al menos una fila, false en caso contrario
        } catch (PDOException) {
            return false; // En caso de error, retorna false
        }
    }
}
