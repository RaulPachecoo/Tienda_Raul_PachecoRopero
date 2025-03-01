<?php 

namespace Models; 
use Lib\DBConnection; 

class Carrito {
    private int $id; // Identificador único del carrito
    private string $nombre; // Nombre del producto en el carrito
    private float $precio; // Precio del producto
    private int $cantidad; // Cantidad del producto en el carrito
    private DBConnection $db; // Instancia de la clase DBConnection para interactuar con la base de datos

    // Constructor que inicializa la conexión a la base de datos
    public function __construct() {
        $this->db = new DBConnection(); // Crear una nueva conexión a la base de datos
    }

    // Getter para el id del carrito
    public function getId(): int {
        return $this->id; // Devuelve el id del carrito
    }

    // Setter para el id del carrito
    public function setId(int $id): self {
        $this->id = $id; // Establece el id del carrito
        return $this; // Permite el encadenamiento de métodos
    }

    // Getter para el nombre del producto en el carrito
    public function getNombre(): string {
        return $this->nombre; // Devuelve el nombre del producto
    }

    // Setter para el nombre del producto en el carrito
    public function setNombre(string $nombre): self {
        $this->nombre = $nombre; // Establece el nombre del producto
        return $this; // Permite el encadenamiento de métodos
    }

    // Getter para el precio del producto en el carrito
    public function getPrecio(): float {
        return $this->precio; // Devuelve el precio del producto
    }

    // Setter para el precio del producto en el carrito
    public function setPrecio(float $precio): self {
        $this->precio = $precio; // Establece el precio del producto
        return $this; // Permite el encadenamiento de métodos
    }

    // Getter para la cantidad del producto en el carrito
    public function getCantidad(): int {
        return $this->cantidad; // Devuelve la cantidad del producto
    }

    // Setter para la cantidad del producto en el carrito
    public function setCantidad(int $cantidad): self {
        $this->cantidad = $cantidad; // Establece la cantidad del producto
        return $this; // Permite el encadenamiento de métodos
    }
}
