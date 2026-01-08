<?php
// controllers/PromotionController.php
require_once 'models/Promotion.php';

class PromotionController {
    private $db;
    private $promotion;

    public function __construct() {
        $this->promotion = new Promotion();
    }

    public function index() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header("Location: ". BASE_URL);
            exit;
        }
        $stmt = $this->promotion->getAll();
        $promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Layout inclusions
        include 'views/layout/header.php';
        echo '<div class="container">';
        include 'views/layout/sidebar.php';
        echo '<div class="main-content">';
        
        include 'views/admin/promotions.php';

        echo '</div></div>';
        include 'views/layout/footer.php';
    }

    public function store() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') exit;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $this->promotion->create($_POST['code'], $_POST['discount'], $_POST['valid_until']);
             header("Location: " . BASE_URL . "index.php?controller=promotion&action=index");
        }
    }

    public function delete() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') exit;

        if (isset($_GET['id'])) {
            $this->promotion->delete($_GET['id']);
            header("Location: " . BASE_URL . "index.php?controller=promotion&action=index");
        }
    }

    public function apply() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = $_POST['promo_code'];
            $promo = $this->promotion->getByCode($code);

            if($promo) {
                // Determine logic for discount
                // Store in session to apply at checkout?
                $_SESSION['discount'] = $promo['discount_percent'];
                $_SESSION['promo_code'] = $promo['code'];
                header("Location: " . BASE_URL . "index.php?controller=order&action=viewCart&success=promo_applied");
            } else {
                 header("Location: " . BASE_URL . "index.php?controller=order&action=viewCart&error=invalid_promo");
            }
        }
    }
}
?>
