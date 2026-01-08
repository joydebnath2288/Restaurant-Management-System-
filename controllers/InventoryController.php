<?php
// controllers/InventoryController.php
require_once 'models/Inventory.php';

class InventoryController {
    private $db;
    private $inventory;

    public function __construct() {
        $this->inventory = new Inventory();
    }

    public function index() {
        // Admin View
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header("Location: ". BASE_URL);
            exit;
        }

        $stmt = $this->inventory->getAllInventory();
        $inventory_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Layout inclusions
        include 'views/layout/header.php';
        echo '<div class="container">';
        include 'views/layout/sidebar.php';
        echo '<div class="main-content">';

        include 'views/admin/inventory.php';

        echo '</div></div>';
        include 'views/layout/footer.php';
    }
}
?>
