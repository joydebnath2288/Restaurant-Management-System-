<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAssignedOrders($staff_id) {
        $query = "SELECT o.id, o.items, o.status, o.created_at, u.full_name as customer_name 
                  FROM " . $this->table_name . " o
                  JOIN users u ON o.customer_id = u.id
                  WHERE o.assigned_staff_id = ? AND o.status != 'delivered'
                  ORDER BY o.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getStaffStats($staff_id) {
        $query = "SELECT 
                    SUM(CASE WHEN status != 'delivered' THEN 1 ELSE 0 END) as active_orders,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_tasks
                  FROM " . $this->table_name . " 
                  WHERE assigned_staff_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getAllOrders() {
        $query = "SELECT o.id, o.items, o.status, o.created_at, u.full_name as customer_name, s.full_name as staff_name 
                  FROM " . $this->table_name . " o
                  JOIN users u ON o.customer_id = u.id
                  LEFT JOIN users s ON o.assigned_staff_id = s.id
                  ORDER BY o.created_at DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $status, $id);
        
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function countActiveOrders() {
        $query = "SELECT count(*) as total FROM " . $this->table_name . " WHERE status IN ('pending', 'preparing', 'served')";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function countOrders() {
        $query = "SELECT count(*) as total FROM " . $this->table_name;
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function getByCustomer($customer_id) {
        $query = "SELECT id, items, status, created_at FROM " . $this->table_name . " WHERE customer_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT o.*, u.full_name as customer_name 
                  FROM " . $this->table_name . " o
                  JOIN users u ON o.customer_id = u.id
                  WHERE o.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
