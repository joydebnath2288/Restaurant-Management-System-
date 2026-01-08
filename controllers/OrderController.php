<?php
// controllers/OrderController.php
require_once 'models/Order.php';

class OrderController {
    private $db;
    private $order;

    public function __construct() {
        $this->order = new Order();
        
        // Ensure cart exists
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addToCart() {
        if(!isset($_SESSION['user_id'])) {
             // If AJAX, return error 401
             if(isset($_POST['ajax'])) {
                 echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
                 exit;
             }
             header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_id'])) {
            $menu_id = $_POST['menu_id'];
            $quantity = $_POST['quantity'];
            
            require_once 'models/Menu.php';
            $menuModel = new Menu();
            $item = $menuModel->getById($menu_id);

            if($item) {
                // Add to session cart
                $_SESSION['cart'][] = [
                    'menu_id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $quantity
                ];
            }
        }

            header("Location: " . BASE_URL . "index.php?controller=menu&action=index&added=true");
    }

    public function place() {
        // 1. Auth Check - Redirect if not logged in
        if(!isset($_SESSION['user_id'])) {
             header("Location: " . BASE_URL . "index.php?controller=auth&action=login");
             exit;
        }

        // 2. Validate Request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['menu_id'])) {
            // Fallback for invalid access
            header("Location: " . BASE_URL . "index.php?controller=menu&action=index&error=invalid_request");
            exit;
        }

        $menu_id = $_POST['menu_id'];
        // Default to 1 if not set
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; 
        
        // 3. Get Menu Item Details
        require_once 'models/Menu.php';
        $menuModel = new Menu();
        $item = $menuModel->getById($menu_id);

        if(!$item) {
             // Item not found
             header("Location: " . BASE_URL . "index.php?controller=menu&action=index&error=item_not_found");
             exit;
        }

        // 4. Create Order
        // Use user_id from session, price from DB, quantity from form
        $total = $item['price'] * $quantity;
        
        // Use the simplified createOrder method
        if($this->order->createOrder($_SESSION['user_id'], $item['id'], $total)) {
            // 5. Success Redirect
            header("Location: " . BASE_URL . "index.php?controller=dashboard&action=index&success=order_placed");
            exit;
        } else {
            // 6. Database Error
            // Temporary debug output if safe, otherwise redirect with error
            header("Location: " . BASE_URL . "index.php?controller=menu&action=index&error=db_error");
            exit;
        }
    }

    public function viewCart() {
        include 'views/customer/cart.php';
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
         header("Location: " . BASE_URL . "index.php?controller=order&action=viewCart");
    }

    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "index.php?controller=auth&action=login&redirect=checkout");
            exit;
        }

        if(empty($_SESSION['cart'])) {
             header("Location: " . BASE_URL . "index.php?controller=menu&action=index");
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // placeOrder implementation
            $this->order->user_id = $_SESSION['user_id'];
            $this->order->payment_method = $_POST['payment_method'];
            
            // Calculate Total
            $total = 0;
            foreach($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            $this->order->total_amount = $total;

            if($this->order->create($_SESSION['cart'])) {
                $_SESSION['cart'] = []; 
                header("Location: " . BASE_URL . "index.php?controller=dashboard&action=index&success=order_placed");
            } else {
                echo "Error placing order."; // Should ideally redirect with error
            }
        } else {
             // If accessed via GET, just show cart or redirect
             $this->viewCart();
        }
    }

    // Admin List
    // Admin Manage Orders
    public function manage() {
         if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
             header("Location: ". BASE_URL);
             exit;
         }
         $stmt = $this->order->getAllOrders();
         $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
         // Layout inclusions
         include 'views/layout/header.php';
         echo '<div class="container">';
         include 'views/layout/sidebar.php';
         echo '<div class="main-content">';
         
         include 'views/admin/order_list.php';
         
         echo '</div></div>';
         include 'views/layout/footer.php';
    }

    public function delete() {
         if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
             header("Location: ". BASE_URL);
             exit;
         }
         if(isset($_GET['id'])) {
             $this->order->delete($_GET['id']);
             header("Location: " . BASE_URL . "index.php?controller=order&action=manage");
         }
    }

    // Helper to get orders (optional if used elsewhere)
    public function listOrders() {
         return $this->order->getAll();
    }
}
?>
