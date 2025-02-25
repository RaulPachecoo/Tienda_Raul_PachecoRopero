<?php
namespace Models;

use DateTime;
use Lib\DBConnection;
use PDO;
use PDOException;

class Pedido {
    private int $id;
    private int $usuarioId;
    private string $provincia;
    private string $localidad;
    private string $direccion;
    private float $coste;
    private string $estado;
    private ?DateTime $fecha = null;
    private ?DateTime $hora = null;

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

    public function getFecha(): ?DateTime {
        return $this->fecha;
    }

    public function getHora(): ?DateTime {
        return $this->hora;
    }

    public function getUsuarioId(): int {
        return $this->usuarioId;
    }

    public function getProvincia(): string {
        return $this->provincia;
    }

    public function getLocalidad(): string {
        return $this->localidad;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function getCoste(): float {
        return $this->coste;
    }

    public function getEstado(): string {
        return $this->estado;
    }

    public function createPedido(int $usuarioId, string $provincia, string $localidad, string $direccion, float $coste, string $estado): bool {
        try {
            // Preparar la consulta SQL
            $stmt = $this->db->prepare("INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) 
                                        VALUES (:usuarioId, :provincia, :localidad, :direccion, :coste, :estado, NOW(), CURRENT_TIME)");

            // Vincular los valores a la consulta
            $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->bindValue(':provincia', $provincia, PDO::PARAM_STR);
            $stmt->bindValue(':localidad', $localidad, PDO::PARAM_STR);
            $stmt->bindValue(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindValue(':coste', $coste, PDO::PARAM_STR); // Si cost es un float, puede ser PDO::PARAM_STR
            $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            // Cerrar el cursor de la consulta
            $stmt->closeCursor();

            $result = true;
        } catch (PDOException) {
            $result = false;
        }

        return $result; 
    }

    public function getPedidosByUsuario(int $usuarioId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM pedidos WHERE usuario_id = :usuarioId ORDER BY id DESC");
            $stmt->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
    
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
    
            return $pedidos;
    
        } catch (PDOException ) {
            return false;
        }
    }
    

    public function updateEstadoPedido(int $pedidoId, string $nuevoEstado): bool {
        try {
            $stmt = $this->db->prepare("UPDATE pedidos SET estado = :nuevoEstado WHERE id = :pedidoId");
            $stmt->bindValue(':nuevoEstado', $nuevoEstado, PDO::PARAM_STR);  
            $stmt->bindValue(':pedidoId', $pedidoId, PDO::PARAM_INT);  
    
            $result = $stmt->execute();  // Ejecutar la consulta y capturar el resultado
            $stmt->closeCursor();
    
        } catch (PDOException $e) {
            $result = false;
        }

        return $result; 
    }

    public function getAll() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM pedidos ORDER BY id DESC");
            $stmt->execute();
    
            $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
    
            return $pedidos;
        } catch (PDOException) {
            return false;
        }
    }
    
    public function getProductosPedidoFromSession() {
        if (!empty($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
            $productosPedido = [];
    
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
    
            return $productosPedido;
        }
    
        return [];
    }

    public function getPedidoById(int $pedidoId) {
        try {
            // Preparar la consulta SQL para obtener un pedido por su ID, incluyendo email y nombre del usuario
            $stmt = $this->db->prepare("SELECT pedidos.*, usuarios.email, usuarios.nombre 
                                        FROM pedidos 
                                        JOIN usuarios ON pedidos.usuario_id = usuarios.id 
                                        WHERE pedidos.id = :pedidoId LIMIT 1");
            $stmt->bindValue(':pedidoId', $pedidoId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Obtener el pedido si existe
            $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
    
            // Si no se encuentra el pedido, devolver false
            if ($pedido === false) {
                return false;
            }
    
            return $pedido;
    
        } catch (PDOException $e) {
            return false;
        }
    }
    
    
}
