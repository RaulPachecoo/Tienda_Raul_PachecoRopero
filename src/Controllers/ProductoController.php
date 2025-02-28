<?php

namespace Controllers;

use Lib\Pages;
use Models\Producto;
use Controllers\CarritoController;
use Controllers\ErrorController;
use Pagerfanta\Pagerfanta;

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

    public function gestionarProductos(int $page = 1)
    {
        $this->carrito->comprobarLogin();

        $maxPerPage = 10; // Número máximo de productos por página
        $pagerfanta = Producto::getPaginatedProductos($page, $maxPerPage);

        $this->pages->render('Producto/gestionarProductos', [
            'productos' => $pagerfanta->getCurrentPageResults(),
            'pagerfanta' => $pagerfanta
        ]);
    }

    public function createProducto() {
        $this->carrito->comprobarLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->pages->render('producto/crearProducto');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $categoria = intval($_POST['categoria']);
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $fecha = new \DateTime($_POST['fecha']); // Convertir la cadena de fecha a un objeto DateTime

            if (!is_numeric($precio) || !is_numeric($stock)) {
                $errores = ["El precio y el stock deben ser números."];
                $this->pages->render('producto/crearProducto', ['errores' => $errores]);
                return;
            }

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = $_FILES['imagen'];
                $nomArchivo = $imagen['name'];
                $rutaDestino = __DIR__ . '/../../public/imgs/' . $nomArchivo;
                if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                    $errores = ["Error al subir la imagen."];
                    $this->pages->render('producto/crearProducto', ['errores' => $errores]);
                    return;
                }
                $imagen = $nomArchivo;
            } else {
                $imagen = null;
            }

            if (!$this->producto->createProducto($nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen)) {
                $errores = ["Error al crear el producto."];
                $this->pages->render('producto/crearProducto', ['errores' => $errores]);
                return;
            }

            $mensaje = "Producto creado con éxito.";
            $this->pages->render('producto/crearProducto', ['mensaje' => $mensaje]);
            return;
        }

        $errores = ["Datos del producto no recibidos."];
        $this->pages->render('producto/crearProducto', ['errores' => $errores]);
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
            $errores = ["Datos del producto no recibidos."];
            $this->pages->render('producto/modificar', ['errores' => $errores]);
            return;
        }

        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = intval($_POST['categoria']); // Convertir a entero
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $fecha = $_POST['fecha'];

        if (!is_numeric($precio) || !is_numeric($stock)) {
            $errores = ["El precio y el stock deben ser números."];
            $this->pages->render('producto/modificar', ['errores' => $errores]);
            return;
        }

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];
            $nomArchivo = uniqid() . '_' . $imagen['name'];
            $rutaDestino = __DIR__ . '/../../public/imgs/' . $nomArchivo;
            if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                $errores = ["Error al subir la imagen."];
                $this->pages->render('producto/modificar', ['errores' => $errores]);
                return;
            }
            $imagen = $nomArchivo; // Asignar la ruta del archivo subido
        } else {
            $imagen = $this->producto->getImagenById($id)['imagen']; // Obtener la URL de la imagen existente
        }

        if (!$this->producto->updateProducto($id, $categoria, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen)) {
            $errores = ["Error al actualizar el producto."];
            $this->pages->render('producto/modificar', ['errores' => $errores]);
            return;
        }

        $mensaje = "Producto actualizado con éxito.";
        $productos = self::getProductos();
        $this->pages->render('producto/gestionarProductos', [
            'productos' => $productos,
            'mensaje' => $mensaje
        ]);
    }

    public function deleteProducto(int $id): void
    {
        $this->carrito->comprobarLogin();

        $producto = new Producto();
        if ($producto->deleteProducto($id)) {
            $mensaje = "Producto eliminado con éxito.";
        } else {
            $errores = ["Error al eliminar el producto."];
        }

        $productos = self::getProductos();
        $this->pages->render('producto/gestionarProductos', [
            'productos' => $productos,
            'mensaje' => $mensaje ?? null,
            'errores' => $errores ?? null
        ]);
    }
}
