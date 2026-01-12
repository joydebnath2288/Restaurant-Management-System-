<?php
require_once BASE_PATH . '/models/EmployeeModel.php';

class EmployeeController {
    private $employeeModel;

    public function __construct() {
        $this->employeeModel = new EmployeeModel();
    }

    public function index() {
        require_once BASE_PATH . '/views/employees.php';
    }

    public function list() {
        header('Content-Type: application/json');
        $employees = $this->employeeModel->getAll();
        echo json_encode($employees);
    }

    public function add() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (empty($data['name']) || empty($data['login'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing fields']);
                return;
            }

            if ($this->employeeModel->add($data)) {
                echo json_encode(['message' => 'Employee added successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to add employee']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            
            if ($id) {
                if ($this->employeeModel->delete($id)) {
                    echo json_encode(['message' => 'Employee deleted']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to delete']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Missing ID']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
?>
