<?php
class PasswordReset {
    private $conn;
    private $table_name = "password_resets";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createToken($email) {
        $token = bin2hex(random_bytes(32));
        
        $this->deleteToken($email);

        $query = "INSERT INTO " . $this->table_name . " (email, token) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $email, $token);

        if ($stmt->execute()) {
            return $token;
        }
        return false;
    }

    public function verifyToken($email, $token) {
        $query = "SELECT created_at FROM " . $this->table_name . " WHERE email = ? AND token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $created_at = strtotime($row['created_at']);
            if (time() - $created_at < 3600) {
                return true;
            }
        }
        return false;
    }

    public function deleteToken($email) {
        $query = "DELETE FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }
}
?>
