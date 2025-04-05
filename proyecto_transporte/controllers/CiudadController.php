<?php
// Usar rutas absolutas completas
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$projectFolder = '/proyecto_transporte'; 
$projectRoot = $serverRoot . $projectFolder;

// Definir la ruta base si no está definida
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $projectRoot);
}

require_once $projectRoot . '/models/CiudadModel.php';

class CiudadController {
    private $ciudadModel;
    
    public function __construct() {
        $this->ciudadModel = new CiudadModel();
    }
    
    // Mostrar lista de ciudades
    public function index() {
        // Obtener todas las ciudades
        $ciudades = $this->ciudadModel->getAll();
        
        // Cargar la vista
        include_once BASE_PATH . '/views/layouts/main.php';
        include_once BASE_PATH . '/views/ciudad/index.php';
    }
    
    // Mostrar formulario para crear nueva ciudad
    public function create() {
        // Cargar la vista del formulario
        include_once BASE_PATH . '/views/layouts/main.php';
        include_once BASE_PATH . '/views/ciudad/create.php';
    }
    
    // Procesar la creación de una nueva ciudad
    public function store() {
        // Validar datos recibidos del formulario
        if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
            $_SESSION['error'] = "El nombre de la ciudad es requerido.";
            header("Location: index.php?controller=ciudad&action=create");
            exit;
        }
        
        // Verificar que no exista una ciudad con el mismo nombre
        $nombre = trim($_POST['nombre']);
        if ($this->ciudadModel->existeCiudad($nombre)) {
            $_SESSION['error'] = "Ya existe una ciudad con este nombre.";
            header("Location: index.php?controller=ciudad&action=create");
            exit;
        }
        
        // Asignar valores al modelo
        $this->ciudadModel->nombre = $nombre;
        
        // Guardar la ciudad
        if ($this->ciudadModel->create()) {
            $_SESSION['success'] = "Ciudad creada correctamente.";
            header("Location: index.php?controller=ciudad");
        } else {
            $_SESSION['error'] = "Error al crear la ciudad.";
            header("Location: index.php?controller=ciudad&action=create");
        }
        exit;
    }
    
    // Mostrar formulario para editar ciudad
    public function edit() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID de ciudad inválido.";
            header("Location: index.php?controller=ciudad");
            exit;
        }
        
        $id = $_GET['id'];
        
        // Obtener datos de la ciudad
        if (!$this->ciudadModel->getById($id)) {
            $_SESSION['error'] = "Ciudad no encontrada.";
            header("Location: index.php?controller=ciudad");
            exit;
        }
        
        // Preparar datos para la vista
        $ciudad = [
            'id' => $this->ciudadModel->id,
            'nombre' => $this->ciudadModel->nombre
        ];
        
        // Cargar la vista del formulario
        include_once BASE_PATH . '/views/layouts/main.php';
        include_once BASE_PATH . '/views/ciudad/edit.php';
    }
    
    // Procesar la actualización de una ciudad
    public function update() {
        // Validar datos recibidos del formulario
        if (!isset($_POST['id']) || !is_numeric($_POST['id']) ||
            !isset($_POST['nombre']) || empty($_POST['nombre'])) {
            $_SESSION['error'] = "Todos los campos son requeridos.";
            header("Location: index.php?controller=ciudad");
            exit;
        }
        
        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);
        
        // Verificar que no exista otra ciudad con el mismo nombre (excluyendo la actual)
        if ($this->ciudadModel->existeCiudadExcluyendo($nombre, $id)) {
            $_SESSION['error'] = "Ya existe otra ciudad con este nombre.";
            header("Location: index.php?controller=ciudad&action=edit&id=$id");
            exit;
        }
        
        // Asignar valores al modelo
        $this->ciudadModel->id = $id;
        $this->ciudadModel->nombre = $nombre;
        
        // Actualizar la ciudad
        if ($this->ciudadModel->update()) {
            $_SESSION['success'] = "Ciudad actualizada correctamente.";
            header("Location: index.php?controller=ciudad");
        } else {
            $_SESSION['error'] = "Error al actualizar la ciudad.";
            header("Location: index.php?controller=ciudad&action=edit&id=$id");
        }
        exit;
    }
    
    // Eliminar una ciudad
    public function delete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID de ciudad inválido.";
            header("Location: index.php?controller=ciudad");
            exit;
        }
        
        $id = $_GET['id'];
        
        // Verificar si la ciudad está siendo utilizada en rutas
        if ($this->ciudadModel->ciudadEnUso($id)) {
            $_SESSION['error'] = "No se puede eliminar la ciudad porque está siendo utilizada en una o más rutas.";
            header("Location: index.php?controller=ciudad");
            exit;
        }
        
        // Asignar el ID al modelo
        $this->ciudadModel->id = $id;
        
        // Eliminar la ciudad
        if ($this->ciudadModel->delete()) {
            $_SESSION['success'] = "Ciudad eliminada correctamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar la ciudad.";
        }
        
        header("Location: index.php?controller=ciudad");
        exit;
    }
}
?>