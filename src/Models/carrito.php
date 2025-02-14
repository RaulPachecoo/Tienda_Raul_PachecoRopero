<?php 

namespace Models; 
use Lib\DBConnection; 


class Carrito {
    private int $id; 
    private string $nombre; 
    private float $precio; 
    private int $cantidad; 
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

    public function getPrecio(): float {
        return $this->precio;
    }

    public function setPrecio(float $precio): self {
        $this->precio = $precio;
        return $this;
    }

    public function getCantidad(): int {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self {
        $this->cantidad = $cantidad;
        return $this;
    }
}
