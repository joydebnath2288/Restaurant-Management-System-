<?php
// models/Faq.php
class Faq extends Model {
    private $table_name = "faqs";

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
