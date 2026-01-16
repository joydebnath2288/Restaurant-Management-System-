<?php
require_once 'config/database.php';
require_once 'models/Order.php';

class OrderController {
    
    public function getMyOrders() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'staff') {
             echo json_encode(["status" => "error", "message" => "Unauthorized"]);
             return;
        }

        $order = new Order($conn);
        $orders = $order->getAssignedOrders($_SESSION['user_id']);
        $stats = $order->getStaffStats($_SESSION['user_id']);

        ob_clean();
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success", 
            "data" => $orders,
            "stats" => $stats
        ]);
        exit;
    }

    public function apiGetCustomerOrders() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer') {
             echo json_encode(["status" => "error", "message" => "Unauthorized"]);
             return;
        }

        $order = new Order($conn);
        $orders = $order->getByCustomer($_SESSION['user_id']);

        ob_clean();
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success", 
            "data" => $orders
        ]);
        exit;
    }
    
    
    public function index() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
             header("Location: /WT_RMS/login");
             exit;
        }

        $order = new Order($conn);
        $orders = $order->getAllOrders();
        
        require 'views/orders/index.php';
    }

    public function update() {
        global $conn;
        
        $response = ["status" => "error", "message" => "Failed"];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['status'];

            $order = new Order($conn);
            if ($order->updateStatus($id, $status)) {
                $response["status"] = "success";
                $response["message"] = "Order updated.";
            }
        }
        ob_clean();
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
