<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("foodHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id_category = $_GET['id_category'];
    $db = new DbHelper();
    $foodHelper = new foodHelper();
    try
    {
        $foodList = $foodHelper->listByCategory((int)$id_category);
        if (!empty($foodList)) {
            http_response_code(200);
            echo json_encode(['data' => $foodList], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'No food found', 'status' => 0]);
        }
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
    exit();
}
?>
