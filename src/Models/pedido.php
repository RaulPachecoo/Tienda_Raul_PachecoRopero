<?php
namespace Models;

use DateTime;
use Lib\DBConnection;
use PDO;
use PDOException;

class Pedido {
    private int $id; // ID único del pedido
    private int $usuarioId; // ID del usuario que realizó el pedido
    private string $provincia; // Provincia de destino del pedido
    private string $localidad; // Localidad de destino del pedido
    private string $direccion; // Dirección de destino del pedido
    private float $coste; // Coste total del pedido
    private string $estado; // Estado del pedido (por ejemplo, "pendiente", "enviado")
    private ?DateTime $fecha = null; // Fecha en que se realizó el pedido
    private ?DateTime $hora = null; // Hora en que se realizó el pedido

    private DBConnection $db; // Instancia de conexión a la base de datos

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        $this->db = new DBConnection(); // Crea la instancia de DBConnection
    }

    // Getters y Setters
    public function getId(): int {
        return $this->id; // Devuelve el ID del pedido
    }

    public function setId(int $id): self {
        $this->id = $id; // Establece el ID del pedido
        return $this; // Permite encadenar métodos
    }

    public function getFecha(): ?DateTime {
        return $this->fecha; // Devuelve la fecha del pedido, puede ser null si no se establece
    }

    public function getHora(): ?DateTime {
        return $this->hora; // Devuelve la hora del pedido, puede ser null si no se establece
    }

    public function getUsuarioId(): int {
        return $this->usuarioId; // Devuelve el ID del usuario que realizó el pedido
    }

    public function getProvincia(): string {
        return $this->provincia; // Devuelve la provincia de destino del pedido
    }

    public function getLocalidad(): string {
        return $this->localidad; // Devuelve la localidad de destino del pedido
    }

    public function getDireccion(): string {
        return $this->direccion; // Devuelve la dirección de destino del pedido
    }

    public function getCoste(): float {
        return $this->coste; // Devuelve el coste total del pedido
    }

    public function getEstado(): string {
        return $this->estado; // Devuelve el estado del pedido
    }

    // Método para crear un nuevo pedido
    public function createPedido(int $usuarioId, string $provincia, string $localidad, string $direccion, float $coste, string $estado): bool {
        try {
            // Prepara la consulta SQL para insertar el pedido en la base de datos
            $stmt = $this->db->prepare("INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) 
                                        VALUES (:usuarioId, :provincia, :localidad, :direccion, :coste, :estado, NOW(), CURRENT_TIME)");

            // Vincula los parámetros a la consulta SQL
            $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->bindValue(':provincia', $provincia, PDO::PARAM_STR);
            $stmt->bindValue(':localidad', $localidad, PDO::PARAM_STR);
            $stmt->bindValue(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindValue(':coste', $coste, PDO::PARAM_STR); // Se usa PDO::PARAM_STR por si el coste es un float
            $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);

            // Ejecuta la consulta SQL
            $stmt->execute();

            // Obtiene el ID del pedido insertado
            $this->id = $this->db->getConnection()->lastInsertId();

            // Cierra el cursor después de la ejecución
            $stmt->closeCursor();

            return true; // Retorna true si la creación del pedido fue exitosa
        } catch (PDOException) {
            return false; // Retorna false en caso de error
        }
    }

    // Método para obtener todos los pedidos de un usuario
    public function getPedidosByUsuario(int $usuarioId) {
        try {
            // Prepara la consulta para obtener todos los pedidos de un usuario específico
            $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE usuario_id = :usuarioId ORDER BY id DESC");
            $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();

            // Obtiene todos los pedidos y los almacena en un array
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $pedidos; // Devuelve el array de pedidos
        } catch (PDOException ) {
            return false; // Retorna false si ocurre un error
        }
    }

    // Método para actualizar el estado de un pedido
    public function updateEstadoPedido(int $pedidoId, string $nuevoEstado): bool {
        try {
            // Prepara la consulta para actualizar el estado de un pedido
            $stmt = $this->db->prepare("UPDATE pedidos SET estado = :nuevoEstado WHERE id = :pedidoId");
            $stmt->bindValue(':nuevoEstado', $nuevoEstado, PDO::PARAM_STR);  
            $stmt->bindValue(':pedidoId', $pedidoId, PDO::PARAM_INT);  

            // Ejecuta la consulta de actualización y captura el resultado
            $result = $stmt->execute(); 
            $stmt->closeCursor();

        } catch (PDOException $e) {
            $result = false; // En caso de error, establece result como false
        }

        return $result; // Retorna el resultado de la ejecución
    }

    // Método para obtener todos los pedidos
    public function getAll() {
        try {
            // Prepara la consulta para obtener todos los pedidos
            $stmt = $this->db->prepare("SELECT * FROM pedidos ORDER BY id DESC");
            $stmt->execute();

            // Obtiene todos los pedidos y los almacena en un array
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return $pedidos; // Devuelve el array de pedidos
        } catch (PDOException) {
            return false; // Retorna false si ocurre un error
        }
    }

    // Método para obtener los productos de un pedido a partir de la sesión
    public function getProductosPedidoFromSession() {
        if (!empty($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
            $productosPedido = [];

            // Itera sobre el carrito de la sesión para obtener los productos
            foreach ($_SESSION['carrito'] as $producto) {
                if (isset($producto['nombre'], $producto['cantidad'], $producto['precio'])) {
                    $productosPedido[] = [
                        'nombre' => htmlspecialchars($producto['nombre']),
                        'cantidad' => (int)$producto['cantidad'],
                        'precio' => (float)$producto['precio'],
                        'costo_total' => round((float)$producto['precio'] * (int)$producto['cantidad'], 2),
                    ];
                }
            }

            return $productosPedido; // Devuelve el array de productos del pedido
        }

        return []; // Devuelve un array vacío si no hay productos en la sesión
    }

    // Método para obtener un pedido por su ID
    public function getPedidoById(int $pedidoId) {
        try {
            // Prepara la consulta SQL para obtener un pedido específico por su ID
            $stmt = $this->db->prepare("SELECT pedidos.*, usuarios.email, usuarios.nombre 
                                        FROM pedidos 
                                        JOIN usuarios ON pedidos.usuario_id = usuarios.id 
                                        WHERE pedidos.id = :pedidoId LIMIT 1");
            $stmt->bindValue(':pedidoId', $pedidoId, PDO::PARAM_INT);
            $stmt->execute();

            // Obtiene el pedido y lo almacena en un array
            $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            // Si no se encuentra el pedido, retorna false
            if ($pedido === false) {
                return false;
            }

            return $pedido; // Devuelve el pedido encontrado
        } catch (PDOException $e) {
            return false; // Retorna false si ocurre un error
        }
    }

    // Método para crear una línea de pedido
    public function createLineaPedido(int $pedidoId, int $productoId, int $unidades): bool {
        try {
            // Prepara la consulta para insertar una línea de pedido en la base de datos
            $stmt = $this->db->prepare("INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (:pedidoId, :productoId, :unidades)");
            $stmt->bindValue(':pedidoId', $pedidoId, PDO::PARAM_INT);
            $stmt->bindValue(':productoId', $productoId, PDO::PARAM_INT);
            $stmt->bindValue(':unidades', $unidades, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            return true; // Retorna true si la línea de pedido se crea correctamente
        } catch (PDOException $e) {
            error_log("Error al crear la línea de pedido: " . $e->getMessage()); // Registra el error en el log
            return false; // Retorna false en caso de error
        }
    }
}
