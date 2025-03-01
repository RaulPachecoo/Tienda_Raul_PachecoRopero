<?php

namespace Controllers;

use Lib\Pages;
use Models\Carrito;
use Models\Producto;
use Controllers\UsuarioController;

class CarritoController
{
    private Pages $pages;  // Objeto que maneja la renderización de páginas
    private Carrito $carrito;  // Objeto que maneja la lógica del carrito
    private UsuarioController $usuario;  // Objeto que maneja la lógica de usuario

    public function __construct()
    {
        // Inicializa las dependencias cuando se crea el objeto
        $this->pages = new Pages();
        $this->carrito = new Carrito();
        $this->usuario = new UsuarioController();
    }

    // Método para comprobar si el usuario está logueado
    public function comprobarLogin()
    {
        // Si no hay sesión de login, redirige al usuario a la página de login
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'Usuario/login');
            exit();  // Detiene la ejecución
        }
    }

    // Método para añadir productos al carrito
    public function addCarrito(): void
    {
        // Verifica que el método de solicitud sea POST y que los datos sean válidos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$this->validarDatosCarrito()) {
            ErrorController::showError400("Datos inválidos para añadir al carrito.");
            return; // Termina la ejecución si los datos son inválidos
        }

        // Si el carrito no existe en la sesión, lo inicializa como un array vacío
        $_SESSION['carrito'] = $_SESSION['carrito'] ?? [];

        // Extrae los datos del producto enviados en el formulario
        $productoId = (int) $_POST['producto_id'];
        $cantidad = (int) $_POST['cantidad'];
        $precio = (float) $_POST['precio'];
        $nombre = trim($_POST['nombre']);

        // Obtiene el producto de la base de datos
        $producto = Producto::getProductoById($productoId);
        
        // Si el producto no existe o el stock es insuficiente, muestra un error
        if (!$producto || $cantidad > $producto['stock']) {
            ErrorController::showError400("No hay suficiente stock.");
            return; 
        }

        // Si el producto ya está en el carrito, actualiza su cantidad
        if ($this->containProducto($productoId, $precio)) {
            // Verifica si hay suficiente stock para agregar la cantidad solicitada
            if ($_SESSION['carrito'][$productoId]['cantidad'] + $cantidad <= $producto['stock']) {
                $_SESSION['carrito'][$productoId]['cantidad'] += $cantidad;
            } else {
                ErrorController::showError400("No hay suficiente stock disponible.");
                return; 
            }
        } else {
            // Si el producto no está en el carrito, lo agrega
            $_SESSION['carrito'][$productoId] = [
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'nombre' => $nombre,
                'imagen' => $producto['imagen'], // Añadir la imagen del producto
                'stock' => $producto['stock'], // Asegurarse de que el stock esté incluido
            ];
        }

        // Muestra el carrito después de la actualización
        $this->showCarrito();
        // Guarda el carrito en una cookie durante 3 días
        setcookie('carrito', json_encode($_SESSION['carrito']), time() + (3 * 24 * 60 * 60), '/'); 
    }

    // Método para mostrar el contenido del carrito
    public function showCarrito(): void
    {
        // Calcula el total del carrito sumando los productos
        $totalCarrito = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $_SESSION['carrito'] ?? []));
        // Renderiza la página mostrando el carrito con el total calculado
        $this->pages->render('carrito/mostrarCarrito', ['totalCarrito' => $totalCarrito]);
    }

    // Método privado para verificar si un producto ya está en el carrito con el precio correcto
    private function containProducto(int $productoId, float $precio): bool
    {
        return isset($_SESSION['carrito'][$productoId]) && $_SESSION['carrito'][$productoId]['precio'] === $precio;
    }

    // Método privado para validar los datos enviados para añadir al carrito
    private function validarDatosCarrito(): bool
    {
        // Verifica que todos los parámetros necesarios estén presentes y sean válidos
        return isset($_POST['producto_id'], $_POST['cantidad'], $_POST['precio'], $_POST['nombre']) &&
            is_numeric($_POST['producto_id']) && is_numeric($_POST['cantidad']) && is_numeric($_POST['precio']) &&
            trim($_POST['nombre']) !== '';
    }

    // Método privado para actualizar la cantidad de un producto en el carrito
    private function updateCantidad(int $cantidad): void
    {
        // Verifica que la solicitud sea POST y que el producto esté especificado
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['producto_id'])) {
            ErrorController::showError400("No se especificó el producto.");
            return; 
        }

        $productoId = (int) $_POST['producto_id'];

        // Verifica que el producto esté en el carrito
        if (!isset($_SESSION['carrito'][$productoId])) {
            ErrorController::showError404("El producto no está en el carrito.");
            return; 
        }

        // Obtiene los detalles del producto desde la base de datos
        $producto = Producto::getProductoById($productoId);

        // Si el producto no existe, muestra un error
        if (!$producto) {
            ErrorController::showError404("El producto no existe.");
            return; 
        }

        // Calcula la nueva cantidad del producto en el carrito
        $nuevaCantidad = $_SESSION['carrito'][$productoId]['cantidad'] + $cantidad;
        // Si la cantidad es válida, actualiza el carrito
        if ($nuevaCantidad > 0 && $nuevaCantidad <= $producto['stock']) {
            $_SESSION['carrito'][$productoId]['cantidad'] = $nuevaCantidad;
        } elseif ($nuevaCantidad <= 0) {
            // Si la cantidad es 0 o menos, elimina el producto del carrito
            unset($_SESSION['carrito'][$productoId]);
        } else {
            // Si no hay suficiente stock, muestra un error
            ErrorController::showError400("No hay suficiente stock disponible.");
            return; 
        }

        // Muestra el carrito actualizado
        $this->showCarrito();
    }

    // Método para aumentar la cantidad de un producto en el carrito
    public function addCantidad(): void
    {
        $this->updateCantidad(1);  // Llama al método para aumentar la cantidad en 1
    }

    // Método para reducir la cantidad de un producto en el carrito
    public function removeCantidad(): void
    {
        $this->updateCantidad(-1);  // Llama al método para reducir la cantidad en 1
    }

    // Método para eliminar un producto del carrito
    public function removeProducto(): void
    {
        // Verifica que la solicitud sea POST y que el producto esté especificado
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['producto_id'])) {
            ErrorController::showError400("No se especificó el producto a eliminar.");
            return; 
        }

        $productoId = (int) $_POST['producto_id'];
        // Elimina el producto del carrito
        unset($_SESSION['carrito'][$productoId]);

        // Muestra el carrito actualizado
        $this->showCarrito();
    }

    // Método para vaciar el carrito
    public function vaciarCarrito(): void
    {
        // Vacia el carrito en la sesión
        $_SESSION['carrito'] = [];
        // Elimina la cookie del carrito
        setcookie('carrito', '', time() - 3600, '/');
        // Muestra el carrito vacío
        $this->showCarrito();
    }
}
