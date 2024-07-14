<?php

header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
require_once("../Classes.php");
require_once("orderHelper.php");
require_once("orderItemHelper.php");
require_once("../user/userHelper.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();
    $orderHelper = new orderHelper();
    $orderItemHelper = new orderItemHelper();
    if (!isset($_SESSION['user'])) {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
        exit();
    }
    $user_email = $_SESSION['user'];
    $userHelper = new userHelper();
    $id_buyer = $userHelper->getUserId($user_email);
    if ($id_buyer === null) {
        http_response_code(400);
        echo json_encode(["error" => "User not found"]);
        exit();
    }
    $address = $_POST['address'];
    $note = $_POST['note'];
    $cartHelper = new cartHelper();
    $cart_items = $cartHelper->getItems()['cartItem'];
    $order_fee = $cartHelper->getTotal();
    $shipping_fee = 3;
    $total_fee = $order_fee + $shipping_fee;
    try {
        $order_id = $orderHelper->create($address, $order_fee, $total_fee, $note, $id_buyer);
        foreach ($cart_items as $item) {
            $orderItemHelper->create($item['food']['_id'], $item['amount'], $order_id);
        }
        $cartHelper->clearCart();
        http_response_code(200);
        echo json_encode(["message" => "Order placed successfully", "order_id" => $order_id]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "An error occurred while placing the order: " . $e->getMessage()]);
    }
}
?>
