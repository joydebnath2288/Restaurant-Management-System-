<?php
require_once 'models/Report.php';

class ReportController {
    private $db;
    private $report;

    public function __construct() {
        $this->report = new Report();
    }

    public function index() {
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
            header("Location: ". BASE_URL);
            exit;
        }

        $sales = $this->report->getDailySales()->fetchAll(PDO::FETCH_ASSOC);
        $popular = $this->report->getMostPopularItems()->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/layout/header.php';
        echo '<div class="container">';
        include 'views/layout/sidebar.php';
        echo '<div class="main-content">';
        
        include 'views/admin/reports.php';
        
        echo '</div></div>';
        include 'views/layout/footer.php';
    }
}
?>
