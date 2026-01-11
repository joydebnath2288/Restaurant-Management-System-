<?php

class Employee extends Model {
    private $table_name = "employees";

    public $id;
    public $user_id;
    public $position;
    public $salary;
    public $hire_date;
    public $name;
    public $email;
    public $phone;

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $query = "SELECT e.*, u.name, u.email, u.phone 
                  FROM " . $this->table_name . " e 
                  JOIN users u ON e.user_id = u.id 
                  ORDER BY u.name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create($userData) {
        $this->conn->beginTransaction();
        try {
            $queryUser = "INSERT INTO users (name,email,password,role,phone,address) 
                          VALUES (?,?,?,?,?,?)";

            $stmtUser = $this->conn->prepare($queryUser);
            $passHash = password_hash($userData['password'], PASSWORD_DEFAULT);

            if(!$stmtUser->execute([
                $userData['name'],
                $userData['email'],
                $passHash,
                'staff',
                $userData['phone'],
                $userData['address']
            ])) {
                throw new Exception("User creation failed");
            }

            $newUserId = $this->conn->lastInsertId();

            $queryEmp = "INSERT INTO " . $this->table_name . " (user_id, position, salary, hire_date)
                         VALUES (?,?,?,CURDATE())";

            $stmtEmp = $this->conn->prepare($queryEmp);

            if(!$stmtEmp->execute([
                $newUserId,
                $this->position,
                $this->salary
            ])) {
                throw new Exception("Employee creation failed");
            }

            $this->conn->commit();
            return true;

        } catch(Exception $e) {
            $this->conn->rollBack();
            if(strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $_SESSION['debug_error'] = "Error: Email already registered. Please use a unique email.";
            } else {
                $_SESSION['debug_error'] = "Error: " . $e->getMessage();
            }
            return false;
        }
    }

    public function createEmployee($name, $email, $role, $password, $phone, $address, $salary) {
        $this->position = $role;
        $this->salary = $salary;

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
            'address' => $address
        ];

        return $this->create($userData);
    }

    public function delete($id) {
        $this->conn->beginTransaction();
        try {
            $stmtGet = $this->conn->prepare("SELECT user_id FROM " . $this->table_name . " WHERE id = ?");
            $stmtGet->execute([$id]);
            $row = $stmtGet->fetch(PDO::FETCH_ASSOC);

            if(!$row) {
                throw new Exception("Employee not found");
            }

            $userId = $row['user_id'];

            $stmtEmp = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = ?");
            if(!$stmtEmp->execute([$id])) {
                throw new Exception("Failed to delete employee record");
            }

            $stmtUser = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            if(!$stmtUser->execute([$userId])) {
                throw new Exception("Failed to delete user record");
            }

            $this->conn->commit();
            return true;

        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>
