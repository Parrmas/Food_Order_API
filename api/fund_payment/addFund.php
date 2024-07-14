<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("fundPaymentHelper.php");
require_once("../user/userHelper.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();
    if (!isset($_SESSION['user'])) {
        http_response_code(401); // Unauthorized
        echo json_encode(["error" => "Unauthorized"]);
        exit();
    }
    $user_email = $_SESSION['user'];
    $userHelper = new userHelper();
    $id_user = $userHelper->getUserId($user_email);
    if ($id_user === null) {
        http_response_code(400);
        echo json_encode(["error" => "User not found"]);
        exit();
    }
    if (!isset($_POST['amount']) || !is_numeric($_POST['amount'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid amount"]);
        exit();
    }
    $amount = floatval($_POST['amount']);
    if ($amount <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Amount must be greater than zero"]);
        exit();
    }
    $fundPaymentHelper = new fundPaymentHelper();
    try {
        $result = $fundPaymentHelper->create($amount, $id_user);

        if ($result) {
            http_response_code(200);
            echo json_encode(["message" => "Fund added successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to add fund"]);
        }
    } catch (Exception $e) {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "An error occurred while adding the fund: " . $e->getMessage()]);
    }
}
?>
