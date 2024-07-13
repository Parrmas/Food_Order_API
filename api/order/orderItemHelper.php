<?php
require_once("../Classes.php");
require_once ("../food/foodHelper.php");
class orderItemHelper
{
    private $table_name = "order_item";

    public function listAll($id)
    {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM " . $this->table_name . " WHERE id_order = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            if ($result) {
                $foodHelper = new foodHelper();
                $result = $stmt->get_result();
                $itemList = array();
                foreach($result as $row) {
                    $item = new OrderItem();
                    $item->convert($row);
                    $food = $foodHelper->listOne((int)$row['id_food']);
                    $item->addFood($food);
                    $itemList[] = $item->jsonSerialize();
                }
                return $itemList;
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }
}
?>