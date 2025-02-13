<?php

namespace Models;

use DateTime;
use Lib\DBConnection;
use PDO;
use PDOException;

class Producto
{
    private int $id;
    private int $categoriaId;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private string $oferta;
    private string $imagen;
    private DateTime $fecha;

    private DBConnection $db;

    public function __construct()
    {
        $this->db = new DBConnection();
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }



    /**
     * Get the value of categoriaId
     */
    public function getCategoriaId()
    {
        return $this->categoriaId;
    }

    /**
     * Set the value of categoriaId
     *
     * @return  self
     */
    public function setCategoriaId($categoriaId)
    {
        $this->categoriaId = $categoriaId;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of oferta
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * Set the value of oferta
     *
     * @return  self
     */
    public function setOferta($oferta)
    {
        $this->oferta = $oferta;

        return $this;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getAll(): array
    {
        try {
            $this->db->consulta("SELECT * FROM productos ORDER BY id DESC");
            $productos = $this->db->extraer_todos();
            return $productos;
        } catch (PDOException $e) {
            return [];
        } finally {
            $this->db->close();
        }
    }

    public function crearProducto(string $nombre, string $descripcion, int $categoria, float $precio, int $stock, string $oferta, DateTime $fecha, string $imagen) {
        try {
            $insert = $this->db->prepare(
                "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) 
                VALUES (:categoria, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)"
            );
            $insert->bindValue(':categoria', $categoria, PDO::PARAM_INT);
            $insert->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $insert->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $insert->bindValue(':precio', $precio, PDO::PARAM_STR);
            $insert->bindValue(':stock', $stock, PDO::PARAM_INT);
            $insert->bindValue(':oferta', $oferta, PDO::PARAM_STR);
            $insert->bindValue(':fecha', $fecha->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $insert->bindValue(':imagen', $imagen, PDO::PARAM_STR);

            $insert->execute();
            $insert->closeCursor();
            $this->db->close();
            
            header("Location: " . BASE_URL);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
