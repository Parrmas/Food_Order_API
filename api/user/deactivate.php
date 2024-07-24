<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("userHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $_id = $_POST['_id'];
    $userHelper = new userHelper();
    try {
        $result = $userHelper->deactivate($_id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Deactivate Successful', 'status' => 0], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Deactivate Failed. Please try again later', 'status' => 1]);
        }
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
}
?>
