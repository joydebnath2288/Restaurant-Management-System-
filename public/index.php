<?php
session_start();


define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/config/database.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$ctl = null;

switch ($controller) {
    case 'auth':
        require_once BASE_PATH . '/controllers/AuthController.php';
        $ctl = new AuthController();
        break;
    case 'dashboard':
        require_once BASE_PATH . '/controllers/DashboardController.php';
        $ctl = new DashboardController();
        break;
    case 'admin':
        require_once BASE_PATH . '/controllers/AdminController.php';
        $ctl = new AdminController();
        break;
    case 'employee':
        require_once BASE_PATH . '/controllers/EmployeeController.php';
        $ctl = new EmployeeController();
        break;
    case 'customer':
        require_once BASE_PATH . '/controllers/CustomerController.php';
        $ctl = new CustomerController();
        break;
    case 'history':
        require_once BASE_PATH . '/controllers/HistoryController.php';
        $ctl = new HistoryController();
        break;
    case 'promotion':
        require_once BASE_PATH . '/controllers/PromotionController.php';
        $ctl = new PromotionController();
        break;
    case 'settings':
        require_once BASE_PATH . '/controllers/SettingsController.php';
        $ctl = new SettingsController();
        break;
    default:
        http_response_code(404);
        echo "Page not found";
        exit;
}

if ($ctl) {
    if (method_exists($ctl, $action)) {
        $ctl->$action();
    } else {
        http_response_code(404);
        echo "Action '$action' not found";
    }
}
?>
