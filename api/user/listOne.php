<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("userHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $id_user = $_GET['id_user'];
    $db = new DbHelper();
    $userHelper = new userHelper();
    try {
        $user['user'] = $userHelper->listOne($id_user);
        if (!empty($user)) {
            http_response_code(200);
            echo json_encode(['data' => $user], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'No user found', 'status' => 0]);
        }
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
}
?>
