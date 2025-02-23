<?php

namespace Controllers;

use Lib\Pages;
use Models\Producto;
use Controllers\CarritoController;
use Controllers\ErrorController;

class ProductoController
{
    private Pages $pages;
    private Producto $producto;
    private CarritoController $carrito;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->producto = new Producto();
        $this->carrito = new CarritoController();
    }


    public static function getProductos()
    {
        return Producto::getAll();
    }

    public function gestionarProductos()
    {
        $this->carrito->comprobarLogin();

        $productos = $this->getProductos();

        $this->pages->render('productos/gestionarProductos', ['productos' => $productos]);
    }

    public function createProducto() {
        $this->carrito->comprobarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
            return ErrorController::showError404();
        }

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = intval($_POST['categoria']);
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $fecha = $_POST['fecha'];

        if (!is_numeric($precio) || !is_numeric($stock)) {
            return ErrorController::showError500("El precio y el stock deben ser números.");
        }

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];
            $nomArchivo = uniqid() . '_' . $imagen['name'];
            $rutaDestino = __DIR__ . '/../../public/img/' . $nomArchivo;

            if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                return ErrorController::showError500("Error al subir la imagen.");
            }
            $imagen = $nomArchivo;
        } else {
            return ErrorController::showError500("Imagen no válida.");
        }

        if (!$this->producto->createProducto($nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen)) {
            return ErrorController::showError500("Error al crear el producto.");
        }

        header('Location: /producto/gestionarProductos');
        exit;
    }

    public function modificarProducto($id){
        $this->carrito->comprobarLogin();
        $producto = Producto::getProductoById($id);

        if(!$producto){
            return ErrorController::showError404(); 
        }

        $this->pages->render('producto/modificar', ['producto' => $producto]);
    }

    public function updateProducto($id)
    {
        $this->carrito->comprobarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
            return ErrorController::showError404();
        }

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];
        $categoria = intval($categoria);
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $fecha = $_POST['fecha'];

        if (!is_numeric($precio) || !is_numeric($stock)) {
            return ErrorController::showError500("El precio y el stock deben ser números.");
        }

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];

            $nomArchivo = uniqid() . '_' . $imagen['name'];

            $rutaDestino = __DIR__ . '/../../public/img/' . $nomArchivo;

            if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                return ErrorController::showError500("Error al subir la imagen.");
            }
            $imagen = $nomArchivo;
        } else {
            $imagen = $this->producto->getImagenById($id);
        }

        if (!$this->producto->updateProducto($id, $nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen)) {
            return ErrorController::showError500("Error al actualizar el producto.");
        }

        $productos = self::getProductos();
        $this->pages->render('producto/gestionarProductos', ['productos' => $productos]);
    }

    public function deleteProducto(int $id): void
    {
        $this->carrito->comprobarLogin();

        $producto = new Producto();
        if (!$producto->deleteProducto($id)) {
            ErrorController::showError500("Error al eliminar el producto.");
        }

        $productos = self::getProductos();
        $this->pages->render('producto/gestionarProductos', ['productos' => $productos]);
    }
}
