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

$api1c = new Api1c($api_url, $username_1c, $password_1c);
$api1c_request = $api1c->requestGET("Start", "380675747884");



var_dump($api1c_request);
echo "<hr>";
$api1c_request_POST = $api1c->requestPOST("get_info_list_all",  ['id' => '380667864615', 'club_id' => '5']);

var_dump($api1c_request_POST);
