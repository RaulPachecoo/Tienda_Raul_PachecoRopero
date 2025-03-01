<?php

namespace Models;

use DateTime;
use Lib\DBConnection;
use PDO;
use PDOException;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

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
     * Obtiene el valor del ID del producto.
     * 
     * @return int El ID del producto.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Establece el valor del ID del producto.
     * 
     * @param int $id El ID del producto.
     * @return self Instancia del objeto Producto.
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Obtiene el valor de la categoría del producto.
     * 
     * @return int El ID de la categoría del producto.
     */
    public function getCategoriaId()
    {
        return $this->categoriaId;
    }

    /**
     * Establece el valor de la categoría del producto.
     * 
     * @param int $categoriaId El ID de la categoría.
     * @return self Instancia del objeto Producto.
     */
    public function setCategoriaId($categoriaId)
    {
        $this->categoriaId = $categoriaId;

        return $this;
    }

    /**
     * Obtiene el nombre del producto.
     * 
     * @return string El nombre del producto.
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Establece el nombre del producto.
     * 
     * @param string $nombre El nombre del producto.
     * @return self Instancia del objeto Producto.
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Obtiene la descripción del producto.
     * 
     * @return string La descripción del producto.
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Establece la descripción del producto.
     * 
     * @param string $descripcion La descripción del producto.
     * @return self Instancia del objeto Producto.
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Obtiene el precio del producto.
     * 
     * @return float El precio del producto.
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Establece el precio del producto.
     * 
     * @param float $precio El precio del producto.
     * @return self Instancia del objeto Producto.
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Obtiene la cantidad de stock del producto.
     * 
     * @return int La cantidad de stock del producto.
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Establece la cantidad de stock del producto.
     * 
     * @param int $stock La cantidad de stock del producto.
     * @return self Instancia del objeto Producto.
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Obtiene la oferta asociada al producto.
     * 
     * @return string La oferta asociada al producto.
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * Establece la oferta asociada al producto.
     * 
     * @param string $oferta La oferta asociada al producto.
     * @return self Instancia del objeto Producto.
     */
    public function setOferta($oferta)
    {
        $this->oferta = $oferta;

        return $this;
    }

    /**
     * Obtiene la imagen asociada al producto.
     * 
     * @return string La ruta de la imagen del producto.
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Establece la imagen asociada al producto.
     * 
     * @param string $imagen La ruta de la imagen del producto.
     * @return self Instancia del objeto Producto.
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Obtiene la fecha de creación del producto.
     * 
     * @return DateTime La fecha de creación del producto.
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Establece la fecha de creación del producto.
     * 
     * @param DateTime $fecha La fecha de creación del producto.
     * @return self Instancia del objeto Producto.
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Obtiene todos los productos en la base de datos.
     * 
     * @return array Lista de productos.
     */
    public  static function getAll(): array{
        $producto = new Producto(); 
        try {
            $producto->db->consulta("SELECT * FROM productos ORDER BY id DESC");
            $productos = $producto->db->extraer_todos();
            return $productos;
        } catch (PDOException $e) {
            return [];
        } finally {
            $producto->db->close();
        }
    }

    /**
     * Crea un nuevo producto en la base de datos.
     * 
     * @param string $nombre Nombre del producto.
     * @param string $descripcion Descripción del producto.
     * @param int $categoria ID de la categoría del producto.
     * @param float $precio Precio del producto.
     * @param int $stock Cantidad en stock del producto.
     * @param string $oferta Oferta asociada al producto.
     * @param DateTime $fecha Fecha de creación del producto.
     * @param string $imagen Ruta de la imagen del producto.
     * @return bool True si la creación fue exitosa, false si hubo error.
     */
    public function createProducto(string $nombre, string $descripcion, int $categoria, float $precio, int $stock, string $oferta, DateTime $fecha, string $imagen): bool {
        try {
            $stmt = $this->db->prepare("SELECT 1 FROM productos WHERE nombre = :nombre");
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $stmt->closeCursor();
                return false; // El producto ya existe
            }

            $stmt->closeCursor();
            $this->checkAndCreateImageDir();
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
            
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene productos por categoría.
     * 
     * @param int $categoriaId ID de la categoría.
     * @return array|false Lista de productos o false si hay error.
     */
    public static function getProductosByCategoria(int $categoriaId): array|false {
        $producto = new self();
        try {
            $stmt = $producto->db->prepare(
                "SELECT * FROM productos WHERE categoria_id = :categoriaId ORDER BY id DESC"
            );
            $stmt->bindValue(':categoriaId', $categoriaId, PDO::PARAM_INT);
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $producto->db->close();
            return $productos;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Obtiene el stock de un producto por su ID.
     * 
     * @param int $id ID del producto.
     * @return array|false El stock del producto o false si hay error.
     */
    public function getStockById(int $id): array|false {
        try {
            $stmt = $this->db->prepare(
                "SELECT stock FROM productos WHERE id = :id"
            );
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stock = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $stock ?: false;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Actualiza el stock de un producto.
     * 
     * @param int $id ID del producto.
     * @param int $nuevoStock Nuevo valor de stock.
     * @return bool True si la actualización fue exitosa, false si hubo error.
     */
    public function updateStock(int $id, int $nuevoStock): bool {
        try {
            $stmt = $this->db->prepare(
                "UPDATE productos SET stock = :nuevoStock WHERE id = :id"
            );
            $stmt->bindValue(':nuevoStock', $nuevoStock, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Actualiza los detalles de un producto.
     * 
     * @param int $id ID del producto.
     * @param int $categoria ID de la categoría.
     * @param string $nombre Nombre del producto.
     * @param string $descripcion Descripción del producto.
     * @param float $precio Precio del producto.
     * @param int $stock Stock del producto.
     * @param string $oferta Oferta del producto.
     * @param string $fecha Fecha de actualización del producto.
     * @param string $imagen Imagen del producto.
     * @return bool True si la actualización fue exitosa, false si hubo error.
     */
    public function updateProducto(int $id, int $categoria, string $nombre, string $descripcion, float $precio, int $stock, string $oferta, string $fecha, string $imagen): bool {
        try {
            $this->checkAndCreateImageDir();
            $stmt = $this->db->prepare(
                "UPDATE productos SET categoria_id = :categoria, nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, oferta = :oferta, fecha = :fecha, imagen = :imagen WHERE id = :id"
            );
            $stmt->bindValue(':categoria', $categoria, PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(':precio', $precio);
            $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindValue(':oferta', $oferta, PDO::PARAM_STR);
            $stmt->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindValue(':imagen', $imagen, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            $this->db->close();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Obtiene la imagen de un producto por su ID.
     * 
     * @param int $id ID del producto.
     * @return mixed La imagen del producto o false si hubo error.
     */
    public function getImagenById(int $id): mixed {
        try {
            $stmt = $this->db->prepare("SELECT imagen FROM productos WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            return $imagen ?: false;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Obtiene los detalles de un producto por su ID.
     * 
     * @param int $id ID del producto.
     * @return mixed Los detalles del producto o false si hubo error.
     */
    public static function getProductoById(int $id): mixed {
        $producto = new Producto(); 
        try {
            $stmt = $producto->db->prepare("SELECT * FROM productos WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $productoDetails = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $producto->db->close(); 
            return $productoDetails ?: false;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Elimina un producto por su ID.
     * 
     * @param int $id ID del producto.
     * @return bool True si la eliminación fue exitosa, false si hubo error.
     */
    public function deleteProducto(int $id): bool {
        try {
            $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            return true;
        } catch (PDOException) {
            return false;
        } finally {
            $this->db->close();
        }
    }

    /**
     * Verifica y crea el directorio para las imágenes si no existe.
     */
    private function checkAndCreateImageDir() {
        $imageDir = __DIR__ . '/../../public/imgs';
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }
    }

    /**
     * Obtiene productos paginados.
     * 
     * @param int $currentPage Página actual.
     * @param int $maxPerPage Número máximo de productos por página.
     * @return Pagerfanta Objeto Pagerfanta con los productos paginados.
     */
    public static function getPaginatedProductos(int $currentPage, int $maxPerPage): Pagerfanta {
        $producto = new Producto();
        try {
            $producto->db->consulta("SELECT * FROM productos ORDER BY id DESC");
            $productos = $producto->db->extraer_todos();
            $producto->db->close();

            $adapter = new ArrayAdapter($productos);
            $pagerfanta = new Pagerfanta($adapter);
            $pagerfanta->setMaxPerPage($maxPerPage);
            $pagerfanta->setCurrentPage($currentPage);

            return $pagerfanta;
        } catch (PDOException $e) {
            return new Pagerfanta(new ArrayAdapter([]));
        }
    }

    /**
     * Obtiene productos paginados por categoría.
     * 
     * @param int $categoriaId ID de la categoría.
     * @param int $currentPage Página actual.
     * @param int $maxPerPage Número máximo de productos por página.
     * @return Pagerfanta Objeto Pagerfanta con los productos paginados.
     */
    public static function getPaginatedProductosByCategoria(int $categoriaId, int $currentPage, int $maxPerPage): Pagerfanta {
        $producto = new Producto();
        try {
            $stmt = $producto->db->prepare("SELECT * FROM productos WHERE categoria_id = :categoriaId ORDER BY id DESC");
            $stmt->bindValue(':categoriaId', $categoriaId, PDO::PARAM_INT);
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $producto->db->close();

            $adapter = new ArrayAdapter($productos);
            $pagerfanta = new Pagerfanta($adapter);
            $pagerfanta->setMaxPerPage($maxPerPage);
            $pagerfanta->setCurrentPage($currentPage);

            return $pagerfanta;
        } catch (PDOException $e) {
            return new Pagerfanta(new ArrayAdapter([]));
        }
    }

}
