<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("cartHelper.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $cartHelper = new cartHelper();
    try
    {
        $cartHelper->clearCart();
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
