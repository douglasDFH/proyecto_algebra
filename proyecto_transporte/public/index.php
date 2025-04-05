<?php
// Iniciar sesión
session_start();

// Definir la ruta base del proyecto (un nivel arriba de la carpeta public)
define('BASE_PATH', dirname(__DIR__));

// Función de carga automática (autoloader)
spl_autoload_register(function($class_name) {
    // Buscar el archivo en las carpetas controllers, models y utils
    $directories = ['/controllers/', '/models/', '/utils/'];
    
    foreach ($directories as $directory) {
        $file = BASE_PATH . $directory . $class_name . '.php';
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

// Obtener parámetros de la URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Formatear el nombre del controlador
$controllerClass = ucfirst($controller) . 'Controller';

// Verificar si el controlador existe
if (file_exists(BASE_PATH . '/controllers/' . $controllerClass . '.php')) {
    // Instanciar el controlador
    $controller = new $controllerClass();
    
    // Verificar si la acción existe
    if (method_exists($controller, $action)) {
        // Ejecutar la acción
        $controller->$action();
    } else {
        // Acción no encontrada
        echo "Acción no encontrada: " . $action;
    }
} else {
    // Controlador no encontrado
    echo "Controlador no encontrado: " . $controllerClass;
}
?>