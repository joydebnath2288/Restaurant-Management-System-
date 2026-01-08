<?php
// models/Feedback.php

class Feedback extends Model {
    private $table_name = "feedback";

    public $id;
    public $user_id;
    public $order_id;
    public $rating;
    public $comment;

    public function __construct() {
        parent::__construct();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, order_id=:order_id, rating=:rating, comment=:comment";
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->order_id = htmlspecialchars(strip_tags($this->order_id));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->comment = htmlspecialchars(strip_tags($this->comment));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":comment", $this->comment);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT f.*, u.name as customer_name FROM " . $this->table_name . " f JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
