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
    public function render(string $pageName, array $params = null, bool $loadHeader = true, bool $loadFooter = true): void {
        // Extraer variables de $params si no está vacío
        if (!empty($params)) {
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }

        // Definir la ruta base de las vistas
        $baseViewPath = __DIR__ . '/../Views/';

        // Incluir archivos con verificación de existencia solo si se debe cargar
        if ($loadHeader) {
            $this->includeFile($baseViewPath . "layout/header.php");
        }

        $this->includeFile($baseViewPath . ltrim($pageName, '/').".php");

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
