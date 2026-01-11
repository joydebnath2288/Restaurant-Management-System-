<?php

class Wishlist extends Model {
    private $table_name = "wishlist";

    public function __construct() {
        parent::__construct();
    }

    public function add($user_id, $menu_id) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, menu_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id, $menu_id]);
    }

    public function getByUserId($user_id) {
        $query = "SELECT m.*, w.id as wishlist_id 
                  FROM " . $this->table_name . " w 
                  JOIN menu m ON w.menu_id = m.id 
                  WHERE w.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt;
    }

    public function remove($user_id, $wishlist_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = ? AND id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id, $wishlist_id]);
    }
}
?>
