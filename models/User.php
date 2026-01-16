<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($full_name, $email, $password, $role = 'customer') {
        if($this->emailExists($email)){
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (full_name, email, password, role) VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $full_name, $email, $password, $role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function countUsers() {
        $query = "SELECT count(*) as total FROM " . $this->table_name;
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return true;
        }

        return false;
    }

    public function login($email, $password) {
        $query = "SELECT id, full_name, password, role FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            
            if ($password == $row['password']) {
                return $row;
            }
        }
        return false;
    }

    public function updatePassword($email, $new_password) {
        $query = "UPDATE " . $this->table_name . " SET password = ? WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $new_password, $email);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
