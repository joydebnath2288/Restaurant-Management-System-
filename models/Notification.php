<?php
// models/Notification.php

class Notification extends Model {
    private $table_name = "notifications";

    public $id;
    public $user_id;
    public $message;
    public $is_read;

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, message=:message, is_read=0";
        $stmt = $this->conn->prepare($query);
        
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->message = htmlspecialchars(strip_tags($this->message));
        
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":message", $this->message);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
