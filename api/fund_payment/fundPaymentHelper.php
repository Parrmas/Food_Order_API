<?php
class fundPaymentHelper
{
    private $table_name = "fund_payment";

    public function create($amount, $id_user) {
        $db = DbHelper::getInstance()->getConnection();
        try {
            // Start transaction
            $db->begin_transaction();
            $stmt = $db->prepare("INSERT INTO " . $this->table_name . " (amount, id_user) VALUES (?, ?)");
            $stmt->bind_param("di", $amount, $id_user);
            if (!$stmt->execute()) {
                throw new Exception("Error inserting fund payment: " . $stmt->error);
            }
            $stmt = $db->prepare("UPDATE user SET fund = fund + ? WHERE _id = ?");
            $stmt->bind_param("di", $amount, $id_user);
            if (!$stmt->execute()) {
                throw new Exception("Error updating user fund: " . $stmt->error);
            }
            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollback();
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }
}
?>