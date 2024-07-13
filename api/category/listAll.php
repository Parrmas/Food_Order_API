<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("orderHelper.php");
require_once("../Classes.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $db = new DbHelper();
    $categoryHelper = new categoryHelper();
    try
    {
        $categoryList = $categoryHelper->listAll();
        if (!empty($categoryList)) {
            http_response_code(200);
            echo json_encode(['data' => $categoryList], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'No category found', 'status' => 0]);
        }
    } catch (Exception $e) {
        error_log("Error at: " . $e->getMessage());
        throw $e;
    }
    exit();
}
?>
