<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("orderHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id = $_GET['id'];
    $db = new DbHelper();
    $orderHelper = new orderHelper();
    try
    {
        $order['order'] = $orderHelper->listOne((int)$id);
        if (!empty($order)) {
            http_response_code(200);
            echo json_encode(['data' => $order], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'No order found', 'status' => 0]);
        }
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
    exit();
}
?>
