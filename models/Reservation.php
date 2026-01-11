<?php

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
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, reservation_date, reservation_time, guests, status) 
                  VALUES (?,?,?,?, 'pending')";
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->reservation_date = htmlspecialchars(strip_tags($this->reservation_date));
        $this->reservation_time = htmlspecialchars(strip_tags($this->reservation_time));
        $this->guests = htmlspecialchars(strip_tags($this->guests));

        return $stmt->execute([
            $this->user_id,
            $this->reservation_date,
            $this->reservation_time,
            $this->guests
        ]);
    }
    
    public function isAvailable($date, $time) {
        $query = "SELECT count(*) as count 
                  FROM " . $this->table_name . " 
                  WHERE reservation_date = ? AND reservation_time = ? AND status != 'cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$date, $time]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row['count'] >= 10) {
            return false;
        }
        return true;
    }

    public function getAllReservations() {
        return $this->getAll();
    }

    public function getAll() {
        $query = "SELECT r.*, u.name as customer_name 
                  FROM " . $this->table_name . " r 
                  JOIN users u ON r.user_id = u.id 
                  ORDER BY r.reservation_date DESC, r.reservation_time ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
