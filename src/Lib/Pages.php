<?php 

namespace Lib;

class Pages {
    /**
     * Renderiza una vista con parámetros opcionales.
     *
     * @param string $pageName Nombre de la vista a cargar.
     * @param array|null $params Parámetros opcionales para la vista.
     * @param bool $loadHeader Indica si debe cargar el header.
     * @param bool $loadFooter Indica si debe cargar el footer.
     */
    public function render(string $pageName, array $params = [], bool $loadHeader = true, bool $loadFooter = true): void {
        // Definir la ruta base de las vistas
        $baseViewPath = __DIR__ . '/../Views/';
        
        // Verificar si la vista existe antes de incluirla
        $viewPath = $baseViewPath . ltrim($pageName, '/') . ".php";
        
        if (!file_exists($viewPath)) {
            // Manejo de error si la vista no existe
            echo "Error: La vista {$pageName} no existe.";
            return;
        }
    
        if ($loadHeader) {
            $this->includeFile($baseViewPath . "layout/header.php");
        }
    
        // Pasar las variables de $params a la vista explícitamente
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $$key = $value; // Asignación explícita de variables
            }
        }
    
        // Incluir la vista
        include $viewPath;
    
        

        if ($loadFooter) {
            $this->includeFile($baseViewPath . "layout/footer.php");
        }
    }
    


    /**
     * Incluye un archivo si existe, de lo contrario muestra un error.
     *
     * @param string $file Ruta del archivo a incluir.
     */
    private function includeFile(string $file): void {
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "<p style='color: red;'>Error: No se pudo cargar la vista <b>$file</b></p>";
        }
    }
}
?>
