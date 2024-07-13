<?php
require_once("../Classes.php");
require_once("../category/categoryHelper.php");
class foodHelper
{
    private $table_name = "food";

    public function listByCategory($id_category)
    {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE id_category = ?");
            $stmt->bind_param("i", $id_category);
            $result = $stmt->execute();
            if ($result) {
                $categoryHelper = new categoryHelper();
                $result = $stmt->get_result();
                $category = $categoryHelper->listOne((int)$id_category);
                $foodList = array();
                foreach($result as $row) {
                    $food = new Food();
                    $food->convert($row);
                    $food->addCategory($category);
                    $foodList[] = $food->jsonSerialize();
                }
                return ['food' => $foodList];
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }

    public function listOne($id)
    {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE _id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            if ($result) {
                $categoryHelper = new categoryHelper();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $category = $categoryHelper->listOne((int)$row['id_category']);
                $food = new Food();
                $food->convert($row);
                $food->addCategory($category);
                return $food->jsonSerialize();
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }

    public function listBySearch($query)
    {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE name LIKE ?");
            $stmt->bind_param("s", $query);
            $result = $stmt->execute();
            if ($result) {
                $categoryHelper = new categoryHelper();
                $result = $stmt->get_result();
                $foodList = array();
                foreach($result as $row) {
                    $food = new Food();
                    $food->convert($row);
                    $category = $categoryHelper->listOne((int)$row['id_category']);
                    $food->addCategory($category);
                    $foodList[] = $food->jsonSerialize();
                }
                return ['food' => $foodList];
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }
}
?>