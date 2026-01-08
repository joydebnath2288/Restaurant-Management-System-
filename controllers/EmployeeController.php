<?php
// controllers/EmployeeController.php
require_once 'models/Employee.php';

class EmployeeController {
    private $db;
    private $employee;

    public function __construct() {
        $this->employee = new Employee();
    }

    public function index() {
        // Admin View
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header("Location: ". BASE_URL);
            exit;
        }

        $stmt = $this->employee->getAll();
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Layout inclusions
        include 'views/layout/header.php';
        echo '<div class="container">';
        include 'views/layout/sidebar.php';
        echo '<div class="main-content">';

        include 'views/admin/employees.php';

        echo '</div></div>';
        include 'views/layout/footer.php';
    }
    
    public function create() {
        include 'views/admin/add_employee.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             // Retrieve Inputs
             $name = $_POST['name'];
             $email = $_POST['email'];
             $password = "123456"; // Default password since field was removed
             
             $phone = $_POST['phone'];
             $address = $_POST['address'];
             $role = $_POST['position']; // Mapping UI 'position' to requested 'role' arg
             $salary = $_POST['salary'];

             // Use the specific createEmployee method as requested
             if ($this->employee->createEmployee($name, $email, $role, $password, $phone, $address, $salary)) {
                 header("Location: " . BASE_URL . "index.php?controller=employee&action=index&success=true");
                 exit;
             } else {
                 $errorMsg = isset($_SESSION['debug_error']) ? $_SESSION['debug_error'] : 'create_failed';
                 unset($_SESSION['debug_error']);
                 header("Location: " . BASE_URL . "index.php?controller=employee&action=index&error=" . urlencode($errorMsg));
                 exit;
             }
        }
    }

    public function delete() {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
             
             if($this->employee->delete($id)) {
                 header("Location: " . BASE_URL . "index.php?controller=employee&action=index&success=deleted");
             } else {
                 header("Location: " . BASE_URL . "index.php?controller=employee&action=index&error=delete_failed");
             }
        }
    }
}
?>
