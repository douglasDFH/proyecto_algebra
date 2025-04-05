<?php
class HomeController {
    public function index() {
        // Usar la constante BASE_PATH definida en index.php
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', dirname(__DIR__));
        }
        
        // Renderizar la vista principal usando rutas absolutas
        include_once BASE_PATH . '/views/layouts/main.php';
        include_once BASE_PATH . '/views/home/index.php';
        
        // Comprobar si existen los archivos antes de incluirlos
        if (file_exists(BASE_PATH . '/views/layouts/footer.php')) {
            include_once BASE_PATH . '/views/layouts/footer.php';
        }
        
        if (file_exists(BASE_PATH . '/views/layouts/scripts.php')) {
            include_once BASE_PATH . '/views/layouts/scripts.php';
        }
        
        if (file_exists(BASE_PATH . '/views/layouts/alertas.php')) {
            include_once BASE_PATH . '/views/layouts/alertas.php';
        }
    }
}
?>