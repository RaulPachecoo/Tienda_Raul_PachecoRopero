<?php

namespace Controllers;

use Lib\Pages;
use Models\Carrito;
use Models\Producto;
use Controllers\UsuarioController;

class CarritoController {
    private Pages $pages;
    private Carrito $carrito;
    private UsuarioController $usuario;

    public function __construct() {
        $this->pages = new Pages();
        $this->carrito = new Carrito();
        $this->usuario = new UsuarioController();
    }

    public function comprobarLogin(){
        if(!isset($_SESSION['login'])){
            header('Location: ' . BASE_URL . 'Usuario/login'); 
            exit(); 
        }
    }

    public function añadirCarrito(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $this->validarDatosCarrito()) {
            $_SESSION['carrito'] = $_SESSION['carrito'] ?? [];
    
            $productoId = (int) $_POST['producto_id'];
            $cantidad = (int) $_POST['cantidad'];
            $precio = (float) $_POST['precio'];
            $nombre = trim($_POST['nombre']);
    
            $producto = Producto::getProductoById($productoId);
            if ($producto && $cantidad <= $producto['stock']) {
                if ($this->containProducto($productoId, $precio)) {
                    if ($_SESSION['carrito'][$productoId]['cantidad'] + $cantidad <= $producto['stock']) {
                        $_SESSION['carrito'][$productoId]['cantidad'] += $cantidad;
                    } else {
                        echo 'No hay suficiente stock';
                    }
                } else {
                    $_SESSION['carrito'][$productoId] = [
                        'producto_id' => $productoId,
                        'cantidad' => $cantidad,
                        'precio' => $precio,
                        'nombre' => $nombre,
                    ];
                }
            } else {
                echo 'No hay suficiente stock';
            }
        }
        $this->showCarrito();
    }
    
    public function showCarrito(): void {
        $totalCarrito = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $_SESSION['carrito'] ?? []));
        $this->pages->render('carrito/showCarrito', ['totalCarrito' => $totalCarrito]);
    }
    
    private function containProducto(int $productoId, float $precio): bool {
        return isset($_SESSION['carrito'][$productoId]) &&
               $_SESSION['carrito'][$productoId]['precio'] === $precio;
    }
    
    private function validarDatosCarrito(): bool {
        return !empty($_POST['producto_id']) && !empty($_POST['cantidad']) &&
               !empty($_POST['precio']) && !empty($_POST['nombre']);
    }

    private function updateCantidad(int $cantidad): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['producto_id'])) {
            $productoId = (int)$_POST['producto_id'];
    
            if (isset($_SESSION['carrito'][$productoId])) {
                $producto = Producto::getProductoById($productoId);
    
                $nuevaCantidad = $_SESSION['carrito'][$productoId]['cantidad'] + $cantidad;
                if ($nuevaCantidad > 0 && $nuevaCantidad <= $producto['stock']) {
                    $_SESSION['carrito'][$productoId]['cantidad'] = $nuevaCantidad;
                } elseif ($nuevaCantidad <= 0) {
                    unset($_SESSION['carrito'][$productoId]);
                } else {
                    echo 'No hay suficiente stock';
                }
            }
        }
        $this->showCarrito();
    }
    
    public function addCantidad(): void {
        $this->updateCantidad(1);
    }
    
    public function removeCantidad(): void {
        $this->updateCantidad(-1);
    }
    
    public function eliminarProducto(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['producto_id'])) {
            $productoId = (int)$_POST['producto_id'];
            unset($_SESSION['carrito'][$productoId]);
        }
        $this->showCarrito();
    }
    
    public function vaciarCarrito(): void {
        $_SESSION['carrito'] = [];
        $this->showCarrito();
    }
    
}
