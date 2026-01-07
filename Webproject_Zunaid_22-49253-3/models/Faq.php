<?php
namespace Models;

class Faq {

    private $con;

    public function __construct() {
        $this->con = mysqli_connect("127.0.0.1", "root", "", "restaurant_management");
        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function insert($question, $answer) {
        $sql = "INSERT INTO faq (question, answer) VALUES ('$question', '$answer')";
        if (mysqli_query($this->con, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM faq";
        $result = mysqli_query($this->con, $sql);
        $faqs = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $faqs[] = $row;
            }
        }
        return $faqs;
    }
}
