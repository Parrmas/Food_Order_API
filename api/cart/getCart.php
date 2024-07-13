<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("cartHelper.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $cartHelper = new cartHelper();
    try
    {
        $cartItems = $cartHelper->getItems();
        if (!empty($cartItems)) {
            http_response_code(200);
            echo json_encode(['data' => $cartItems], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'No item in cart', 'status' => 0]);
        }
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
    exit();
}
?>
