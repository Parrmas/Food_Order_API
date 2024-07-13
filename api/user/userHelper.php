<?php
require_once("../Classes.php");
class userHelper
{
    private $table_name = "user";

    public function listOne($id) {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE _id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            if ($result) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $user = new User();
                $user->convert($row);
                return $user->jsonSerialize();
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }

    public function login($email, $password) {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE email = ?");
            $stmt->bind_param("s", $email);
            $result = $stmt->execute();
            if ($result) {
                $result = $stmt->get_result();
                if($result->num_rows != 1) {
                    return false;
                }
                $row = $result->fetch_assoc();
                $password_hash = $row['password'];
                $verify = password_verify($password, $password_hash);
                if ($verify) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }

    public function register($name, $email, $password) {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO `" . $this->table_name . "`(name, email, password) VALUE (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, password_hash($password, PASSWORD_DEFAULT));
            $result = $stmt->execute();
            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }
}
?>