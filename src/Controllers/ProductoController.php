<?php

namespace Controllers;

use Lib\Pages;
use Models\Producto;
use Controllers\CarritoController;
use Controllers\ErrorController;
use Pagerfanta\Pagerfanta;

class ProductoController
{
    private Pages $pages; // Instancia de la clase Pages para renderizar vistas
    private Producto $producto; // Instancia del modelo Producto para acceder a la base de datos
    private CarritoController $carrito; // Instancia del controlador del carrito para comprobar el login

    public function __construct()
    {
        $this->pages = new Pages();
        $this->producto = new Producto();
        $this->carrito = new CarritoController();
    }

    /**
     * Obtiene todos los productos desde el modelo Producto.
     * 
     * @return array Listado de productos.
     */
    public static function getProductos()
    {
        return Producto::getAll();
    }

    /**
     * Gestiona la vista y la lógica de paginación para mostrar productos.
     * 
     * @param int $page Página actual para la paginación.
     */
    public function gestionarProductos(int $page = 1)
    {
        $this->carrito->comprobarLogin(); // Verifica si el usuario está autenticado.

        $maxPerPage = 9; // Número máximo de productos por página
        $pagerfanta = Producto::getPaginatedProductos($page, $maxPerPage); // Obtiene los productos paginados

        // Renderiza la vista 'gestionarProductos' pasando los productos y la información de la paginación.
        $this->pages->render('producto/gestionarProductos', [
            'productos' => $pagerfanta->getCurrentPageResults(),
            'pagerfanta' => $pagerfanta,
            'currentPage' => $page // Pasamos la página actual a la vista.
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo producto y maneja la creación del producto.
     * 
     * @return void
     */
    public function createProducto() {
        $this->carrito->comprobarLogin(); // Verifica que el usuario esté autenticado.

        // Si la solicitud es GET, mostramos el formulario de creación.
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->pages->render('producto/crearProducto');
            return;
        }

        // Si la solicitud es POST y los datos son válidos, procesamos la creación.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $categoria = intval($_POST['categoria']); // Convertimos la categoría a un número
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $fecha = new \DateTime($_POST['fecha']); // Convertimos la fecha a un objeto DateTime

            // Verificamos que el precio y stock sean números
            if (!is_numeric($precio) || !is_numeric($stock)) {
                $errores = ["El precio y el stock deben ser números."];
                $this->pages->render('producto/crearProducto', ['errores' => $errores]);
                return;
            }

            // Si hay una imagen, la subimos al servidor.
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = $_FILES['imagen'];
                $nomArchivo = $imagen['name'];
                $rutaDestino = __DIR__ . '/../../public/imgs/' . $nomArchivo;
                if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                    $errores = ["Error al subir la imagen."];
                    $this->pages->render('producto/crearProducto', ['errores' => $errores]);
                    return;
                }
                $imagen = $nomArchivo; // Asignamos la imagen subida.
            } else {
                $imagen = null; // Si no se sube imagen, se asigna null.
            }

            // Llamamos al modelo para crear el producto.
            if (!$this->producto->createProducto($nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen)) {
                $errores = ["Error al crear el producto."];
                $this->pages->render('producto/crearProducto', ['errores' => $errores]);
                return;
            }

            // Si el producto se crea con éxito, mostramos un mensaje.
            $mensaje = "Producto creado con éxito.";
            $this->pages->render('producto/crearProducto', ['mensaje' => $mensaje]);
            return;
        }

        // Si no se recibieron datos, mostramos un error.
        $errores = ["Datos del producto no recibidos."];
        $this->pages->render('producto/crearProducto', ['errores' => $errores]);
    }

    /**
     * Muestra el formulario para modificar un producto específico.
     * 
     * @param int $id ID del producto a modificar.
     * @return void
     */
    public function modificarProducto($id){
        $this->carrito->comprobarLogin(); // Verifica si el usuario está autenticado.
        $producto = Producto::getProductoById($id); // Obtiene el producto por su ID.

        // Si el producto no existe, muestra un error 404.
        if(!$producto){
            return ErrorController::showError404(); 
        }

        // Si el producto existe, se renderiza la vista de modificación.
        $this->pages->render('producto/modificar', ['producto' => $producto]);
    }

    /**
     * Actualiza un producto con los nuevos datos proporcionados.
     * 
     * @param int $id ID del producto a actualizar.
     * @return void
     */
    public function updateProducto($id)
    {
        $this->carrito->comprobarLogin(); // Verifica si el usuario está autenticado.

        // Si la solicitud no es POST o no se recibieron los datos necesarios, muestra un error.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
            $errores = ["Datos del producto no recibidos."];
            $this->pages->render('producto/modificar', ['errores' => $errores]);
            return;
        }

        // Extraemos y validamos los datos recibidos.
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $categoria = intval($_POST['categoria']);
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $oferta = $_POST['oferta'];
        $fecha = $_POST['fecha'];

        // Verificamos que el precio y el stock sean números.
        if (!is_numeric($precio) || !is_numeric($stock)) {
            $errores = ["El precio y el stock deben ser números."];
            $this->pages->render('producto/modificar', ['errores' => $errores]);
            return;
        }

        // Si hay una nueva imagen, la subimos al servidor.
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = $_FILES['imagen'];
            $nomArchivo = '_' . $imagen['name'];
            $rutaDestino = __DIR__ . '/../../public/imgs/' . $nomArchivo;
            if (!move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                $errores = ["Error al subir la imagen."];
                $this->pages->render('producto/modificar', ['errores' => $errores]);
                return;
            }
            $imagen = $nomArchivo; // Asignamos la nueva imagen.
        } else {
            $imagen = $this->producto->getImagenById($id)['imagen']; // Mantiene la imagen original si no se sube una nueva.
        }

        // Llamamos al modelo para actualizar el producto.
        if (!$this->producto->updateProducto($id, $categoria, $nombre, $descripcion, $precio, $stock, $oferta, $fecha, $imagen)) {
            $errores = ["Error al actualizar el producto."];
            $this->pages->render('producto/modificar', ['errores' => $errores]);
            return;
        }

        // Si se actualiza con éxito, mostramos un mensaje.
        $mensaje = "Producto actualizado con éxito.";
        $productos = self::getProductos(); // Obtenemos todos los productos para mostrarlos
        $this->pages->render('producto/gestionarProductos', [
            'productos' => $productos,
            'mensaje' => $mensaje
        ]);
    }

    /**
     * Elimina un producto por su ID.
     * 
     * @param int $id ID del producto a eliminar.
     * @return void
     */
    public function deleteProducto(int $id): void
    {
        $this->carrito->comprobarLogin(); // Verifica si el usuario está autenticado.

        $producto = new Producto();
        // Si el producto se elimina correctamente, muestra un mensaje.
        if ($producto->deleteProducto($id)) {
            $mensaje = "Producto eliminado con éxito.";
        } else {
            $errores = ["Error al eliminar el producto."];
        }

        // Renderiza la vista de gestión de productos, con el mensaje o error.
        $productos = self::getProductos(); // Obtiene los productos actualizados.
        $this->pages->render('producto/gestionarProductos', [
            'productos' => $productos,
            'mensaje' => $mensaje ?? null,
            'errores' => $errores ?? null
        ]);
    }
}
