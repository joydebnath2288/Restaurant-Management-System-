<?php
namespace Models;

class SupportMessage {

    private $con;

    public function __construct() {
        $this->con = mysqli_connect("127.0.0.1", "root", "", "restaurant_management");
        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function insert($name, $email, $message) {
        $sql = "INSERT INTO support_messages (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($this->con, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM support_messages";
        $result = mysqli_query($this->con, $sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
