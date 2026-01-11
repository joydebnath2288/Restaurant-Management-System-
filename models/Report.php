<?php

class Report extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getDailySales() {
        $query = "SELECT DATE(created_at) as date, SUM(total_amount) as total FROM orders WHERE status = 'completed' OR status = 'paid' GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function getMostPopularItems() {
        $query = "SELECT m.name, SUM(oi.quantity) as count FROM order_items oi JOIN menu m ON oi.menu_id = m.id GROUP BY m.id ORDER BY count DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
