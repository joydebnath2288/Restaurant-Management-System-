<?php
namespace Models;

class BaseModel {

    protected $con;

    public function __construct() {
        $this->con = mysqli_connect("127.0.0.1", "root", "", "restaurant_management");

        if (!$this->con) {
            echo "Database connection error";
            exit;
        }
    }
}
?>
