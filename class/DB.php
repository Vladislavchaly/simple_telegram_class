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

    public function checkUser($chat_id){
        $check_user_db = $this->pdo->query('SELECT phone FROM customers WHERE telegram_id = '.$chat_id);
        $check_user_db->bindParam(':telegram_id', $chat_id, PDO::PARAM_INT); //<-- Автоматически очищено с помощью PDO
        $check_user_db->execute();
        $check_user_db = $check_user_db->fetch(PDO::FETCH_OBJ);
        return $check_user_db;
    }
}