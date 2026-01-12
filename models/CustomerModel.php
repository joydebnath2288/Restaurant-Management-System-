<?php
class CustomerModel {

    public function getLast() {
        global $con;
        $query = "SELECT * FROM customers ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }

    public function save($data) {
        global $con;
        $name = mysqli_real_escape_string($con, $data['name']);
        $phone = mysqli_real_escape_string($con, $data['phone']);
        $address = mysqli_real_escape_string($con, $data['address']);

        $existing = $this->getLast();

        if ($existing) {
            $id = $existing['id'];
            $query = "UPDATE customers SET name = '$name', phone = '$phone', address = '$address' WHERE id = '$id'";
            return mysqli_query($con, $query);
        } else {
            $query = "INSERT INTO customers (name, phone, address) VALUES ('$name', '$phone', '$address')";
            return mysqli_query($con, $query);
        }
    }
}
?>
