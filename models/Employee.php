<?php
// models/Employee.php

class Employee extends Model {
    private $table_name = "employees";

    public $id;
    public $user_id;
    public $position;
    public $salary;
    public $hire_date;
    
    // Joined fields from users table
    public $name;
    public $email;
    public $phone;

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $query = "SELECT e.*, u.name, u.email, u.phone FROM " . $this->table_name . " e JOIN users u ON e.user_id = u.id ORDER BY u.name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Add Employee (Complex transaction: create User then Employee)
    public function create($userData) {
        $this->conn->beginTransaction();
        try {
             // 1. Create User
             $queryUser = "INSERT INTO users SET name=:name, email=:email, password=:password, role='staff', phone=:phone, address=:address";
             $stmtUser = $this->conn->prepare($queryUser);
             
             // ... binding parameters logic (simplified for brevity, assume passed correctly)
             $passHash = password_hash($userData['password'], PASSWORD_DEFAULT);
             $stmtUser->bindParam(':name', $userData['name']);
             $stmtUser->bindParam(':email', $userData['email']);
             $stmtUser->bindParam(':password', $passHash);
             $stmtUser->bindParam(':phone', $userData['phone']);
             $stmtUser->bindParam(':address', $userData['address']);
             
             if(!$stmtUser->execute()) throw new Exception("User creation failed");
             $newUserId = $this->conn->lastInsertId();

             // 2. Create Employee
             $queryEmp = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, position=:position, salary=:salary, hire_date=CURDATE()";
             $stmtEmp = $this->conn->prepare($queryEmp);
             $stmtEmp->bindParam(':user_id', $newUserId);
             $stmtEmp->bindParam(':position', $this->position);
             $stmtEmp->bindParam(':salary', $this->salary);
             
             if(!$stmtEmp->execute()) throw new Exception("Employee creation failed");

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

    // Specific method requested by user
    public function createEmployee($name, $email, $role, $password, $phone, $address, $salary) {
        // Reuse existing robust create logic or duplicate it.
        // Reusing ensures DRY.
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

    // Delete Employee (Transaction)
    public function delete($id) {
        $this->conn->beginTransaction();
        try {
             // 1. Get User ID first
             $queryGet = "SELECT user_id FROM " . $this->table_name . " WHERE id = :id";
             $stmtGet = $this->conn->prepare($queryGet);
             $stmtGet->bindParam(':id', $id);
             $stmtGet->execute();
             $row = $stmtGet->fetch(PDO::FETCH_ASSOC);
             
             if(!$row) {
                 throw new Exception("Employee not found");
             }
             $userId = $row['user_id'];

             // 2. Delete Employee Record
             $queryEmp = "DELETE FROM " . $this->table_name . " WHERE id = :id";
             $stmtEmp = $this->conn->prepare($queryEmp);
             $stmtEmp->bindParam(':id', $id);
             if(!$stmtEmp->execute()) throw new Exception("Failed to delete employee record");

             // 3. Delete User Record
             $queryUser = "DELETE FROM users WHERE id = :id";
             $stmtUser = $this->conn->prepare($queryUser);
             $stmtUser->bindParam(':id', $userId);
             if(!$stmtUser->execute()) throw new Exception("Failed to delete user record");

             $this->conn->commit();
             return true;

        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>
