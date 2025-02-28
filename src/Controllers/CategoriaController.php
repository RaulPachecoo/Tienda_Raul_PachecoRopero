<?php

namespace Controllers;

use Lib\Pages;
use Utils\Utils;
use Models\Categoria;
use Models\Producto;
use Controllers\CarritoController;
use Pagerfanta\Pagerfanta;

class CategoriaController{

    private $pages;
    private $categoria;
    private $carrito;

    public function __construct(){
        $this->pages = new Pages();
        $this->categoria = new Categoria();
        $this->carrito = new CarritoController();
    }

    public static function getCategorias(){
        return Categoria::getAll();
    }

    public function createCategoria() {
        $this->carrito->comprobarLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['categoria'])) {
                $errores = ["No se ha enviado ninguna categoría."];
                $this->pages->render('categoria/crearCategoria', ['errores' => $errores]);
                return;
            }
            $categoria = trim($_POST['categoria']);

            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $categoria)) {
                $errores = ["El nombre de la categoría no es válido."];
                $this->pages->render('categoria/crearCategoria', ['errores' => $errores]);
                return;
            }

            $result = $this->categoria->createCategoria($categoria);

            if (!$result) {
                $errores = ["Error al crear la categoría."];
                $this->pages->render('categoria/crearCategoria', ['errores' => $errores]);
                return;
            }

            $mensaje = "Categoría creada con éxito.";
            $categorias = Categoria::getAll();
            $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'mensaje' => $mensaje]);
            return;
        }

        $this->pages->render('categoria/crearCategoria');
    }

    public function showProductosByCategoria(int $id, int $page = 1) {
        $maxPerPage = 9; // Número máximo de productos por página
        $pagerfanta = Producto::getPaginatedProductosByCategoria($id, $page, $maxPerPage);

        if ($pagerfanta->getNbResults() === 0) {
            $this->pages->render('producto/lista', ['productos' => [], 'mensaje' => 'No hay productos disponibles en esta categoría.'], true, true);
            return;
        }

        $this->pages->render('producto/lista', [
            'productos' => $pagerfanta->getCurrentPageResults(),
            'pagerfanta' => $pagerfanta
        ], true, true);
    }

    public function showCategorias() {
        $categorias = Categoria::getAll();
        if ($categorias) {
            $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias]);
        } else {
            $this->pages->render('error'); // Asegurarse de que la vista 'error' exista
        }
    }

    public function modificarCategoria(int $id) {
        $this->carrito->comprobarLogin();

        $categoria = Categoria::getCategoriaById($id);

        if (!$categoria) {
            ErrorController::showError404();
            return;
        }

        $this->pages->render('categoria/modificar', ['categoria' => $categoria]);
    }

    public function updateCategoria(int $id): void {
        $this->carrito->comprobarLogin();

        $categoria = Categoria::getCategoriaById($id); // Obtener la categoría antes de la validación

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['nombre'])) {
            $errores = ["No se ha enviado el nombre de la categoría."];
            $this->pages->render('categoria/modificar', ['categoria' => $categoria, 'errores' => $errores]);
            return;
        }
        $nombre = trim($_POST['nombre']);

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]+$/', $nombre)) {
            $errores = ["El nombre de la categoría no es válido."];
            $this->pages->render('categoria/modificar', ['categoria' => $categoria, 'errores' => $errores]);
            return;
        }
        
        $result = $this->categoria->updateCategoria($id, $nombre);

        if (!$result) {
            $errores = ["Error al actualizar la categoría."];
            $this->pages->render('categoria/modificar', ['categoria' => $categoria, 'errores' => $errores]);
            return;
        }

        $mensaje = "Categoría actualizada con éxito.";
        $categorias = Categoria::getAll();
        $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'mensaje' => $mensaje]);
    }

    public function deleteCategoria(int $id): void {
        $this->carrito->comprobarLogin();

        $categoria = new Categoria();

        if (!$categoria->deleteCategoria($id)) {
            $errores = ["Error al eliminar la categoría."];
            $categorias = Categoria::getAll();
            $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'errores' => $errores]);
            return;
        }

        $mensaje = "Categoría eliminada con éxito.";
        $categorias = Categoria::getAll();
        $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'mensaje' => $mensaje]);
    }

}
?>