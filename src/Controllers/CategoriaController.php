<?php

namespace Controllers;

use Lib\Pages;
use Utils\Utils;
use Models\Categoria;
use Models\Producto;
use Controllers\CarritoController;
use Pagerfanta\Pagerfanta;

class CategoriaController{

    private $pages;  // Objeto para manejar la renderización de las páginas
    private $categoria;  // Objeto para interactuar con el modelo Categoria
    private $carrito;  // Objeto para interactuar con el carrito de compras

    // Constructor que inicializa las dependencias
    public function __construct(){
        $this->pages = new Pages();  // Inicializa la clase Pages para el manejo de vistas
        $this->categoria = new Categoria();  // Inicializa el modelo Categoria
        $this->carrito = new CarritoController();  // Inicializa el controlador del carrito
    }

    // Método estático que obtiene todas las categorías
    public static function getCategorias(){
        return Categoria::getAll();  // Llama al modelo Categoria para obtener todas las categorías
    }

    // Método para crear una nueva categoría
    public function createCategoria() {
        $this->carrito->comprobarLogin();  // Verifica si el usuario está logueado

        // Si la solicitud es POST, procesa la creación de la categoría
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica si el campo de la categoría está vacío
            if (empty($_POST['categoria'])) {
                $errores = ["No se ha enviado ninguna categoría."];  // Muestra un error si no se ha enviado el nombre de la categoría
                $this->pages->render('categoria/crearCategoria', ['errores' => $errores]);
                return;
            }
            $categoria = trim(string: $_POST['categoria']);  // Elimina los espacios adicionales

            // Valida el formato del nombre de la categoría
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $categoria)) {
                $errores = ["El nombre de la categoría no es válido."];  // Si el nombre no es válido, muestra un error
                $this->pages->render('categoria/crearCategoria', ['errores' => $errores]);
                return;
            }

            // Llama al modelo para crear la categoría
            $result = $this->categoria->createCategoria($categoria);

            // Si hubo un error en la creación, muestra un mensaje de error
            if (!$result) {
                $errores = ["La categoría ya existe o hubo un error al crearla."];
                $this->pages->render('categoria/crearCategoria', ['errores' => $errores]);
                return;
            }

            // Si la categoría se creó correctamente, muestra un mensaje de éxito y las categorías actualizadas
            $mensaje = "Categoría creada con éxito.";
            $categorias = Categoria::getAll();
            $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'mensaje' => $mensaje]);
            return;
        }

        // Si no es una solicitud POST, solo muestra el formulario para crear una categoría
        $this->pages->render('categoria/crearCategoria');
    }

    // Método para mostrar los productos de una categoría específica, paginados
    public function showProductosByCategoria(int $id, int $page = 1) {
        $maxPerPage = 9;  // Número máximo de productos por página
        $pagerfanta = Producto::getPaginatedProductosByCategoria($id, $page, $maxPerPage);  // Obtiene los productos paginados de la categoría

        // Si no hay productos, muestra un mensaje diciendo que no hay productos disponibles
        if ($pagerfanta->getNbResults() === 0) {
            $this->pages->render('producto/lista', ['productos' => [], 'mensaje' => 'No hay productos disponibles en esta categoría.'], true, true);
            return;
        }

        // Muestra los productos de la categoría actual paginados
        $this->pages->render('producto/lista', [
            'productos' => $pagerfanta->getCurrentPageResults(),
            'pagerfanta' => $pagerfanta
        ], true, true);
    }

    // Método para mostrar todas las categorías disponibles
    public function showCategorias(): void {
        $categorias = Categoria::getAll();  // Obtiene todas las categorías
        if ($categorias) {
            // Si hay categorías, las muestra
            $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias]);
        } else {
            // Si no hay categorías, muestra una página de error
            $this->pages->render('error');  // Asegúrate de que la vista 'error' exista
        }
    }

    // Método para mostrar el formulario de modificación de una categoría
    public function modificarCategoria(int $id) {
        $this->carrito->comprobarLogin();  // Verifica si el usuario está logueado

        // Obtiene los datos de la categoría a modificar
        $categoria = Categoria::getCategoriaById($id);

        // Si no se encuentra la categoría, muestra un error 404
        if (!$categoria) {
            ErrorController::showError404();
            return;
        }

        // Muestra el formulario para modificar la categoría con los datos actuales
        $this->pages->render('categoria/modificar', ['categoria' => $categoria]);
    }

    // Método para actualizar los datos de una categoría
    public function updateCategoria(int $id): void {
        $this->carrito->comprobarLogin();  // Verifica si el usuario está logueado

        // Obtiene los datos actuales de la categoría
        $categoria = Categoria::getCategoriaById($id);

        // Verifica si la solicitud es POST y si el nombre de la categoría no está vacío
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['nombre'])) {
            $errores = ["No se ha enviado el nombre de la categoría."];
            $this->pages->render('categoria/modificar', ['categoria' => $categoria, 'errores' => $errores]);
            return;
        }
        $nombre = trim($_POST['nombre']);  // Elimina los espacios adicionales

        // Valida el formato del nuevo nombre de la categoría
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚüÜ\s]+$/', $nombre)) {
            $errores = ["El nombre de la categoría no es válido."];
            $this->pages->render('categoria/modificar', ['categoria' => $categoria, 'errores' => $errores]);
            return;
        }

        // Llama al modelo para actualizar la categoría
        $result = $this->categoria->updateCategoria($id, $nombre);

        // Si hubo un error al actualizar, muestra un mensaje de error
        if (!$result) {
            $errores = ["Error al actualizar la categoría."];
            $this->pages->render('categoria/modificar', ['categoria' => $categoria, 'errores' => $errores]);
            return;
        }

        // Si la categoría se actualizó correctamente, muestra un mensaje de éxito y las categorías actualizadas
        $mensaje = "Categoría actualizada con éxito.";
        $categorias = Categoria::getAll();
        $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'mensaje' => $mensaje]);
    }

    // Método para eliminar una categoría
    public function deleteCategoria(int $id): void {
        $this->carrito->comprobarLogin();  // Verifica si el usuario está logueado

        $categoria = new Categoria();  // Crea una nueva instancia de la clase Categoria

        // Llama al método de la clase Categoria para eliminar la categoría
        if (!$categoria->deleteCategoria($id)) {
            $errores = ["Error al eliminar la categoría."];
            $categorias = Categoria::getAll();
            $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'errores' => $errores]);
            return;
        }

        // Si la categoría se eliminó correctamente, muestra un mensaje de éxito y las categorías actualizadas
        $mensaje = "Categoría eliminada con éxito.";
        $categorias = Categoria::getAll();
        $this->pages->render('categoria/mostrarCategorias', ['categorias' => $categorias, 'mensaje' => $mensaje]);
    }

}
?>
