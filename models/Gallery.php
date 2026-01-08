<?php
// models/Gallery.php
class Gallery extends Model {
    private $table_name = "gallery";

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addImage($image, $description) {
        $query = "INSERT INTO " . $this->table_name . " (image, description) VALUES (:image, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":image", $image);
        $stmt->bindParam(":description", $description);
        return $stmt->execute();
    }
}
?>
