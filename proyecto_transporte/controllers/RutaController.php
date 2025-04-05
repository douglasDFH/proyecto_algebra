<?php
// Usar rutas absolutas completas
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$projectFolder = '/proyecto_transporte'; 
$projectRoot = $serverRoot . $projectFolder;

// Definir la ruta base si no está definida
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $projectRoot);
}

require_once $projectRoot . '../models/RutaModel.php';
require_once $projectRoot . '   ../models/CiudadModel.php';

class RutaController {
    private $rutaModel;
    private $ciudadModel;
    
    public function __construct() {
        $this->rutaModel = new RutaModel();
        $this->ciudadModel = new CiudadModel();
    }
    
    // Mostrar lista de rutas
    public function index() {
        // Obtener todas las rutas
        $rutas = $this->rutaModel->getAll();
        
        // Cargar la vista
        include_once BASE_PATH . '/views/layouts/main.php';
        include_once BASE_PATH . '/views/ruta/index.php';
    }
    
    // Mostrar formulario para crear nueva ruta
    public function create() {
        // Obtener todas las ciudades para los selectores
        $ciudades = $this->ciudadModel->getAll();
        
        // Cargar la vista del formulario
        include_once BASE_PATH . '/views/layouts/main.php';
        include_once BASE_PATH . '/views/ruta/create.php';
    }
    
    // Procesar la creación de una nueva ruta
    public function store() {
        // Validar datos recibidos del formulario
        if (!isset($_POST['origen_id']) || !isset($_POST['destino_id']) || 
            !isset($_POST['distancia']) || !isset($_POST['costo_km'])) {
            $_SESSION['error'] = "Todos los campos son requeridos.";
            header("Location: index.php?controller=ruta&action=create");
            exit;
        }
        
        // Validar que origen y destino sean diferentes
        if ($_POST['origen_id'] == $_POST['destino_id']) {
            $_SESSION['error'] = "El origen y destino deben ser diferentes.";
            header("Location: index.php?controller=ruta&action=create");
            exit;
        }
        
        // Validar valores numéricos
        if (!is_numeric($_POST['distancia']) || $_POST['distancia'] <= 0 ||
            !is_numeric($_POST['costo_km']) || $_POST['costo_km'] <= 0) {
            $_SESSION['error'] = "La distancia y el costo por kilómetro deben ser valores numéricos positivos.";
            header("Location: index.php?controller=ruta&action=create");
            exit;
        }
        
        // Verificar que no exista una ruta con el mismo origen y destino
        if ($this->rutaModel->existeRuta($_POST['origen_id'], $_POST['destino_id'])) {
            $_SESSION['error'] = "Ya existe una ruta con este origen y destino.";
            header("Location: index.php?controller=ruta&action=create");
            exit;
        }
        
        // Asignar valores al modelo
        $this->rutaModel->origen_id = $_POST['origen_id'];
        $this->rutaModel->destino_id = $_POST['destino_id'];
        $this->rutaModel->distancia = $_POST['distancia'];
        $this->rutaModel->costo_km = $_POST['costo_km'];
        
        // Guardar la ruta
        if ($this->rutaModel->create()) {
            $_SESSION['success'] = "Ruta creada correctamente.";
            header("Location: index.php?controller=ruta");
        } else {
            $_SESSION['error'] = "Error al crear la ruta.";
            header("Location: index.php?controller=ruta&action=create");
        }
        exit;
    }
    
    // Mostrar formulario para editar ruta
    public function edit() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID de ruta inválido.";
            header("Location: index.php?controller=ruta");
            exit;
        }
        
        $id = $_GET['id'];
        
        // Obtener datos de la ruta
        if (!$this->rutaModel->getById($id)) {
            $_SESSION['error'] = "Ruta no encontrada.";
            header("Location: index.php?controller=ruta");
            exit;
        }
        
        // Obtener todas las ciudades para los selectores
        $ciudades = $this->ciudadModel->getAll();
        
        // Preparar datos para la vista
        $ruta = [
            'id' => $this->rutaModel->id,
            'origen_id' => $this->rutaModel->origen_id,
            'destino_id' => $this->rutaModel->destino_id,
            'distancia' => $this->rutaModel->distancia,
            'costo_km' => $this->rutaModel->costo_km
        ];
        
        // Cargar la vista del formulario
        include_once BASE_PATH . '/views/layouts/main.php';
        include_once BASE_PATH . '/views/ruta/edit.php';
    }
    
    // Procesar la actualización de una ruta
    public function update() {
        // Validar datos recibidos del formulario
        if (!isset($_POST['id']) || !is_numeric($_POST['id']) ||
            !isset($_POST['origen_id']) || !isset($_POST['destino_id']) || 
            !isset($_POST['distancia']) || !isset($_POST['costo_km'])) {
            $_SESSION['error'] = "Todos los campos son requeridos.";
            header("Location: index.php?controller=ruta");
            exit;
        }
        
        $id = $_POST['id'];
        
        // Validar que origen y destino sean diferentes
        if ($_POST['origen_id'] == $_POST['destino_id']) {
            $_SESSION['error'] = "El origen y destino deben ser diferentes.";
            header("Location: index.php?controller=ruta&action=edit&id=$id");
            exit;
        }
        
        // Validar valores numéricos
        if (!is_numeric($_POST['distancia']) || $_POST['distancia'] <= 0 ||
            !is_numeric($_POST['costo_km']) || $_POST['costo_km'] <= 0) {
            $_SESSION['error'] = "La distancia y el costo por kilómetro deben ser valores numéricos positivos.";
            header("Location: index.php?controller=ruta&action=edit&id=$id");
            exit;
        }
        
        // Verificar que no exista otra ruta con el mismo origen y destino (excluyendo la actual)
        if ($this->rutaModel->existeRutaExcluyendo($_POST['origen_id'], $_POST['destino_id'], $id)) {
            $_SESSION['error'] = "Ya existe otra ruta con este origen y destino.";
            header("Location: index.php?controller=ruta&action=edit&id=$id");
            exit;
        }
        
        // Asignar valores al modelo
        $this->rutaModel->id = $id;
        $this->rutaModel->origen_id = $_POST['origen_id'];
        $this->rutaModel->destino_id = $_POST['destino_id'];
        $this->rutaModel->distancia = $_POST['distancia'];
        $this->rutaModel->costo_km = $_POST['costo_km'];
        
        // Actualizar la ruta
        if ($this->rutaModel->update()) {
            $_SESSION['success'] = "Ruta actualizada correctamente.";
            header("Location: index.php?controller=ruta");
        } else {
            $_SESSION['error'] = "Error al actualizar la ruta.";
            header("Location: index.php?controller=ruta&action=edit&id=$id");
        }
        exit;
    }
    
    // Eliminar una ruta
    public function delete() {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $_SESSION['error'] = "ID de ruta inválido.";
            header("Location: index.php?controller=ruta");
            exit;
        }
        
        $id = $_GET['id'];
        
        // Asignar el ID al modelo
        $this->rutaModel->id = $id;
        
        // Eliminar la ruta
        if ($this->rutaModel->delete()) {
            $_SESSION['success'] = "Ruta eliminada correctamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar la ruta.";
        }
        
        header("Location: index.php?controller=ruta");
        exit;
    }
}
?>