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
        
        // Si la vista no existe, se muestra un mensaje de error
        if (!file_exists($viewPath)) {
            echo "Error: La vista {$pageName} no existe.";
            return;  // Si la vista no se encuentra, terminamos la ejecución
        }

        // Forzar exclusión de header y footer en la página de registro de usuario
        if (strpos($pageName, 'usuario/registro') !== false) {
            $loadHeader = false;  // No cargar el header en la vista de registro
            $loadFooter = false;  // No cargar el footer en la vista de registro
        }
    
        // Cargar el header si se indica que se debe cargar
        if ($loadHeader) {
            $this->includeFile($baseViewPath . "layout/header.php");  // Incluye el archivo header.php
        }
    
        // Si hay parámetros, asignarlos a variables locales
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $$key = $value;  // Crea variables con el nombre del parámetro
            }
        }
    
        // Incluir la vista principal
        include $viewPath;
    
        // Cargar el footer si se indica que se debe cargar
        if ($loadFooter) {
            $this->includeFile($baseViewPath . "layout/footer.php");  // Incluye el archivo footer.php
        }
    }
    
    /**
     * Incluye un archivo si existe, mostrando un mensaje de error si no se encuentra.
     *
     * @param string $file Ruta del archivo a incluir.
     */
    private function includeFile(string $file): void {
        // Verificar si el archivo existe antes de incluirlo
        if (file_exists($file)) {
            require_once $file;  // Incluir el archivo
        } else {
            // Mostrar un mensaje de error si el archivo no existe
            echo "<p style='color: red;'>Error: No se pudo cargar la vista <b>$file</b></p>";
        }
    }
}
?>