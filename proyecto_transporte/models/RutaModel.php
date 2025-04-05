<?php
// Usar rutas absolutas completas
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$projectFolder = '/proyecto_transporte'; 
$projectRoot = $serverRoot . $projectFolder;

// Definir la ruta base si no está definida
if (!defined('BASE_PATH')) {
    define('BASE_PATH', $projectRoot);
}

require_once $projectRoot . '/config/database.php';

class RutaModel {
    private $conn;
    private $table_name = "rutas";

    public $id;
    public $origen_id;
    public $destino_id;
    public $distancia;
    public $costo_km;
    public $created_at;

    // Propiedades para JOIN
    public $origen_nombre;
    public $destino_nombre;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todas las rutas con nombres de ciudades
    public function getAll() {
        $query = "SELECT r.id, r.origen_id, r.destino_id, r.distancia, r.costo_km, r.created_at, 
                        o.nombre as origen_nombre, d.nombre as destino_nombre
                  FROM " . $this->table_name . " r
                  LEFT JOIN ciudades o ON r.origen_id = o.id
                  LEFT JOIN ciudades d ON r.destino_id = d.id
                  ORDER BY r.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Obtener una ruta por su ID
    public function getById($id) {
        $query = "SELECT r.id, r.origen_id, r.destino_id, r.distancia, r.costo_km, r.created_at, 
                        o.nombre as origen_nombre, d.nombre as destino_nombre
                  FROM " . $this->table_name . " r
                  LEFT JOIN ciudades o ON r.origen_id = o.id
                  LEFT JOIN ciudades d ON r.destino_id = d.id
                  WHERE r.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id = $row['id'];
            $this->origen_id = $row['origen_id'];
            $this->destino_id = $row['destino_id'];
            $this->distancia = $row['distancia'];
            $this->costo_km = $row['costo_km'];
            $this->created_at = $row['created_at'];
            $this->origen_nombre = $row['origen_nombre'];
            $this->destino_nombre = $row['destino_nombre'];
            return true;
        }
        
        return false;
    }

    // Obtener ruta por origen y destino
    public function getByOrigenDestino($origen_id, $destino_id) {
        $query = "SELECT id, origen_id, destino_id, distancia, costo_km, created_at 
                  FROM " . $this->table_name . " 
                  WHERE origen_id = ? AND destino_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $origen_id);
        $stmt->bindParam(2, $destino_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id = $row['id'];
            $this->origen_id = $row['origen_id'];
            $this->destino_id = $row['destino_id'];
            $this->distancia = $row['distancia'];
            $this->costo_km = $row['costo_km'];
            $this->created_at = $row['created_at'];
            return true;
        }
        
        return false;
    }

    // Verificar si existe una ruta con el mismo origen y destino
    public function existeRuta($origen_id, $destino_id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                  WHERE origen_id = ? AND destino_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $origen_id);
        $stmt->bindParam(2, $destino_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'] > 0;
    }

    // Verificar si existe otra ruta con el mismo origen y destino, excluyendo la ruta actual
    public function existeRutaExcluyendo($origen_id, $destino_id, $id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " 
                  WHERE origen_id = ? AND destino_id = ? AND id != ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $origen_id);
        $stmt->bindParam(2, $destino_id);
        $stmt->bindParam(3, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'] > 0;
    }

    // Crear una nueva ruta
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (origen_id, destino_id, distancia, costo_km) 
                  VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar entrada
        $this->origen_id = htmlspecialchars(strip_tags($this->origen_id));
        $this->destino_id = htmlspecialchars(strip_tags($this->destino_id));
        $this->distancia = htmlspecialchars(strip_tags($this->distancia));
        $this->costo_km = htmlspecialchars(strip_tags($this->costo_km));
        
        // Bind parametros
        $stmt->bindParam(1, $this->origen_id);
        $stmt->bindParam(2, $this->destino_id);
        $stmt->bindParam(3, $this->distancia);
        $stmt->bindParam(4, $this->costo_km);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Actualizar una ruta
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET origen_id = ?, destino_id = ?, distancia = ?, costo_km = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar entrada
        $this->origen_id = htmlspecialchars(strip_tags($this->origen_id));
        $this->destino_id = htmlspecialchars(strip_tags($this->destino_id));
        $this->distancia = htmlspecialchars(strip_tags($this->distancia));
        $this->costo_km = htmlspecialchars(strip_tags($this->costo_km));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parametros
        $stmt->bindParam(1, $this->origen_id);
        $stmt->bindParam(2, $this->destino_id);
        $stmt->bindParam(3, $this->distancia);
        $stmt->bindParam(4, $this->costo_km);
        $stmt->bindParam(5, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Eliminar una ruta
    public function delete() {
        // Primero verificar si la ruta está siendo utilizada en optimizaciones
        $query = "SELECT COUNT(*) as count FROM resultados_optimizacion WHERE ruta_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row['count'] > 0) {
            // La ruta está siendo utilizada, no se puede eliminar
            return false;
        }
        
        // Si no está siendo utilizada, proceder con la eliminación
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar entrada
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parametro
        $stmt->bindParam(1, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>