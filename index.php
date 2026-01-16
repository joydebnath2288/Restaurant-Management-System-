<?php
ob_start();


$path = isset($_GET['url']) ? $_GET['url'] : '/';



if ($path != '/' && strpos($path, '/') !== 0) {
    $path = '/' . $path;
}



$path = rtrim($path, '/');
if (empty($path)) {
    $path = '/';
}

require_once 'controllers/AuthController.php';

$authController = new AuthController();

switch ($path) {
    case '/':
    case '/index.php':

        include 'views/layouts/header.php';
        ?>
        <div class="welcome-section" style="text-align: center;">
            <h1>Welcome to Restaurant Management System</h1>
            <p>The best solution to manage your restaurant orders and billing.</p>
            
            
        </div>
        <?php
        include 'views/layouts/footer.php';
        break;
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $authController->login();
        } else {
             $authController->showLoginForm();
        }
        break;
    case '/dashboard':
        require_once 'controllers/DashboardController.php';
        $dashboardController = new DashboardController();
        $dashboardController->index();
        break;
    case '/reserve':
        require_once 'controllers/ReservationController.php';
        $resController = new ReservationController();
        $resController->showCreateForm();

        break;
    case '/reservations':
        require_once 'controllers/ReservationController.php';
        $resController = new ReservationController();
        $resController->index();
        break;
    case '/reserve_submit':
        require_once 'controllers/ReservationController.php';
        $resController = new ReservationController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $resController->create();
        }
        break;
    case '/logout':
        require 'views/auth/logout.php';
        break;
    case '/api/my-orders':
        require_once 'controllers/OrderController.php';
        $orderController = new OrderController();
        $orderController->getMyOrders();
        break;
    case '/orders':
        require_once 'controllers/OrderController.php';
        $orderController = new OrderController();
        $orderController->index();
        break;
    case '/api/my-orders-customer':
        require_once 'controllers/OrderController.php';
        $orderController = new OrderController();
        $orderController->apiGetCustomerOrders();
        break;
    case '/orders/update':
        require_once 'controllers/OrderController.php';
        $orderController = new OrderController();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $orderController->update();
        }
        break;
    case '/bills/generate':
        require_once 'controllers/BillController.php';
        $billController = new BillController();
        $billController->generate();
        break;
    case '/api/sales':
        require_once 'controllers/BillController.php';
        $billController = new BillController();
        $billController->apiGetSales();
        break;
    case '/admin/reports/export':
        require_once 'controllers/BillController.php';
        $billController = new BillController();
        $billController->exportReport();
        break;
    case '/forgot-password':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $authController->sendResetLink();
        } else {
             $authController->showForgotPasswordForm();
        }
        break;
    case '/reset-password':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $authController->resetPassword();
        } else {
             $authController->showResetPasswordForm();
        }
        break;
    case '/signup':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $authController->signup();
        } else {
             $authController->showSignupForm();
        }
        break;

    default:
        http_response_code(404);
        echo "404 Not Found (Path: $path)";
        break;
}
?>
