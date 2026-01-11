<?php
require_once 'models/Reservation.php';

class ReservationController {
    private $db;
    private $reservation;

    public function __construct() {
        $this->reservation = new Reservation();
    }

    public function index() {
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            $stmt = $this->reservation->getAllReservations();
            $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            include 'views/layout/header.php';
            echo '<div class="container">';
            include 'views/layout/sidebar.php';
            echo '<div class="main-content">';
            
            include 'views/admin/reservations.php';

            echo '</div></div>';
            include 'views/layout/footer.php';
        } else {
          
            include 'views/customer/reservation.php';
        }
    }

    public function items() {
    
         $stmt = $this->reservation->getAll();
         $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
         include 'views/admin/reservations.php';
    }
    
    public function book() {
        if (!isset($_SESSION['user_id'])) {
             header("Location: " . BASE_URL . "index.php?controller=auth&action=login&redirect=reservation");
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_POST['date'];
            $time = $_POST['time'];
            $guests = $_POST['guests'];

            if($this->reservation->isAvailable($date, $time)) {
                $this->reservation->user_id = $_SESSION['user_id'];
                $this->reservation->reservation_date = $date;
                $this->reservation->reservation_time = $time;
                $this->reservation->guests = $guests;

                if($this->reservation->create()) {
                    header("Location: " . BASE_URL . "index.php?controller=reservation&action=index&success=booked");
                    exit;
                } else {
                    $error = "Error booking table.";
                    include 'views/customer/reservation.php';
                }
            } else {
                $error = "Sorry, no tables available for this time.";
                include 'views/customer/reservation.php';
            }
        }
    }
}
?>
