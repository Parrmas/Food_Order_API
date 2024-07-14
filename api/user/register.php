<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("userHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $db = new DbHelper();
    $userHelper = new userHelper();
    try {
        $check = $userHelper->checkIfExist($email);
        if ($check) {
            http_response_code(400);
            echo json_encode(['message' => 'Email has already been used.', 'status' => 2]);
            exit();
        }
        $result = $userHelper->register($name, $email, $password, $phone);
        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'Register Successful', 'status' => 0], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Register Failed. Please try again later', 'status' => 1]);
        }
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
}
?>
