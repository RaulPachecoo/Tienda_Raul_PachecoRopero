<?php

namespace Controllers; 

use Lib\Pages; 
use Utils\Utils; 
use Models\Categoria; 
use Models\Producto; 
use Controllers\CarritoController; 

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

    public function createCategoria(){
        $this->carrito->comprobarLogin(); 

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['categoria'])) {
            ErrorController::showError500("No se ha enviado ninguna categoría.");
            return;
        }
        $categoria = trim($_POST['categoria']); 

        if(!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $categoria)){
            ErrorController::showError500("El nombre de la categoría no es válido.");
            return;
        }
        
        $result = $this->categoria->createCategoria($categoria);

        if (!$result) {
            ErrorController::showError500("Error al crear la categoría.");
            return;
        }
        
        $this->pages->render('categoria/gestionar'); 
    }

    public function showProductosByCategoria(int $id) {
        $producto = Producto::getProductosByCategoria($id);

        if (!$producto) {
            ErrorController::showError404();
            return;
        }

        $this->pages->render('producto/lista', ['productos' => $producto]); 
    }

    public function showCategorias() {
        $this->carrito->comprobarLogin(); 

        $categorias = Categoria::getAll();

        if ($categorias === false) {
            ErrorController::showError500("Error al obtener las categorías.");
            return;
        }

        $this->pages->render('categoria/listarCategorias', ['categoria' => $categorias]); 
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
    
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['nombre'])) {
            ErrorController::showError500("No se ha enviado el nombre de la categoría.");
            return;
        }
        $nombre = trim($_POST['nombre']);

        if (!preg_match('/^[a-zA-Z\s]+$/', $nombre)) {
            ErrorController::showError500("El nombre de la categoría no es válido.");
            return;
        } 
        $result = $this->categoria->updateCategoria($id, $nombre);

        if (!$result) {
            ErrorController::showError500("Error al actualizar la categoría.");
            return;
        }
            
        
    
        $categorias = Categoria::getAll();
        $this->pages->render('categoria/listarCategorias', ['categorias' => $categorias]);
    }
    
    public function deleteCategoria(int $id): void {
        $this->carrito->comprobarLogin();
    
        $categoria = new Categoria();
    
        if (!$categoria->deleteCategoria($id)) {
            ErrorController::showError500("Error al eliminar la categoría.");
            return;
        }
    
        $categorias = Categoria::getAll();
        $this->pages->render('categoria/listarCategorias', ['categorias' => $categorias]);
    }
    
}