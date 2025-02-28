<?php

namespace Routes;

use Controllers\CategoriaController;
use Controllers\UsuarioController;
use Controllers\ProductoController;
use Controllers\DashboardController;
use Lib\Router;
use Controllers\CarritoController;
use Controllers\PedidoController;

class Routes
{
    public static function index()
    {
        Router::add('GET', '', function () {
            return (new DashboardController())->index();
        });
        Router::add('GET', '?page=:page', function ($page) {
            return (new DashboardController())->index();
        });
        Router::add('GET', 'Usuario/registro', function () {
            return (new UsuarioController())->registro();
        });
        Router::add('POST', 'Usuario/registro', function () {
            return (new UsuarioController())->registro();
        });
        Router::add('GET', 'Usuario/modificarDatos?id=:id', function ($id) {
            return (new UsuarioController())->modificarDatos($id);
        });
        Router::add('POST', 'Usuario/modificarDatos?id=:id', function ($id) {
            return (new UsuarioController())->modificarDatos($id);
        });
        Router::add('GET', 'Usuario/modificarDatos', function () {
            return (new UsuarioController())->modificarDatos((int)$_GET['id']);
        });
        Router::add('POST', 'Usuario/modificarDatos', function () {
            return (new UsuarioController())->modificarDatos((int)$_GET['id']);
        });
        Router::add('GET', 'Usuario/login', function () {
            return (new UsuarioController())->login();
        });
        Router::add('POST', 'Usuario/login', function () {
            return (new UsuarioController())->login();
        });
        Router::add('GET', 'Usuario/logout', function () {
            return (new UsuarioController())->logout();
        });
        Router::add('GET', 'Categoria/crearCategoria', function () {
            return (new CategoriaController())->createCategoria();
        });
        Router::add('POST', 'Categoria/crearCategoria', function () {
            return (new CategoriaController())->createCategoria();
        });
        Router::add('GET', 'Categoria/mostrarCategorias', function () {
            return (new CategoriaController())->showCategorias();
        });
        Router::add('GET', 'Categoria/modificarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->modificarCategoria($id);
        });
        Router::add('POST', 'Categoria/modificarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->modificarCategoria($id);
        });
        Router::add('GET', 'Categoria/modificarCategoria', function () {
            return (new CategoriaController())->modificarCategoria((int)$_GET['id']);
        });
        Router::add('POST', 'Categoria/actualizarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->updateCategoria($id);
        });
        Router::add('POST', 'Categoria/actualizarCategoria', function () {
            return (new CategoriaController())->updateCategoria((int)$_GET['id']);
        });
        Router::add('POST', 'Categoria/eliminarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->deleteCategoria($id);
        });
        Router::add('POST', 'Categoria/eliminarCategoria', function () {
            return (new CategoriaController())->deleteCategoria((int)$_POST['categoria_id']);
        });
        Router::add('GET', 'Categoria/mostrarProductosCategoria', function () { 
            return (new CategoriaController())->showProductosByCategoria((int)$_GET['id']);
        });
        Router::add('GET', 'Producto/eliminarProducto', function () {
            return (new ProductoController())->deleteProducto((int)$_GET['id']);
        });
        Router::add('GET', 'Producto/modificarProducto?id=:id', function ($id) {
            return (new ProductoController())->modificarProducto((int)$_GET['id']);
        });
        Router::add('POST', 'Producto/modificarProducto?id=:id', function ($id) {
            return (new ProductoController())->modificarProducto((int)$_GET['id']);
        });
        Router::add('GET', 'Producto/modificarProducto', function () {
            return (new ProductoController())->modificarProducto((int)$_GET['id']);
        });
        Router::add('POST', 'Producto/actualizarProducto?id=:id', function ($id) {
            return (new ProductoController())->updateProducto($id);
        });
        Router::add('POST', 'Producto/actualizarProducto', function () {
            return (new ProductoController())->updateProducto((int)$_GET['id']);
        });
        Router::add('POST', 'Producto/eliminarProducto?id=:id', function ($id) {
            return (new ProductoController())->deleteProducto($id);
        });
        Router::add('GET', 'Producto/gestionarProductos', function () {
            return (new ProductoController())->gestionarProductos();
        });
        Router::add('GET', 'Producto/crearProducto', function () {
            return (new ProductoController())->createProducto();
        });
        Router::add('POST', 'Producto/crearProducto', function () {
            return (new ProductoController())->createProducto();
        });
        Router::add('FILES', 'Producto/crearProducto', function () {
            return (new ProductoController())->createProducto();
        });
        Router::add('POST', 'Carrito/anadirCarrito', function () {
            return (new CarritoController())->addCarrito();
        });
        Router::add('GET', 'Carrito/mostrarCarrito', function () {
            return (new CarritoController())->showCarrito();
        });
        Router::add('GET', 'Pedido/crearPedido', function () {
            return (new PedidoController())->createPedido();
        });
        Router::add('POST', 'Pedido/crearPedido', function () {
            return (new PedidoController())->createPedido();
        });
        Router::add('GET', 'Pedido/mostrarPedidos', function () {
            return (new PedidoController())->showPedidos();
        });
        Router::add('POST', 'Pedido/mostrarPedidos', function () {
            return (new PedidoController())->showPedidos();
        });
        Router::add('GET', 'Pedido/completarPedido?id=:id', function ($id) {
            return (new PedidoController())->completarPedido((int)$_GET['id']);
        });
        Router::add('GET', 'Pedido/completarPedido', function () {
            return (new PedidoController())->completarPedido((int)$_GET['id']);
        });
        Router::add('POST', 'Carrito/anadirCantidad', function () {
            return (new CarritoController())->addCantidad();
        });
        Router::add('POST', 'Carrito/eliminarCantidad', function () {
            return (new CarritoController())->removeCantidad();
        });
        Router::add('POST', 'Carrito/eliminarProducto', function () {
            return (new CarritoController())->removeProducto();
        });
        Router::add('POST', 'Carrito/vaciarCarrito', function () {
            return (new CarritoController())->vaciarCarrito();
        }); 
        Router::dispatch();
    }
}
