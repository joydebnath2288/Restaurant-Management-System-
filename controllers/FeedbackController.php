<?php
// controllers/FeedbackController.php
require_once 'models/Feedback.php';

class FeedbackController {
    private $db;
    private $feedback;

    public function __construct() {
        $this->feedback = new Feedback();
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $this->feedback->user_id = $_SESSION['user_id'];
            $this->feedback->order_id = $_POST['order_id'];
            $this->feedback->rating = $_POST['rating'];
            $this->feedback->comment = $_POST['comment'];

            if($this->feedback->create()) {
                header("Location: " . BASE_URL . "index.php?page=dashboard&success=feedback_submitted");
            } else {
                echo "Error submitting feedback.";
            }
        }
    }

    public function index() {
        // Admin view
        if($_SESSION['user_role'] == 'admin') {
            $stmt = $this->feedback->getAll();
            $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            include 'views/admin/feedbacks.php'; // We'll create this or just define it now
        }
    }
}
?>
