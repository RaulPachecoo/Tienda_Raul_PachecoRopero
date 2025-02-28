<?php

namespace Controllers;

use Lib\Pages;
use Models\Producto;
use Controllers\CarritoController;

class DashboardController
{
    private Pages $pages;
    private CarritoController $carrito;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->carrito = new CarritoController();
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $maxPerPage = 9; // Número máximo de productos por página
        $pagerfanta = Producto::getPaginatedProductos($page, $maxPerPage);

        $this->pages->render('dashboard/inicio', [
            'productos' => $pagerfanta->getCurrentPageResults(),
            'pagerfanta' => $pagerfanta,
            'page' => $page
        ]);
    }
}