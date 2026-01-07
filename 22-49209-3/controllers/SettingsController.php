<?php
require_once BASE_PATH . '/models/SettingsModel.php';

class SettingsController {
    private $settingsModel;

    public function __construct() {
        $this->settingsModel = new SettingsModel();
    }

    public function get() {
        header('Content-Type: application/json');
        $settings = $this->settingsModel->get();
        if ($settings) {
            echo json_encode($settings);
        } else {
            echo json_encode([]);
        }
    }

    public function update() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if ($this->settingsModel->update($data)) {
                echo json_encode(['message' => 'Settings updated']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update settings']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
    }
}
?>
