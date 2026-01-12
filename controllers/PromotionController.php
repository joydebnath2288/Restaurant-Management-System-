<?php
require_once BASE_PATH . '/models/PromotionModel.php';

class PromotionController {
    private $promotionModel;

    public function __construct() {
        $this->promotionModel = new PromotionModel();
    }

    public function index() {
        require_once BASE_PATH . '/views/promotions.php';
    }

    public function verify() {
        header('Content-Type: application/json');
        
        $code = isset($_GET['code']) ? trim($_GET['code']) : '';

        if (empty($code)) {
            http_response_code(400);
            echo json_encode(['error' => 'Code required']);
            return;
        }

        $coupon = $this->promotionModel->getCouponByCode($code);

        if ($coupon) {
            echo json_encode($coupon);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Invalid or expired coupon']);
        }
    }
}
?>
