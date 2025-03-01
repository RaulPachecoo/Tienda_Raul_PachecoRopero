<?php

namespace Controllers;

use Lib\Pages;
use Models\Producto;
use Controllers\CarritoController;

class DashboardController
{
    private Pages $pages;  // Instancia de la clase Pages, que se encarga de la renderización de vistas
    private CarritoController $carrito;  // Instancia del controlador CarritoController, para manejar operaciones relacionadas con el carrito

    // Constructor que inicializa las dependencias necesarias para el controlador
    public function __construct()
    {
        $this->pages = new Pages();  // Se crea la instancia de Pages para manejar las vistas
        $this->carrito = new CarritoController();  // Se crea la instancia de CarritoController para manejar las operaciones del carrito
    }

    // Método que maneja la vista principal del dashboard, mostrando los productos
    public function index()
    {
        // Obtiene el número de página de la URL, por defecto es 1 si no se especifica
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $maxPerPage = 9;  // Establece el número máximo de productos a mostrar por página

        // Obtiene los productos paginados usando la clase Producto, que devuelve una instancia de Pagerfanta
        $pagerfanta = Producto::getPaginatedProductos($page, $maxPerPage);

        // Renderiza la vista 'dashboard/inicio', pasando los productos actuales, el objeto Pagerfanta y la página actual
        $this->pages->render('dashboard/inicio', [
            'productos' => $pagerfanta->getCurrentPageResults(),  // Productos que se deben mostrar en la página actual
            'pagerfanta' => $pagerfanta,  // Paginador para navegar entre las páginas de productos
            'page' => $page  // Número de página actual
        ]);
    }
}
?>
