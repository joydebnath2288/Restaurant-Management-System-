<?php
require_once 'config/database.php';
require_once 'models/Bill.php';
require_once 'models/Order.php';

class BillController {
    
    public function generate() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_GET['order_id'])) {
            die("Order ID required.");
        }

        $order_id = $_GET['order_id'];
        
        $orderModel = new Order($conn);
        
        $order = $orderModel->getById($order_id);

        if (!$order) {
            die("Order not found.");
        }

        $billModel = new Bill($conn);
        $bill = $billModel->getByOrderId($order_id);

        if (!$bill) {
            $items_list = explode(',', $order['items']);
            $total = 0;
            
            $prices = [
                'burger' => 300,
                'pizza' => 500,
                'fried rice' => 250,
                'chicken fry' => 150,
                'steak' => 800,
                'coke' => 50,
                'sprite' => 50,
                'water' => 20
            ];

            foreach ($items_list as $item) {
                $item_name = strtolower(trim($item));
                if (isset($prices[$item_name])) {
                    $total += $prices[$item_name];
                } else {
                    $total += 100;
                }
            }

            $tax = $total * 0.10;
            $billModel->create($order_id, $total, $tax);
            $bill = $billModel->getByOrderId($order_id);
        }

        require 'views/bills/invoice.php';
    }

    public function apiGetSales() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
             echo json_encode(["status" => "error", "message" => "Unauthorized"]);
             return;
        }

        $billModel = new Bill($conn);
        $daily = $billModel->getDailySales();

        ob_clean();
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "daily" => $daily
        ]);
        exit;
    }

    public function exportReport() {
        global $conn;
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
             die("Unauthorized");
        }

        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

        $billModel = new Bill($conn);
        $data = $billModel->getSalesRaw($startDate, $endDate);

        $filename = "sales_report_" . date('Ymd') . ".csv";

        ob_clean();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Bill ID', 'Order ID', 'Total Amount', 'Date']);

        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}
