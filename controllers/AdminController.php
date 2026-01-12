<?php
require_once BASE_PATH . '/models/AdminModel.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    public function index() {
        echo "<h1>Admin Tools</h1>";
        echo "<ul>
                <li><a href='index.php?controller=admin&action=setup'>Run Setup</a></li>
                <li><a href='index.php?controller=admin&action=debug'>Debug Tables</a></li>
                <li><a href='index.php?controller=admin&action=reset_default'>Reset Admin Password</a></li>
                <li><a href='index.php?controller=admin&action=fix_coupons'>Fix Missing Coupons (Seed)</a></li>
                <li><a href='index.php?controller=admin&action=list_coupons'>List All Coupons</a></li>
                <li><a href='index.php?controller=admin&action=check_db'>Deep Check Database</a></li>
                <li><a href='index.php?controller=admin&action=hard_reset' style='color:red'>HARD RESET (Drop Table)</a></li>
              </ul>";
    }

    public function setup() {
        if ($this->adminModel->setupDatabase()) {
            echo "Database setup completed successfully.";
        } else {
            echo "Database setup failed. (Check DB connection)";
        }
        echo "<br><a href='index.php?controller=admin'>Back</a>";
    }

    public function reset_default() {
        $newHash = password_hash("admin123", PASSWORD_DEFAULT);
        if ($this->adminModel->resetAdminPassword($newHash)) {
            echo "Admin password reset to 'admin123'.";
        } else {
            echo "Failed to reset password.";
        }
        echo "<br><a href='index.php?controller=admin'>Back</a>";
    }

    public function debug() {
        $tables = $this->adminModel->getTables();
        echo "<h2>Database Tables</h2>";
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }
        echo "</ul>";
        echo "<br><a href='index.php?controller=admin'>Back</a>";
    }

    public function fix_coupons() {
        $this->adminModel->setupDatabase();
        echo "<h1>Coupons Fixed!</h1>";
        echo "<p>WELCOME50 and SAVE10 have been added.</p>";
        $this->list_coupons(true);
    }

    public function list_coupons($internal = false) {
        global $con;
        $res = mysqli_query($con, "SELECT * FROM coupons");
        
        if (!$internal) echo "<h2>Current Coupons in DB</h2>";
        
        echo "<table border='1'><tr><th>ID</th><th>Code</th><th>Value</th><th>Active</th></tr>";
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['code']}</td>";
            echo "<td>{$row['value']}</td>";
            echo "<td>{$row['is_active']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        if (!$internal) echo "<br><a href='index.php?controller=admin'>Back</a>";
    }
    public function hard_reset() {
        if ($this->adminModel->hardResetEmployees()) {
            echo "<h1>Hard Reset Complete</h1>";
            echo "<p>Employees table dropped and recreated.</p>";
            echo "<p>Admin user reset to: admin / admin123</p>";
        } else {
            echo "<h1>Reset Failed!</h1>";
        }
        echo "<br><a href='index.php?controller=admin'>Back to Admin</a>";
    }

    public function check_db() {
        echo "<h1>Database Integrity Check</h1>";
        
        $admin = $this->adminModel->checkAdminStatus();
        echo "<h3>Admin User Status</h3>";
        if ($admin) {
            echo "<pre>"; print_r($admin); echo "</pre>";
            if (password_verify('admin123', $admin['password'])) {
                echo "<p style='color:green'>Password Hash Matches 'admin123'</p>";
            } else {
                echo "<p style='color:red'>Password Hash DOES NOT MATCH 'admin123'</p>";
            }
        } else {
            echo "<p style='color:red'>Admin User NOT FOUND</p>";
        }

        echo "<h3>Table Structure: employees</h3>";
        $cols = $this->adminModel->getTableStructure('employees');
        echo "<pre>"; print_r($cols); echo "</pre>";
        
        echo "<br><a href='index.php?controller=admin'>Back to Admin</a>";
    }
}
?>
