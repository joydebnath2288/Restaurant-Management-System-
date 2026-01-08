<?php
// models/Announcement.php

class Announcement extends Model {
    private $table_name = "announcements";

    public $id;
    public $title;
    public $message;

    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
