<?php
class EmployeeModel {

    public function getAll() {
        global $con;
        $query = "SELECT * FROM employees ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        
        $employees = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $employees[] = $row;
            }
        }
        return $employees;
    }

    public function add($data) {
        global $con;
        $name = mysqli_real_escape_string($con, $data['name']);
        $role = mysqli_real_escape_string($con, $data['role']);
        $shift = mysqli_real_escape_string($con, $data['shift']);
        $status = mysqli_real_escape_string($con, $data['status']);
        $login = mysqli_real_escape_string($con, $data['login']);
        $password = mysqli_real_escape_string($con, $data['password']);
        
        $query = "INSERT INTO employees (name, role, shift, status, login_id, password) 
                  VALUES ('$name', '$role', '$shift', '$status', '$login', '$password')";
        
        return mysqli_query($con, $query);
    }

    public function delete($id) {
        global $con;
        $safe_id = mysqli_real_escape_string($con, $id);
        $query = "DELETE FROM employees WHERE id = '$safe_id'";
        return mysqli_query($con, $query);
    }
}
?>
