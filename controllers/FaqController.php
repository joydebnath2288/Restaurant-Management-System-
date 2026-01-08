<?php
// controllers/FaqController.php
require_once 'models/Faq.php';

class FaqController {
    private $db;
    private $faq;

    public function __construct() {
        $this->faq = new Faq();
    }

    public function index() {
        $stmt = $this->faq->getAll();
        $faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/pages/faq.php';
    }
}
?>
