<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("userHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit();
    }
    $email = $_SESSION['user'];
    if (!isset($_FILES['fileToUpload'])) {
        http_response_code(400);
        echo json_encode(["error" => "No file uploaded"]);
        exit();
    }
    $file = $_FILES['fileToUpload'];
    $userHelper = new userHelper();
    $response_code = $userHelper->changePFP($file, $email);
    $response_messages = [
        0 => "Profile picture updated successfully",
        1 => "Invalid file parameters",
        2 => "File upload error",
        3 => "File too large",
        4 => "Invalid file format",
        5 => "User not found",
        6 => "File move failed",
        7 => "Database update failed"
    ];
    if ($response_code === 0) {
        http_response_code(200); // OK
    } else {
        http_response_code(400); // Bad request for any error
    }
    echo json_encode(["message" => $response_messages[$response_code]]);
}
?>
