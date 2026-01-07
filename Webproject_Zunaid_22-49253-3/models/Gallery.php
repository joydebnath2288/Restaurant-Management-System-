<?php
namespace Models;

class Gallery {

    private $con;

    public function __construct() {
        $this->con = mysqli_connect("127.0.0.1", "root", "", "restaurant_management");
        if (!$this->con) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function insert($title, $description, $imageName) {
        $sql = "INSERT INTO gallery (title, description, image) VALUES ('$title', '$description', '$imageName')";
        if (mysqli_query($this->con, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM gallery";
        $result = mysqli_query($this->con, $sql);
        $images = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $images[] = $row;
            }
        }
        return $images;
    }
}
