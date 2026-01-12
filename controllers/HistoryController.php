<?php
require_once BASE_PATH . '/models/HistoryModel.php';

class HistoryController {
    private $historyModel;

    public function __construct() {
        $this->historyModel = new HistoryModel();
    }

    public function index() {
        require_once BASE_PATH . '/views/history.php';
    }

    public function list() {
        header('Content-Type: application/json');
        
        $userId = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        
        if (empty($userId)) {
            echo json_encode([]);
            return;
        }

        $history = $this->historyModel->getByUserId($userId);
        echo json_encode($history);
    }
    public function add() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            

            if (empty($data['order_ref'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Order Ref required']);
                return;
            }

            if ($this->historyModel->add($data)) {
                echo json_encode(['message' => 'Reservation added']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to add reservation']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            
            if ($id) {
                if ($this->historyModel->delete($id)) {
                    echo json_encode(['message' => 'Reservation deleted']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to delete']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Missing ID']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
?>
