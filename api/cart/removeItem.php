<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
require_once("cartHelper.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartHelper = new cartHelper();
    try {
        $itemId = isset($_POST['itemId']) ? intval($_POST['itemId']) : null;
        if ($itemId === null) {
            throw new Exception("Invalid input data");
        }
        $cartHelper->removeItem($itemId);
        $response = [
            'status' => 'success',
            'data' => $cartHelper->getItems()
        ];
        echo json_encode($response);
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        $response = [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
        echo json_encode($response);
    }
    exit();
}
?>
