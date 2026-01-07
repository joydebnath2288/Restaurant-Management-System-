<?php
class HistoryModel {

    public function getByUserId($userId) {
        global $con;
        $safe_id = mysqli_real_escape_string($con, $userId);
        
        $query = "SELECT * FROM order_history WHERE user_id = '$safe_id' ORDER BY order_date DESC, order_time DESC";
        $result = mysqli_query($con, $query);
        
        $history = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $history[] = $row;
            }
        }
        return $history;
    }

    public function add($data) {
        global $con;
        
        $order_ref = mysqli_real_escape_string($con, $data['order_ref']);
        $user_id = mysqli_real_escape_string($con, $data['user_id']);
        $type = mysqli_real_escape_string($con, $data['type']);
        $order_date = mysqli_real_escape_string($con, $data['order_date']);
        $order_time = mysqli_real_escape_string($con, $data['order_time']);
        $guests = (int)$data['guests'];
        $amount = (float)$data['amount'];
        $status = mysqli_real_escape_string($con, $data['status']);

        $query = "INSERT INTO order_history (order_ref, user_id, type, order_date, order_time, guests, amount, status)
                  VALUES ('$order_ref', '$user_id', '$type', '$order_date', '$order_time', $guests, $amount, '$status')";
        
        return mysqli_query($con, $query);
    }

    public function delete($id) {
        global $con;
        $safe_id = mysqli_real_escape_string($con, $id);
        $query = "DELETE FROM order_history WHERE id = '$safe_id'";
        return mysqli_query($con, $query);
    }
}
?>
