<?php

namespace Controllers;

use Lib\Pages;
use Models\Carrito;
use Models\Producto;
use Controllers\UsuarioController;

class CarritoController
{
    private Pages $pages;
    private Carrito $carrito;
    private UsuarioController $usuario;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->carrito = new Carrito();
        $this->usuario = new UsuarioController();
    }

    public function comprobarLogin()
    {
        if (!isset($_SESSION['login'])) {
            header('Location: ' . BASE_URL . 'Usuario/login');
            exit();
        }
    }


    public function addCarrito(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$this->validarDatosCarrito()) {
            return ErrorController::showError400("Datos inválidos para añadir al carrito.");
        }

        $_SESSION['carrito'] = $_SESSION['carrito'] ?? [];

        $productoId = (int) $_POST['producto_id'];
        $cantidad = (int) $_POST['cantidad'];
        $precio = (float) $_POST['precio'];
        $nombre = trim($_POST['nombre']);

        $producto = Producto::getProductoById($productoId);
        if (!$producto || !$cantidad <= $producto['stock']) {
            return ErrorController::showError400("No hay suficiente stock.");
        }

        if ($this->containProducto($productoId, $precio)) {
            if ($_SESSION['carrito'][$productoId]['cantidad'] + $cantidad <= $producto['stock']) {
                $_SESSION['carrito'][$productoId]['cantidad'] += $cantidad;
            } else {
                return ErrorController::showError400("No hay suficiente stock disponible.");
            }
        } else {
            $_SESSION['carrito'][$productoId] = [
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'nombre' => $nombre,
            ];
        }

        $this->showCarrito();
    }

    public function showCarrito(): void
    {
        $totalCarrito = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $_SESSION['carrito'] ?? []));
        $this->pages->render('carrito/showCarrito', ['totalCarrito' => $totalCarrito]);
    }

    private function containProducto(int $productoId, float $precio): bool
    {
        return isset($_SESSION['carrito'][$productoId]) && $_SESSION['carrito'][$productoId]['precio'] === $precio;
    }

    private function validarDatosCarrito(): bool
    {
        return isset($_POST['producto_id'], $_POST['cantidad'], $_POST['precio'], $_POST['nombre']) &&
            is_numeric($_POST['producto_id']) && is_numeric($_POST['cantidad']) && is_numeric($_POST['precio']) &&
            trim($_POST['nombre']) !== '';
    }

    private function updateCantidad(int $cantidad): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['producto_id'])) {
            return ErrorController::showError400("No se especificó el producto.");
        }

        $productoId = (int) $_POST['producto_id'];

        if (!isset($_SESSION['carrito'][$productoId])) {
            return ErrorController::showError404("El producto no está en el carrito.");
        }

        $producto = Producto::getProductoById($productoId);

        if (!$producto) {
            return ErrorController::showError404("El producto no existe.");
        }

        $nuevaCantidad = $_SESSION['carrito'][$productoId]['cantidad'] + $cantidad;
        if ($nuevaCantidad > 0 && $nuevaCantidad <= $producto['stock']) {
            $_SESSION['carrito'][$productoId]['cantidad'] = $nuevaCantidad;
        } elseif ($nuevaCantidad <= 0) {
            unset($_SESSION['carrito'][$productoId]);
        } else {
            return ErrorController::showError400("No hay suficiente stock disponible.");
        }

        $this->showCarrito();
    }

    public function addCantidad(): void
    {
        $this->updateCantidad(1);
    }

    public function removeCantidad(): void
    {
        $this->updateCantidad(-1);
    }

    public function removeProducto(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['producto_id'])) {
            return ErrorController::showError400("No se especificó el producto a eliminar.");
        }

        $productoId = (int) $_POST['producto_id'];
        unset($_SESSION['carrito'][$productoId]);

        $this->showCarrito();
    }

    public function vaciarCarrito(): void
    {
        $_SESSION['carrito'] = [];
        $this->showCarrito();
    }
}
