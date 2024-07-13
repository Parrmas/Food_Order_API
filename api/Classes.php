<?php
class DbHelper
{
    // Properties
    private static $instance = null;
    private $connection;

    // Constructor
    public function __construct(){
        // Create db connection & choose db
        try {
            $this->connection = mysqli_connect('localhost', 'lbtpdijm_food', 'jr7FEbjVnQL7z5dzLyBk') or
            die ('Unable to connect. Check your connection parameters.');
            mysqli_select_db($this->connection, 'lbtpdijm_food') or die(mysqli_error($this->connection));
            $this->connection->set_charset("utf8mb4"); // Set db charset
        } catch (Exception $e){
            error_log("Error connecting to database: " . $e->getMessage());
            throw $e;
        }
    }

    // Get Instance
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DbHelper();
        }
        return self::$instance;
    }

    // Get connection when needed
    public function getConnection()
    {
        return $this->connection;
    }
}

class Category
{
    private $_id;
    private $name;

    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function convert($object)
    {
        try {
            $this->_id = $object['_id'];
            $this->name = $object['name'];
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Object: " . $e->getMessage());
            throw $e;
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class User {
    private $_id;
    private $name;
    private $phone;
    private $email;
    private $fund;
    private $pfp_url;

    public function convert($object)
    {
        try {
            $this->_id = $object['_id'];
            $this->name = $object['name'];
            $this->phone = $object['phone'];
            $this->email = $object['email'];
            $this->fund = $object['fund'];
            $this->pfp_url = $object['pfp_url'];
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Object: " . $e->getMessage());
            throw $e;
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

class Food {
    private $_id;
    private $name;
    private $price;
    private $delivery_time;
    private $description;
    private $img_url;
    private $status;
    private $category;

    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public function convert($object)
    {
        try {
            $this->_id = $object['_id'];
            $this->name = $object['name'];
            $this->price = $object['price'];
            $this->delivery_time = $object['delivery_time'];
            $this->description = $object['description'];
            $this->img_url = $object['img_url'];
            $this->status = $object['status'];
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Object: " . $e->getMessage());
            throw $e;
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function addCategory($category)
    {
        $this->category = $category;
    }
}

class Order {
    private $_id;
    private $address;
    private $order_fee;
    private $shipping_fee;
    private $total_fee;
    private $note;
    private $created_at;
    private $status;
    private $items;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }


    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @param mixed $order_fee
     */
    public function setOrderFee($order_fee)
    {
        $this->order_fee = $order_fee;
    }

    /**
     * @param mixed $shipping_fee
     */
    public function setShippingFee($shipping_fee)
    {
        $this->shipping_fee = $shipping_fee;
    }

    /**
     * @param mixed $total_fee
     */
    public function setTotalFee($total_fee)
    {
        $this->total_fee = $total_fee;
    }


    public function convert($object)
    {
        try {
            $this->setId($object['_id']);
            $this->setAddress($object['address']);
            $this->setOrderFee($object['order_fee']);
            $this->setShippingFee($object['_id']);
            $this->setTotalFee($object['_id']);
            $this->setNote($object['_id']);
            $this->setCreatedAt($object['_id']);
            $this->setStatus($object['_id']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Object: " . $e->getMessage());
            throw $e;
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function addItemList($itemList)
    {
        foreach ($itemList as $item) {
            $this->items[] = $item;
        }
    }
}

class OrderItem {
    private $_id;
    private $food;
    private $amount;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function convert($object)
    {
        try {
            $this->setId($object['_id']);
            $this->setAmount($object['amount']);
        } catch (Exception $e) {
            error_log("Error converting MySQLI object to Object: " . $e->getMessage());
            throw $e;
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function addFood($food)
    {
        $this->food = $food;
    }
}

class FundPayment {
    private $_id;
    private $created_at;
    private $amount;
    private $id_user;
}
?>