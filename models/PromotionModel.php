<?php
class PromotionModel {

    public function getCouponByCode($code) {
        global $con;
        $safe_code = mysqli_real_escape_string($con, $code);
        
        $query = "SELECT * FROM coupons WHERE code = '$safe_code' AND is_active = 1 LIMIT 1";
        $result = mysqli_query($con, $query);
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }
}
?>
