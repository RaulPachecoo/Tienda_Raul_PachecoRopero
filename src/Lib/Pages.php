<?php 

namespace Lib;

class Pages {
    public function render(string $pageName, ?array $params = null): void {
        if (!empty($params)) {
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }
        
        require_once dirname(__DIR__) . "/Views/Layout/header.php";
        require_once dirname(__DIR__) . "/Views/{$pageName}.php";
        require_once dirname(__DIR__) . "/Views/Layout/footer.php";
    }
}
