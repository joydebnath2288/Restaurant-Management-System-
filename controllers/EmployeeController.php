<?php
require_once 'models/Employee.php';

class EmployeeController {
    private $employee;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->employee = new Employee();
    }

    public function index() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        $stmt = $this->employee->getAll();
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $employees]);
        exit;
    }
    
    public function store() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                $input = $_POST;
            }

            $name = $input['name'] ?? '';
            $email = $input['email'] ?? '';
            $password = "123456"; 
            $phone = $input['phone'] ?? '';
            $address = $input['address'] ?? '';
            $role = $input['position'] ?? '';
            $salary = $input['salary'] ?? 0;

            if ($this->employee->createEmployee($name, $email, $role, $password, $phone, $address, $salary)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Employee created successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to create employee']);
            }
            exit;
        }
    }

    public function delete() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        $id = $_GET['id'] ?? null;
        if($id) {
            if($this->employee->delete($id)) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Employee deleted successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete employee']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        }
        exit;
    }
}
?>
