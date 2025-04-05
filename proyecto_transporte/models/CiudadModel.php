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

class CiudadModel {
    private $conn;
    private $table_name = "ciudades";

    public $id;
    public $nombre;
    public $created_at;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Obtener todas las ciudades
    public function getAll() {
        $query = "SELECT id, nombre, created_at FROM " . $this->table_name . " ORDER BY nombre";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Obtener una ciudad por su ID
    public function getById($id) {
        $query = "SELECT id, nombre, created_at FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->created_at = $row['created_at'];
            return true;
        }
        
        return false;
    }

    // Verificar si existe una ciudad con el mismo nombre
    public function existeCiudad($nombre) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE nombre = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nombre);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'] > 0;
    }

    // Verificar si existe otra ciudad con el mismo nombre, excluyendo la ciudad actual
    public function existeCiudadExcluyendo($nombre, $id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE nombre = ? AND id != ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'] > 0;
    }

    // Verificar si una ciudad está siendo utilizada en rutas
    public function ciudadEnUso($id) {
        $query = "SELECT COUNT(*) as count FROM rutas WHERE origen_id = ? OR destino_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['count'] > 0;
    }

    // Crear una nueva ciudad
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nombre) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        
        // Bind parametros
        $stmt->bindParam(1, $this->nombre);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Actualizar una ciudad
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nombre = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar entrada
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parametros
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Eliminar una ciudad
    public function delete() {
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