<?php
class Reservation {
    private $conn;
    private $table_name = "reservations";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($customer_id, $date, $time, $guests) {
        if ($this->isDoubleBooked($date, $time)) {
             return "double_booked";
        }

        $query = "INSERT INTO " . $this->table_name . " (customer_id, reservation_date, reservation_time, num_guests) VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isss", $customer_id, $date, $time, $guests);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function isDoubleBooked($date, $time) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE reservation_date = ? AND reservation_time = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $date, $time);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function getAllReservations() {
        $query = "SELECT r.*, u.full_name as customer_name 
                  FROM reservations r 
                  JOIN users u ON r.customer_id = u.id 
                  ORDER BY r.reservation_date DESC, r.reservation_time ASC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

