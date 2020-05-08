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
    private $post;

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

    //возможно уберу пока нужно для теста
    public function Run()
    {
        $data = $this->Telegram->getData();
        $this->chatId = $data->chat->id;
        //$this->chatId = '414204140';
        //$text = $data->text;
        $this->checkUser($data);
    }


    private function checkUser($data)
    {
        $checkUser_db = $this->db->checkUser($this->chatId);
        if ($checkUser_db == true) {
            $this->stepsMessage($data, $checkUser_db->post); //эта фунция будет получать шаги пользователя из базы данных
        } elseif (isset($data->contact->phone_number)) {
            $this->registerUser($data->contact->phone_number);
        } else {
            $this->Telegram->sendMessage("Авторизируйтесь, для начала использования бота", [
                [["text" => "Авторизироваться", 'request_contact' => true]]]);
        }

    }

    private function registerUser($phone)
    {
        $phone = str_replace("+", "", $phone);
        $get_user_1c = $this->Api_1c->start($phone);
        if ($get_user_1c['post'] == true) {
            return $this->db->addUser($get_user_1c['name'], $get_user_1c['phone'], $this->chatId, $get_user_1c['post'], $get_user_1c['Club_id']);
        } else {
            return $this->Telegram->sendMessage("Вы не можете быть зарегистрированны" . $get_user_1c['post'] . $phone);
        }
    }

    private function stepsMessage($data, $post)
    {
        $this->Telegram->sendMessage("test answer");

    }
//    private function answerMessage($post){
//        switch ($post) {
//            case "Персональный тренер":
//                $this->Telegram->sendMessage("test answer", [
//                    ["Получить информацию о записях"],
//                    ["Записать клиента"],
//                    ["Отменить запись"]
//                ]);
//                break;
//            case "Сервис":
//                $this->Telegram->sendMessage("test answer", [
//                    ["Получить информацию о записях"]
//                ]);
//                break;
//            case "Client":
//                $this->Telegram->sendMessage("test answer", [
//                    ["Получить информацию о записях"],
//                    ["записать клиента"],
//                    ["Отменить запись"]
//                ]);
//                break;
//        }
//    }
}