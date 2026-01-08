<?php
// models/Wishlist.php
class Wishlist extends Model {
    private $table_name = "wishlist";

    public function __construct() {
        parent::__construct();
    }

    public function add($user_id, $menu_id) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, menu_id) VALUES (:user_id, :menu_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":menu_id", $menu_id);
        return $stmt->execute();
    }

    public function getByUserId($user_id) {
        $query = "SELECT m.*, w.id as wishlist_id FROM " . $this->table_name . " w 
                  JOIN menu m ON w.menu_id = m.id 
                  WHERE w.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt;
    }
    public function remove($user_id, $wishlist_id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND id = :wishlist_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":wishlist_id", $wishlist_id);
        return $stmt->execute();
    }
}
?>
