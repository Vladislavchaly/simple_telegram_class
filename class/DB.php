<?php

class DB{
    public $pdo;

    public function __construct($host, $db, $user, $pass)
    {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    /**
     * @param $chat_id
     * @return false|mixed|PDOStatement
     */
    public function checkUser($chat_id){
        $check_user_db = $this->pdo->query('SELECT * FROM customers WHERE telegram_id = '.$chat_id);
        $check_user_db->bindParam(':telegram_id', $chat_id, PDO::PARAM_INT);
        $check_user_db->execute();
        $check_user_db = $check_user_db->fetch(PDO::FETCH_OBJ);
        return $check_user_db;
    }

    public function addUser($name, $phone, $telegram_id, $post, $club_id){
        $add_user_db = $this->pdo->prepare("INSERT INTO customers (id, name, phone, telegram_id, post, club_id) VALUES (NULL, :name, :phone, :telegram_id, :post, :club_id)");
        $add_user_db->bindParam(':name', $name, PDO::PARAM_INT);
        $add_user_db->bindParam(':phone', $phone, PDO::PARAM_INT);
        $add_user_db->bindParam(':telegram_id', $telegram_id, PDO::PARAM_INT);
        $add_user_db->bindParam(':post', $post, PDO::PARAM_INT);
        $add_user_db->bindParam(':club_id', $club_id, PDO::PARAM_INT);
        $add_user_db->execute();
        $add_user_db = $add_user_db->fetch(PDO::FETCH_OBJ);
        return $add_user_db;
    }

    public function addCurrentstep ($telegram_id, $current_step){
        $add_user_db = $this->pdo->prepare("UPDATE customers SET current_step = :current_step WHERE customers.telegram_id = :telegram_id");
        $add_user_db->bindParam(':telegram_id', $telegram_id, PDO::PARAM_INT);
        $add_user_db->bindParam(':current_step', $current_step, PDO::PARAM_INT);
        $add_user_db->execute();
        $add_user_db = $add_user_db->fetch(PDO::FETCH_OBJ);
        return $add_user_db;
    }

    public function newOrder($telegram_id, $phone){
        $add_newOrder = $this->pdo->prepare("INSERT INTO orders (id, telegram_id, club_id, id_service, IDClient, date, id_trener) VALUES (NULL, :telegram_id, '', '', :phone, '', '')");
        $add_newOrder->bindParam(':phone', $phone, PDO::PARAM_INT);
        $add_newOrder->bindParam(':telegram_id', $telegram_id, PDO::PARAM_INT);
        $add_newOrder->execute();
        $add_newOrder = $add_newOrder->fetch(PDO::FETCH_OBJ);
        return $add_newOrder;
    }

    public function checkOrder($chat_id){
        $check_orders_db = $this->pdo->query('SELECT * FROM orders WHERE telegram_id = '.$chat_id);
        $check_orders_db->bindParam(':telegram_id', $chat_id, PDO::PARAM_INT);
        $check_orders_db->execute();
        $check_orders_db = $check_orders_db->fetch(PDO::FETCH_OBJ);
        return $check_orders_db;
    }
    //Нужно добавить Update

    public function updateOrder ($telegram_id, $value, $key){
        $add_user_db = $this->pdo->prepare("UPDATE orders SET $key = :value WHERE orders.telegram_id = :telegram_id");
        $add_user_db->bindParam(':telegram_id', $telegram_id, PDO::PARAM_INT);
        $add_user_db->bindParam(':value', $value, PDO::PARAM_INT);
        $add_user_db->execute();
        $add_user_db = $add_user_db->fetch(PDO::FETCH_OBJ);
        return $add_user_db;
    }
}