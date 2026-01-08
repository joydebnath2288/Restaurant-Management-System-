<?php
// models/Menu.php
class Menu extends Model {
    private $table_name = "menu";

    public function __construct() {
        parent::__construct();
    }

    // Fetch all menu items
    public function getAll() {
        return $this->getAllMenus();
    }

    // Required by User: getAllMenus
    public function getAllMenus() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_available = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAdminAll() {
        $query = "SELECT * FROM " . $this->table_name; // No filter
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getFeatured($limit = 3) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_available = 1 ORDER BY RAND() LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, description=:description, price=:price, category=:category, image=:image";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":category", $data['category']);
        $stmt->bindParam(":image", $data['image']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description, price=:price, category=:category";
        if (!empty($data['image'])) {
            $query .= ", image=:image";
        }
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":category", $data['category']);
        $stmt->bindParam(":id", $id);
        if (!empty($data['image'])) {
             $stmt->bindParam(":image", $data['image']);
        }
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
