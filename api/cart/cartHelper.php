<?php
require_once("../Classes.php");
require_once("../food/foodHelper.php");
require_once("../order/orderHelper.php");
class cartHelper
{
    private $cart;

    public function __construct() {
        $this->cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    public function addItem($itemId, $amount, $price) {
        $itemExists = false;
        foreach ($this->cart as &$item) {
            if ($item['itemId'] == $itemId) {
                $item['amount'] += $amount;
                $itemExists = true;
                break;
            }
        }
        if (!$itemExists) {
            $this->cart[] = [
                'itemId' => $itemId,
                'amount' => $amount,
                'price' => $price
            ];
        }
        $this->updateSession();
    }

    public function updateItem($itemId, $amount) {
        foreach ($this->cart as &$item) {
            if ($item['itemId'] == $itemId) {
                if ($amount > 0) {
                    $item['amount'] = $amount;
                } else {
                    $this->removeItem($itemId);
                }
                $this->updateSession();
            }
        }
    }

    public function removeItem($itemId) {
        foreach ($this->cart as &$item) {
            if ($item['itemId'] == $itemId) {
                unset($this->cart[$itemId]);
                $this->updateSession();
            }
        }
    }

    public function getItems() {
        $this->addItem(1,1,1);
        $this->addItem(2,2,2);
        $foodHelper = new foodHelper();
        $itemList = array();
        $total = $this->getTotal();
        foreach ($this->cart as $item){
            $food = $foodHelper->listOne((int)$item['itemId']);
            $total = $this->getTotal();
            $itemList[] = ['food' => $food, 'amount' => $item['amount'], 'price' => $item['price']];
        }
        return ['cartItem' => $itemList, 'total' => $total];
    }

    public function clearCart() {
        $this->cart = [];
        $this->updateSession();
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['amount'] * $item['price'];
        }
        return $total;
    }

    private function updateSession() {
        $_SESSION['cart'] = $this->cart;
    }
}
?>