<?php

// Usar rutas absolutas completas
// Obtener la ruta raíz del servidor
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$projectFolder = '/proyecto_transporte'; // Ajusta esto si tu carpeta tiene otro nombre
$projectRoot = $serverRoot . $projectFolder;

// Definir la ruta base si no está definida
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $projectRoot);
}

// Imprimir rutas para depuración
//echo "Server Root: " . $serverRoot . "<br>";
//echo "Project Root: " . $projectRoot . "<br>";

// Definir rutas a los archivos
$databaseFile = $projectRoot . '/config/database.php';
$matrizInversaFile = $projectRoot . '/utils/MatrizInversa.php';
$rutaModelFile = $projectRoot . '/models/RutaModel.php';

//echo "Intentando cargar database.php desde: " . $databaseFile . "<br>";

// Comprobar si los archivos existen
if (!file_exists($databaseFile)) {
    // Intentar encontrar el archivo en otras ubicaciones posibles
    $alternativeLocations = [
        $projectRoot . '/config/database.php',
        $projectRoot . '/database.php',
        dirname($projectRoot) . '/config/database.php',
        $serverRoot . '/config/database.php'
    ];
    
    foreach ($alternativeLocations as $location) {
        if (file_exists($location)) {
            $databaseFile = $location;
            echo "Archivo encontrado en ubicación alternativa: " . $databaseFile . "<br>";
            break;
        }
    }
    
    if (!file_exists($databaseFile)) {
        die("Error: No se encontró el archivo database.php en ninguna ubicación conocida");
    }
}

// Incluir los archivos necesarios
require_once $databaseFile;

// Solo incluir estos archivos si existen
if (file_exists($matrizInversaFile)) {
    require_once $matrizInversaFile;
} else {
    echo "Advertencia: No se pudo encontrar MatrizInversa.php<br>";
}

if (file_exists($rutaModelFile)) {
    require_once $rutaModelFile;
} else {
    echo "Advertencia: No se pudo encontrar RutaModel.php<br>";
}

class TransporteModel {
    private $conn;
    private $tabla_optimizaciones = "optimizaciones";
    private $tabla_resultados = "resultados_optimizacion";

    public $id;
    public $total_productos;
    public $fecha_calculo;

   

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todas las optimizaciones
    public function getAllOptimizaciones() {
        $query = "SELECT id, total_productos, fecha_calculo FROM " . $this->tabla_optimizaciones . " ORDER BY fecha_calculo DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Obtener resultados de una optimización
    public function getResultadosOptimizacion($optimizacion_id) {
        $query = "SELECT ro.id, ro.ruta_id, ro.cantidad_productos, ro.costo_total, 
                        r.origen_id, r.destino_id, r.distancia, r.costo_km,
                        o.nombre as origen_nombre, d.nombre as destino_nombre
                  FROM " . $this->tabla_resultados . " ro
                  JOIN rutas r ON ro.ruta_id = r.id
                  JOIN ciudades o ON r.origen_id = o.id
                  JOIN ciudades d ON r.destino_id = d.id
                  WHERE ro.optimizacion_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $optimizacion_id);
        $stmt->execute();
        
        return $stmt;
    }

    // Guardar una nueva optimización
    public function saveOptimizacion($total_productos, $resultados) {
        try {
            $this->conn->beginTransaction();
            
            // Crear registro de optimización
            $query = "INSERT INTO " . $this->tabla_optimizaciones . " (total_productos) VALUES (?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $total_productos);
            $stmt->execute();
            
            $optimizacion_id = $this->conn->lastInsertId();
            
            // Guardar resultados de la optimización
            foreach ($resultados as $resultado) {
                $query = "INSERT INTO " . $this->tabla_resultados . " 
                          (optimizacion_id, ruta_id, cantidad_productos, costo_total) 
                          VALUES (?, ?, ?, ?)";
                
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $optimizacion_id);
                $stmt->bindParam(2, $resultado['ruta_id']);
                $stmt->bindParam(3, $resultado['cantidad_productos']);
                $stmt->bindParam(4, $resultado['costo_total']);
                $stmt->execute();
            }
            
            $this->conn->commit();
            return $optimizacion_id;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    // Obtener rutas para el cálculo de optimización
    public function getRutasOptimizacion() {
        $rutaModel = new RutaModel();
        $stmt = $rutaModel->getAll();
        $rutas = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rutas[] = [
                'id' => $row['id'],
                'origen_id' => $row['origen_id'],
                'destino_id' => $row['destino_id'],
                'origen_nombre' => $row['origen_nombre'],
                'destino_nombre' => $row['destino_nombre'],
                'distancia' => $row['distancia'],
                'costo_km' => $row['costo_km']
            ];
        }
        
        return $rutas;
    }

    /**
     * MÉTODO OPTIMIZADO: Realizar el cálculo de optimización usando el enfoque de programación lineal
     * Este método implementa la estrategia de asignar todos los productos a la ruta con menor costo
     * cuando no hay restricciones adicionales de distribución.
     */
    public function optimizarDistribucion($total_productos) {
        // Obtener todas las rutas disponibles
        $rutas = $this->getRutasOptimizacion();
        
        if (count($rutas) < 1) {
            throw new Exception("Se requieren al menos una ruta para realizar la optimización.");
        }
        
        // Calcular el costo total por producto para cada ruta
        foreach ($rutas as &$ruta) {
            $ruta['costo_total_por_producto'] = $ruta['distancia'] * $ruta['costo_km'];
        }
        
        // Ordenar las rutas por costo total (de menor a mayor)
        usort($rutas, function($a, $b) {
            return $a['costo_total_por_producto'] - $b['costo_total_por_producto'];
        });
        
        // Inicializar el array de resultados con todas las rutas disponibles
        $resultados = [];
        foreach ($rutas as $ruta) {
            $resultados[] = [
                'ruta_id' => $ruta['id'],
                'origen' => $ruta['origen_nombre'],
                'destino' => $ruta['destino_nombre'],
                'distancia' => $ruta['distancia'],
                'costo_km' => $ruta['costo_km'],
                'cantidad_productos' => 0, // Inicializar con 0 productos
                'costo_total' => 0, // Inicializar con costo 0
                'costo_unitario' => $ruta['costo_total_por_producto']
            ];
        }
        
        // Aplicar la estrategia de programación lineal:
        // Asignar todos los productos a la ruta con menor costo
        $resultados[0]['cantidad_productos'] = $total_productos;
        $resultados[0]['costo_total'] = $total_productos * $resultados[0]['costo_unitario'];
        
        // Registrar en el log del sistema para depuración
        error_log("Optimización realizada: Total productos: " . $total_productos);
        error_log("Ruta óptima: " . $resultados[0]['origen'] . " → " . $resultados[0]['destino'] . 
                  " (Costo unitario: " . $resultados[0]['costo_unitario'] . ")");
        
        return $resultados;
    }
}
?>