<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("orderHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id_user = $_GET['id_user'];
    $db = new DbHelper();
    $orderHelper = new orderHelper();
    try
    {
        $orderList = $orderHelper->listAll((int)$id_user);
        if (!empty($orderList)) {
            http_response_code(200);
            echo json_encode(['data' => $orderList], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
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
