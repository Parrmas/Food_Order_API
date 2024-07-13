<?php

use function MongoDB\BSON\toJSON;

require_once("../Classes.php");
class categoryHelper
{
    private $table_name = "category";

    public function listOne($id_category)
    {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM {$this->table_name} WHERE _id = ?");
            $stmt->bind_param("i", $id_category);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
            $category = new Category();
            $category->convert($data);
            return $category->jsonSerialize();
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }

    public function listAll()
    {
        try {
            $this->db = DbHelper::getInstance()->getConnection();
            $stmt = $this->db->prepare("SELECT * FROM {$this->table_name}");
            $stmt->execute();
            $result = $stmt->get_result();
            $categories = array();
            foreach ($result as $row) {
                $category = new Category();
                $category->convert($row);
                $categories[] = $category->jsonSerialize();
            }
            return ['category' => $categories];
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
