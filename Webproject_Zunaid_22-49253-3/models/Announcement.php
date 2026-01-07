<?php
namespace Models;

class Announcement {

    private $con;

    public function __construct() {
        $this->con = mysqli_connect("127.0.0.1", "root", "", "restaurant_management");
        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function insert($title, $type, $message) {
        $sql = "INSERT INTO announcement (title, type, message) VALUES ('$title', '$type', '$message')";
        if (mysqli_query($this->con, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM announcement ORDER BY created_at DESC";
        $result = mysqli_query($this->con, $sql);
        $announcements = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $announcements[] = $row;
            }
        }
        return $announcements;
    }
}
