<?php
// models/Reservation.php

class Reservation extends Model {
    private $table_name = "reservations";

    public $displayIds;
    public $user_id;
    public $table_number;
    public $reservation_date;
    public $reservation_time;
    public $guests;
    public $status;

    public function __construct() {
       parent::__construct();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, reservation_date=:reservation_date, reservation_time=:reservation_time, guests=:guests, status='pending'";
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->reservation_date = htmlspecialchars(strip_tags($this->reservation_date));
        $this->reservation_time = htmlspecialchars(strip_tags($this->reservation_time));
        $this->guests = htmlspecialchars(strip_tags($this->guests));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":reservation_date", $this->reservation_date);
        $stmt->bindParam(":reservation_time", $this->reservation_time);
        $stmt->bindParam(":guests", $this->guests);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Check double booking
    public function isAvailable($date, $time) {
        // Simplified check: just count total reservations for that slot
        // In real app, check against table capacity
        $query = "SELECT count(*) as count FROM " . $this->table_name . " WHERE reservation_date = :date AND reservation_time = :time AND status != 'cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":time", $time);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Assume simplified limit of 10 tables
        if($row['count'] >= 10) {
            return false;
        }
        return true;
    }

    // Required by User: getAllReservations
    public function getAllReservations() {
        return $this->getAll();
    }

    public function getAll() {
        $query = "SELECT r.*, u.name as customer_name FROM " . $this->table_name . " r JOIN users u ON r.user_id = u.id ORDER BY r.reservation_date DESC, r.reservation_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
