<?php
require_once("../Classes.php");
require_once ("orderItemHelper.php");
class orderHelper
{
    private $table_name = "order";

    public function listAll($id_user)
    {
        try {
            $db = DbHelper::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM `" . $this->table_name . "` WHERE id_buyer = ? ORDER BY created_at DESC");
            $stmt->bind_param("i", $id_user);
            $result = $stmt->execute();
            if ($result) {
                $itemHelper = new orderItemHelper();
                $result = $stmt->get_result();
                $orderList = array();
                foreach($result as $row) {
                    $order = new Order();
                    $order->convert($row);
                    $itemList = $itemHelper->listAll((int)$row['_id']);
                    $order->addItemList($itemList);
                    $orderList[] = $order->jsonSerialize();
                }
                return ['order' => $orderList];
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
            $stmt = $db->prepare("SELECT * FROM `" . $this->table_name . "` WHERE _id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            if ($result) {
                $itemHelper = new orderItemHelper();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $order = new Order();
                $order->convert($row);
                $itemList = $itemHelper->listAll((int)$row['_id']);
                $order->addItemList($itemList);
                return $order->jsonSerialize();
            }
        } catch (Exception $e) {
            error_log("Error at: " . $e->getMessage());
            throw $e;
        }
    }
}