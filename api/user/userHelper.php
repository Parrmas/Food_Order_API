<?php
require_once("../Classes.php");
class userHelper
{
    private $table_name = "user";

    public function getUserId($email) {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE email = ?");
            $stmt->bind_param("s", $email);
            $result = $stmt->execute();
            if ($result) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row['_id'];
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }

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

    public function checkIfExist($email) {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE email = ?");
            $stmt->bind_param("s", $email);
            $result = $stmt->execute();
            if ($result) {
                $result = $stmt->get_result();
                if ($result->num_rows != 0) {
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

    public function register($name, $email, $password, $phone) {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO `" . $this->table_name . "`(name, phone, email, password, phone) VALUE (?, ?, ?, ?)");
            $stmt->bind_param("sss", $name, $phone, $email, password_hash($password, PASSWORD_DEFAULT));
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

    public function changePFP($file, $email) {
        $server_url = 'https://vutt94.io.vn/food_order/images/user/';
        $target_dir = __DIR__ . '/../../images/user/';
        $default_pfp = $server_url . 'default_user.png';
        if (!isset($file['error']) || is_array($file['error'])) {
            return 1;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 2;
        }

        if ($file['size'] > 5000000) {
            return 3;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $valid_exts = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'];
        $ext = array_search($finfo->file($file['tmp_name']), $valid_exts, true);
        if ($ext === false) {
            return 4;
        }

        $new_file_name = bin2hex(random_bytes(16)) . '.' . $ext;
        $new_file_path = $target_dir . $new_file_name;

        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT pfp_url FROM " . $this->table_name . " WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows !== 1) {
                return 5;
            }
            $row = $result->fetch_assoc();
            $old_pfp_url = $row['pfp_url'];
            if (!move_uploaded_file($file['tmp_name'], $new_file_path)) {
                return 6; // File move failed
            }
            if ($old_pfp_url !== $default_pfp) {
                $old_file_path = $target_dir . basename($old_pfp_url);
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }
            $new_pfp_url = $server_url . $new_file_name;
            $stmt = $db->prepare("UPDATE " . $this->table_name . " SET pfp_url = ? WHERE email = ?");
            $stmt->bind_param("ss", $new_pfp_url, $email);
            if ($stmt->execute()) {
                return 0;
            } else {
                return 7;
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }
}
?>