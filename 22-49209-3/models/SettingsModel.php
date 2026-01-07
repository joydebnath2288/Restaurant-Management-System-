<?php
class SettingsModel {

    public function get() {
        global $con;
        $query = "SELECT * FROM system_settings WHERE id = 1";
        $result = mysqli_query($con, $query);
        return mysqli_fetch_assoc($result);
    }

    public function update($data) {
        global $con;
        $be = (int)$data['backupEnabled'];
        $bt = mysqli_real_escape_string($con, $data['backupTime']);
        $ed = (int)$data['encryptData'];
        
        // Upsert
        $existing = $this->get();
        if ($existing) {
            $query = "UPDATE system_settings SET backup_enabled = $be, backup_time = '$bt', encrypt_data = $ed WHERE id = 1";
            return mysqli_query($con, $query);
        } else {
            $query = "INSERT INTO system_settings (id, backup_enabled, backup_time, encrypt_data) VALUES (1, $be, '$bt', $ed)";
            return mysqli_query($con, $query);
        }
    }
}
?>
