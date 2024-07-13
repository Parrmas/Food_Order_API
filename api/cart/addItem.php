<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("cartHelper.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cartHelper = new cartHelper();
    try
    {
        $itemId = isset($_POST['itemId']) ? intval($_POST['itemId']) : null;
        $amount = isset($_POST['amount']) ? intval($_POST['amount']) : null;
        $price = isset($_POST['price']) ? floatval($_POST['price']) : null;
        if ($itemId === null || $amount === null || $price === null) {
            throw new Exception("Invalid input data");
        }
        $cartHelper->addItem($itemId, $amount, $price);
        $response = [
            'status' => 'success',
            'data' => $cartHelper->getItems()
        ];
        echo json_encode($response);
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
    exit();
}
?>
