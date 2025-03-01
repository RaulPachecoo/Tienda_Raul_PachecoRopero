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
        // Definir las rutas principales para la página de inicio (Dashboard)
        Router::add('GET', '', function () {
            return (new DashboardController())->index(); // Ruta para la página principal
        });

        Router::add('GET', '?page=:page', function ($page) {
            return (new DashboardController())->index(); // Ruta para la página con parámetro de página
        });

        // Rutas para el registro de usuarios
        Router::add('GET', 'Usuario/registro', function () {
            return (new UsuarioController())->registro(); // Ruta para mostrar el formulario de registro
        });
        Router::add('POST', 'Usuario/registro', function () {
            return (new UsuarioController())->registro(); // Ruta para procesar el registro
        });

        // Rutas para modificar los datos del usuario
        Router::add('GET', 'Usuario/modificarDatos?id=:id', function ($id) {
            return (new UsuarioController())->modificarDatos($id); // Ruta para mostrar formulario de modificación de usuario
        });
        Router::add('POST', 'Usuario/modificarDatos?id=:id', function ($id) {
            return (new UsuarioController())->modificarDatos($id); // Ruta para procesar la modificación de datos
        });
        Router::add('GET', 'Usuario/modificarDatos', function () {
            return (new UsuarioController())->modificarDatos((int)$_GET['id']); // Ruta para modificar datos sin parámetros
        });
        Router::add('POST', 'Usuario/modificarDatos', function () {
            return (new UsuarioController())->modificarDatos((int)$_GET['id']); // Ruta POST para modificar datos sin parámetros
        });

        // Rutas para login y logout de usuarios
        Router::add('GET', 'Usuario/login', function () {
            return (new UsuarioController())->login(); // Ruta para mostrar formulario de login
        });
        Router::add('POST', 'Usuario/login', function () {
            return (new UsuarioController())->login(); // Ruta para procesar el login
        });
        Router::add('GET', 'Usuario/logout', function () {
            return (new UsuarioController())->logout(); // Ruta para cerrar sesión
        });

        // Rutas relacionadas con la gestión de categorías
        Router::add('GET', 'Categoria/crearCategoria', function () {
            return (new CategoriaController())->createCategoria(); // Ruta para mostrar el formulario de creación de categoría
        });
        Router::add('POST', 'Categoria/crearCategoria', function () {
            return (new CategoriaController())->createCategoria(); // Ruta para procesar la creación de una categoría
        });
        Router::add('GET', 'Categoria/mostrarCategorias', function () {
            return (new CategoriaController())->showCategorias(); // Ruta para mostrar las categorías existentes
        });

        // Rutas para modificar y actualizar categorías
        Router::add('GET', 'Categoria/modificarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->modificarCategoria($id); // Ruta para mostrar el formulario de modificación de categoría
        });
        Router::add('POST', 'Categoria/modificarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->modificarCategoria($id); // Ruta para procesar la modificación de categoría
        });
        Router::add('GET', 'Categoria/modificarCategoria', function () {
            return (new CategoriaController())->modificarCategoria((int)$_GET['id']); // Ruta para modificar categoría sin parámetros
        });
        Router::add('POST', 'Categoria/actualizarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->updateCategoria($id); // Ruta para actualizar la categoría
        });
        Router::add('POST', 'Categoria/actualizarCategoria', function () {
            return (new CategoriaController())->updateCategoria((int)$_GET['id']); // Ruta para actualizar categoría sin parámetros
        });

        // Rutas para eliminar categorías
        Router::add('POST', 'Categoria/eliminarCategoria?id=:id', function ($id) {
            return (new CategoriaController())->deleteCategoria($id); // Ruta para eliminar categoría por ID
        });
        Router::add('POST', 'Categoria/eliminarCategoria', function () {
            return (new CategoriaController())->deleteCategoria((int)$_POST['categoria_id']); // Ruta para eliminar categoría desde formulario
        });

        // Ruta para mostrar productos de una categoría específica
        Router::add('GET', 'Categoria/mostrarProductosCategoria', function () { 
            return (new CategoriaController())->showProductosByCategoria((int)$_GET['id']); // Ruta para mostrar productos de la categoría
        });

        // Rutas para gestionar productos
        Router::add('GET', 'Producto/eliminarProducto', function () {
            return (new ProductoController())->deleteProducto((int)$_GET['id']); // Ruta para eliminar un producto
        });
        Router::add('GET', 'Producto/modificarProducto?id=:id', function ($id) {
            return (new ProductoController())->modificarProducto((int)$_GET['id']); // Ruta para modificar producto por ID
        });
        Router::add('POST', 'Producto/modificarProducto?id=:id', function ($id) {
            return (new ProductoController())->modificarProducto((int)$_GET['id']); // Ruta POST para procesar la modificación del producto
        });
        Router::add('GET', 'Producto/modificarProducto', function () {
            return (new ProductoController())->modificarProducto((int)$_GET['id']); // Ruta GET para modificar producto sin parámetros
        });

        // Rutas para actualizar y eliminar productos
        Router::add('POST', 'Producto/actualizarProducto?id=:id', function ($id) {
            return (new ProductoController())->updateProducto($id); // Ruta para actualizar producto
        });
        Router::add('POST', 'Producto/actualizarProducto', function () {
            return (new ProductoController())->updateProducto((int)$_GET['id']); // Ruta para actualizar producto sin parámetros
        });
        Router::add('POST', 'Producto/eliminarProducto?id=:id', function ($id) {
            return (new ProductoController())->deleteProducto($id); // Ruta POST para eliminar producto
        });

        // Ruta para gestionar productos (paginar)
        Router::add('GET', 'Producto/gestionarProductos', function () {
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Obtener la página actual de la query string
            return (new ProductoController())->gestionarProductos($page); // Ruta para gestionar productos con paginación
        });

        // Rutas para crear nuevos productos
        Router::add('GET', 'Producto/crearProducto', function () {
            return (new ProductoController())->createProducto(); // Ruta para mostrar formulario de creación de producto
        });
        Router::add('POST', 'Producto/crearProducto', function () {
            return (new ProductoController())->createProducto(); // Ruta para procesar la creación de un producto
        });
        Router::add('FILES', 'Producto/crearProducto', function () {
            return (new ProductoController())->createProducto(); // Ruta para procesar la creación de producto con archivos
        });

        // Rutas para gestionar el carrito
        Router::add('POST', 'Carrito/anadirCarrito', function () {
            return (new CarritoController())->addCarrito(); // Ruta para añadir un producto al carrito
        });
        Router::add('GET', 'Carrito/mostrarCarrito', function () {
            return (new CarritoController())->showCarrito(); // Ruta para mostrar los productos en el carrito
        });

        // Rutas para gestionar pedidos
        Router::add('GET', 'Pedido/crearPedido', function () {
            return (new PedidoController())->createPedido(); // Ruta para crear un pedido
        });
        Router::add('POST', 'Pedido/crearPedido', function () {
            return (new PedidoController())->createPedido(); // Ruta para procesar la creación de un pedido
        });
        Router::add('GET', 'Pedido/mostrarPedidos', function () {
            return (new PedidoController())->showPedidos(); // Ruta para mostrar los pedidos existentes
        });
        Router::add('POST', 'Pedido/mostrarPedidos', function () {
            return (new PedidoController())->showPedidos(); // Ruta POST para mostrar pedidos
        });

        // Rutas para completar pedidos
        Router::add('GET', 'Pedido/completarPedido?id=:id', function ($id) {
            return (new PedidoController())->completarPedido((int)$_GET['id']); // Ruta para completar un pedido por ID
        });
        Router::add('GET', 'Pedido/completarPedido', function () {
            return (new PedidoController())->completarPedido((int)$_GET['id']); // Ruta para completar pedido sin parámetros
        });

        // Rutas para gestionar el carrito (añadir o eliminar cantidad/productos)
        Router::add('POST', 'Carrito/anadirCantidad', function () {
            return (new CarritoController())->addCantidad(); // Ruta para añadir cantidad a un producto del carrito
        });
        Router::add('POST', 'Carrito/eliminarCantidad', function () {
            return (new CarritoController())->removeCantidad(); // Ruta para eliminar cantidad de un producto del carrito
        });
        Router::add('POST', 'Carrito/eliminarProducto', function () {
            return (new CarritoController())->removeProducto(); // Ruta para eliminar un producto del carrito
        });
        Router::add('POST', 'Carrito/vaciarCarrito', function () {
            return (new CarritoController())->vaciarCarrito(); // Ruta para vaciar el carrito
        });

        // Ejecutar el enrutador para manejar la solicitud
        Router::dispatch();
    }
}
