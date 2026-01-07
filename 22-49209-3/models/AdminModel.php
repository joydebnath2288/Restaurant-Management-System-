<?php
class AdminModel {

    public function resetAdminPassword($newPasswordHash) {
        global $con;
        $safe_hash = mysqli_real_escape_string($con, $newPasswordHash);
        $sql = "UPDATE employees SET password = '$safe_hash' WHERE login_id = 'admin'";
        return mysqli_query($con, $sql);
    }

    public function getTables() {
        global $con;
        $sql = "SHOW TABLES";
        $result = mysqli_query($con, $sql);
        $tables = [];
        while ($row = mysqli_fetch_row($result)) {
            $tables[] = $row[0];
        }
        return $tables;
    }

    public function setupDatabase() {
        global $con;
        
        // 1. Customers
        $sql = "CREATE TABLE IF NOT EXISTS customers (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            phone VARCHAR(15) NOT NULL,
            address TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($con, $sql);

        // 2. Employees
        $sql = "CREATE TABLE IF NOT EXISTS employees (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            role VARCHAR(30) NOT NULL,
            shift VARCHAR(30),
            status VARCHAR(20) DEFAULT 'Active',
            login_id VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($con, $sql);

         // 3. History
        $sql = "CREATE TABLE IF NOT EXISTS order_history (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            order_ref VARCHAR(20) NOT NULL, 
            user_id VARCHAR(20) NOT NULL,
            type VARCHAR(20) NOT NULL,
            order_date DATE NOT NULL,
            order_time TIME NOT NULL,
            guests INT(3),
            amount DECIMAL(10,2) NOT NULL,
            status VARCHAR(20) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        mysqli_query($con, $sql);

        // 4. Coupons
        $sql = "CREATE TABLE IF NOT EXISTS coupons (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            code VARCHAR(20) NOT NULL UNIQUE,
            type VARCHAR(10) NOT NULL,
            value DECIMAL(10,2) NOT NULL,
            min_subtotal DECIMAL(10,2) DEFAULT 0,
            description VARCHAR(255),
            is_active BOOLEAN DEFAULT TRUE
        )";
        mysqli_query($con, $sql);

        // 5. Settings
        $sql = "CREATE TABLE IF NOT EXISTS system_settings (
            id INT(1) UNSIGNED PRIMARY KEY DEFAULT 1,
            backup_enabled BOOLEAN DEFAULT TRUE,
            backup_time VARCHAR(10) DEFAULT '02:00',
            encrypt_data BOOLEAN DEFAULT TRUE,
            last_backup DATETIME
        )";
        mysqli_query($con, $sql);
        
        // Seed Settings
        $sql = "INSERT IGNORE INTO system_settings (id, backup_enabled, backup_time, encrypt_data, last_backup) 
                VALUES (1, 1, '02:00', 1, NULL)";
        mysqli_query($con, $sql);

        // Seed Coupons
        $sql = "INSERT IGNORE INTO coupons (code, type, value, min_subtotal, description, is_active) VALUES 
                ('SAVE10', 'percentage', 10.00, 0, '10% Off', 1),
                ('WELCOME50', 'fixed', 50.00, 150.00, '50 Off on orders over 150', 1)";
        mysqli_query($con, $sql);

        // Seed Admin
        $admin_password = password_hash("admin123", PASSWORD_DEFAULT);
        $sql = "INSERT IGNORE INTO employees (name, role, shift, login_id, password) VALUES 
                ('System Admin', 'Admin', 'All', 'admin', '$admin_password')";
        return mysqli_query($con, $sql);
    }

    public function hardResetEmployees() {
        global $con;
        
        // 1. Drop
        mysqli_query($con, "DROP TABLE IF EXISTS employees");

        // 2. Create
        $sql = "CREATE TABLE employees (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            role VARCHAR(30) NOT NULL,
            shift VARCHAR(30),
            status VARCHAR(20) DEFAULT 'Active',
            login_id VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        if (!mysqli_query($con, $sql)) return false;

        // 3. Seed Admin
        $pass = password_hash("admin123", PASSWORD_DEFAULT);
        $sql = "INSERT INTO employees (name, role, shift, status, login_id, password) 
                VALUES ('System Admin', 'Admin', 'All', 'Active', 'admin', '$pass')";
        return mysqli_query($con, $sql);
    }

    public function checkAdminStatus() {
        global $con;
        $res = mysqli_query($con, "SELECT * FROM employees WHERE login_id = 'admin'");
        if ($res) return mysqli_fetch_assoc($res);
        return null;
    }

    public function getTableStructure($table) {
        global $con;
        $safe_table = mysqli_real_escape_string($con, $table);
        $res = mysqli_query($con, "DESCRIBE $safe_table");
        $columns = [];
        if ($res) {
            while($row = mysqli_fetch_assoc($res)) {
                $columns[] = $row;
            }
        }
        return $columns;
    }
}
?>
