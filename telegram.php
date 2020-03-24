<?php
//autoload class
spl_autoload_register(function ($class_name) {
    include 'class/' . $class_name . '.php';
});

require_once "config.php";

$telegram = new TelegramBot($token);

$data = $telegram->getData();

$text = $data->text;

switch ($text) {
    case "test":
        $telegram->sendMessage("test answer");
        break;
    case "test button":
        $telegram->sendMessage("test answer", [["test 1", "test 2"], ["test 3", "test 4"],
            [["text" => "test 5", 'request_contact' => true]]]);
        break;
    case "test photo":
        $telegram->sendPhoto(
            "https://res.cloudinary.com/tecice/image/upload/v1581216237/palm-tree.png",
            "test answer",
            [["test 1", "test 2"]]
        );
        break;
}

