<?php
// Definir la ruta base del proyecto
$base_path = dirname(__DIR__);

require_once $base_path . '/models/TransporteModel.php';
require_once $base_path . '/models/CiudadModel.php';
require_once $base_path . '/models/RutaModel.php';

class TransporteController {
    private $transporteModel;
    private $ciudadModel;
    private $rutaModel;
    private $base_path;
    
    public function __construct() {
        $this->transporteModel = new TransporteModel();
        $this->ciudadModel = new CiudadModel();
        $this->rutaModel = new RutaModel();
        // Usar la constante BASE_PATH definida en index.php
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}
$this->base_path = BASE_PATH;
    }
    
    // Mostrar página principal de transporte
    public function index() {
        $optimizaciones = $this->transporteModel->getAllOptimizaciones();
        
        include_once $this->base_path . '/views/layouts/main.php';
        include_once $this->base_path . '/views/transporte/index.php';
    }
    
    // Mostrar formulario de optimización
    public function optimizar() {
        $rutas = $this->transporteModel->getRutasOptimizacion();
        
        include_once $this->base_path . '/views/layouts/main.php';
        include_once $this->base_path . '/views/transporte/optimizar.php';
    }
    
    // Procesar la optimización
    public function procesarOptimizacion() {
        $total_productos = isset($_POST['total_productos']) ? intval($_POST['total_productos']) : 0;
        
        if ($total_productos <= 0) {
            $_SESSION['error'] = "La cantidad de productos debe ser mayor a cero.";
            header("Location: index.php?controller=transporte&action=optimizar");
            exit;
        }
        
        try {
            // Realizar cálculo de optimización
            $resultados = $this->transporteModel->optimizarDistribucion($total_productos);
            
            // Guardar resultados en la base de datos
            $resultados_db = [];
            foreach ($resultados as $resultado) {
                $resultados_db[] = [
                    'ruta_id' => $resultado['ruta_id'],
                    'cantidad_productos' => $resultado['cantidad_productos'],
                    'costo_total' => $resultado['costo_total']
                ];
            }
            
            $optimizacion_id = $this->transporteModel->saveOptimizacion($total_productos, $resultados_db);
            
            // Redirigir a la página de resultados
            header("Location: index.php?controller=transporte&action=resultados&id=" . $optimizacion_id);
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = "Error al realizar la optimización: " . $e->getMessage();
            header("Location: index.php?controller=transporte&action=optimizar");
            exit;
        }
    }
    
    // Mostrar resultados de optimización
    public function resultados() {
        $optimizacion_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($optimizacion_id <= 0) {
            $_SESSION['error'] = "ID de optimización inválido.";
            header("Location: index.php?controller=transporte");
            exit;
        }
        
        $stmt = $this->transporteModel->getResultadosOptimizacion($optimizacion_id);
        $resultados = [];
        $costo_total = 0;
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $resultados[] = [
                'id' => $row['id'],
                'ruta_id' => $row['ruta_id'],
                'origen' => $row['origen_nombre'],
                'destino' => $row['destino_nombre'],
                'distancia' => $row['distancia'],
                'costo_km' => $row['costo_km'],
                'cantidad_productos' => $row['cantidad_productos'],
                'costo_total' => $row['costo_total']
            ];
            
            $costo_total += $row['costo_total'];
        }
        
        include_once $this->base_path . '/views/layouts/main.php';
        include_once $this->base_path . '/views/transporte/resultados.php';
    }
    
    // Mostrar historia de optimizaciones
    public function historia() {
        $optimizaciones = $this->transporteModel->getAllOptimizaciones();
        
        include_once $this->base_path . '/views/layouts/main.php';
        include_once $this->base_path . '/views/transporte/historia.php';
    }
}
?>