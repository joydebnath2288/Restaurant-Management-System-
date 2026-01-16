<?php
require_once 'config/database.php';
require_once 'models/Reservation.php';

class ReservationController {
    
    public function showCreateForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /WT_RMS/login");
            exit;
        }
        require 'views/reservations/create.php';
    }

    public function create() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();

        $response = array("status" => "error", "message" => "Something went wrong.");

        if (!isset($_SESSION['user_id'])) {
            $response["message"] = "You must be logged in.";
            echo json_encode($response);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $date = $_POST['date'];
            $time = $_POST['time'];
            $guests = $_POST['guests'];

            if (empty($date) || empty($time) || empty($guests)) {
                 $response["message"] = "All fields are required.";
                 echo json_encode($response);
                 return;
            }
            
            if ($guests < 1) {
                 $response["message"] = "Guests must be at least 1.";
                 echo json_encode($response);
                 return;
            }

            $reservation = new Reservation($conn);
            $result = $reservation->create($_SESSION['user_id'], $date, $time, $guests);

            if ($result === true) {
                $response["status"] = "success";
                $response["message"] = "Reservation created successfully!";
            } elseif ($result === "double_booked") {
                $response["message"] = "Sorry, that time slot is already booked.";
            } else {
                $response["message"] = "Unable to create reservation.";
            }

            
            ob_clean();
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    public function index() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
            header("Location: /WT_RMS/login");
            exit;
        }

        $reservation = new Reservation($conn);
        $reservations = $reservation->getAllReservations();
        
        require 'views/reservations/index.php';
    }
}

