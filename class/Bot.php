<?php

/**
 * Class Bot
 */
class Bot
{

    /**
     * @var TelegramBot
     */
    private $Telegram;
    private $Api_1c;
    private $db;
    public $chatId;

    /**
     * Bot constructor.
     * @param $token
     * @param $api_1c_url
     * @param $username_1c
     * @param $password_1c
     * @param $host
     * @param $db
     * @param $user
     * @param $pass
     */
    public function __construct($token, $api_1c_url, $username_1c, $password_1c, $host, $db, $user, $pass)
    {
        $this->Telegram = new TelegramBot($token);
        $this->Api_1c = new Api1c($api_1c_url, $username_1c, $password_1c);
        $this->db = new DB($host, $db, $user, $pass);
    }


    public function Run(){
        $data = $this->Telegram->getData();
        $this->chatId = $data->chat->id;
        $chat_id = $data->chat->id;
        $text = $data->text;
        if ($this->checkUser() == true){
            $this->Telegram->sendMessage("check user true");
        }
    }

    /**
     * @return string
     */
    private function checkUser(){
       return $this->db->checkUser($this->chatId);
    }
}