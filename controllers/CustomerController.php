<?php
require_once BASE_PATH . '/models/CustomerModel.php';

class CustomerController {
    private $customerModel;

    public function __construct() {
        $this->customerModel = new CustomerModel();
    }

    public function index() {
        require_once BASE_PATH . '/views/customer.php';
    }

    public function get() {
        header('Content-Type: application/json');
        $customer = $this->customerModel->getLast();
        if ($customer) {
            echo json_encode($customer);
        } else {
            echo json_encode([]);
        }
    }

    public function save() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['name']) || empty($data['phone'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Name and Phone are required']);
                return;
            }

            if ($this->customerModel->save($data)) {
                echo json_encode(['message' => 'Profile updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to save profile']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
?>
