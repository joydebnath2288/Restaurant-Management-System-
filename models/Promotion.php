<?php
// models/Promotion.php

class Promotion extends Model {
    private $table_name = "promotions";

    public $id;
    public $code;
    public $discount_percent;
    public $valid_until;
    public $is_active;

    public function __construct() {
        parent::__construct();
    }

    public function getByCode($code) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE code = ? AND is_active = 1 AND valid_until >= CURDATE() LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Required for Admin Manage
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY valid_until DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($code, $discount, $valid_until) {
        $query = "INSERT INTO " . $this->table_name . " SET code=:code, discount_percent=:discount, valid_until=:valid_until, is_active=1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":code", $code);
        $stmt->bindParam(":discount", $discount);
        $stmt->bindParam(":valid_until", $valid_until);
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
