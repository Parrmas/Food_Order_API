<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("userHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();
    $db = new DbHelper();
    $userHelper = new userHelper();
    try {
        session_destroy();
        http_response_code(200);
        echo json_encode(['message' => 'Logout Successful', 'status' => 0], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
}
?>
