<?php

/**
 * Class Bot
 */
class Bot
{


    public $Telegram;
    public $Api_1c;

    /**
     * Bot constructor.
     * @param $token
     * @param $api_1c_url
     * @param $username_1c
     * @param $password_1c
     */
    public function __construct($token, $api_1c_url, $username_1c, $password_1c)
    {

        $this->Telegram = new TelegramBot($token);
        $this->Api_1c = new Api1c($api_1c_url, $username_1c, $password_1c);
    }

    public function Run(){

        $data = $this->Telegram->getData();

        $text = $data->text;

        switch ($text) {
            case "test":
                $this->Telegram->sendMessage("test answer");
                break;
            case "test button":
                $this->Telegram->sendMessage("test answer", [["test 1", "test 2"], ["test 3", "test 4"],
                    [["text" => "test 5", 'request_contact' => true]]]);
                break;
            case "test photo":
                $this->Telegram->sendPhoto(
                    "https://res.cloudinary.com/tecice/image/upload/v1581216237/palm-tree.png",
                    "test answer",
                    [["test 1", "test 2"]]
                );
                break;
        }
    }
}