<?php
// controllers/WishlistController.php
require_once 'models/Wishlist.php';

class WishlistController {
    private $db;
    private $wishlist;

    public function __construct() {
        $this->wishlist = new Wishlist();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
            exit;
        }
        $stmt = $this->wishlist->getByUserId($_SESSION['user_id']);
        $wishlist_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/customer/wishlist.php';
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_id'])) {
            $this->wishlist->add($_SESSION['user_id'], $_POST['menu_id']);
        }
        header("Location: " . BASE_URL . "index.php?controller=wishlist&action=index");
    }
    public function remove() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
            exit;
        }
        if (isset($_GET['id'])) {
            $this->wishlist->remove($_SESSION['user_id'], $_GET['id']);
        }
        header("Location: " . BASE_URL . "index.php?controller=wishlist&action=index");
    }
}
?>
