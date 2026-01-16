<?php
class Bill {
    private $conn;
    private $table_name = "bills";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getByOrderId($order_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($order_id, $total, $tax) {
        $query = "INSERT INTO " . $this->table_name . " (order_id, total, tax) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("idd", $order_id, $total, $tax);
        
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function countRevenue() {
        $query = "SELECT SUM(total + tax) as revenue FROM " . $this->table_name;
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['revenue'] ? $row['revenue'] : 0.00;
    }

    public function getDailySales() {
        $query = "SELECT DATE(created_at) as date, SUM(total + tax) as total 
                  FROM " . $this->table_name . " 
                  WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                  GROUP BY DATE(created_at)
                  ORDER BY DATE(created_at) ASC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMonthlySales() {
        $query = "SELECT DATE_FORMAT(created_at, '%M') as month, SUM(total + tax) as total 
                  FROM " . $this->table_name . " 
                  WHERE YEAR(created_at) = YEAR(CURDATE())
                  GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                  ORDER BY created_at ASC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSalesRaw($startDate, $endDate) {
        $query = "SELECT b.id, b.order_id, (b.total + b.tax) as amount, b.created_at 
                  FROM " . $this->table_name . " b
                  WHERE DATE(b.created_at) BETWEEN ? AND ?
                  ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
