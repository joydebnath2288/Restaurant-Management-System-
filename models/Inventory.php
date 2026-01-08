<?php
// models/Inventory.php

class Inventory extends Model {
    private $table_name = "inventory";

    public $id;
    public $item_name;
    public $quantity;
    public $unit;
    public $low_stock_threshold;
    public $last_updated;

    public function __construct() {
        parent::__construct();
    }

    // Required by User: getAllInventory
    public function getAllInventory() {
        return $this->getAll();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY item_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Add updateStock method...
}
?>
