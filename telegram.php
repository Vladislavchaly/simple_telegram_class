<?php
//autoload class
require_once "class/autoload.php";

require_once "config.php";


$bot = new Bot($token,$api_url, $username_1c, $password_1c, $db_host, $db_name, $db_user, $db_password);
$bot->Run();


//$db = new DB($db_host, $db_name, $db_user, $db_password);
//
//$api_1c = new Api1c($api_url, $username_1c, $password_1c);
//$get_user_1c = $api_1c->start("380667074533");
//print_r($get_user_1c);
//if ($get_user_1c['post'] == true) {
//    print_r($db->addUser(414204140, 414204140, 414204140, 414204140, 414204140));
//}
//print_r($api_1c->get_info_list_all("380667074533", 9));
//$post = $get_user_1c['post'];
//if (isset($get_user_1c['post'])){
//    echo "all ok". $post;
//}else{
//    echo "not ok";
//}
//print_r($get_user_1c);
//
//$db = new DB($db_host, $db_name, $db_user, $db_password);
//$checkUser_db = $db->checkUser(414204140);
//if ($checkUser_db == true){
//    //получить шаги по должности пользователя
//    echo "all ok";
//}else{
//  echo "not ok";
//}

//пример использования бота!
//switch ($text) {
//    case "/start":
//        $this->Telegram->sendMessage("test answer", [
//            [["text" => "test 5", 'request_contact' => true]]]);
//        break;
//    case "test":
//        $this->Telegram->sendMessage("test answer");
//        break;
//    case "test button":
//        $this->Telegram->sendMessage("test answer", [["test 1", "test 2"], ["test 3", "test 4"],
//            [["text" => "test 5", 'request_contact' => true]]]);
//        break;
//    case "test photo":
//        $this->Telegram->sendPhoto(
//            "https://res.cloudinary.com/tecice/image/upload/v1581216237/palm-tree.png",
//            "test answer",
//            [["test 1", "test 2"]]
//        );
//        break;
//}


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








//switch ($data->message->text) {
//    case "Получить информацию о записях":
//        $this->Telegram->sendMessage("Получить информацию о записях", [
//            ["Все записи", "Выбрать Дату"],
//            ["Вернуться в меню"]
//        ]);
//        break;
//    case "Все записи";
//        $this->get_info_list_all();
//        break;
//    case "Выбрать Дату";
//        $this->get_info_list_date();
//        break;
//    default:
//        $this->Telegram->sendMessage("Выберете действие!", [
//            ["Получить информацию о записях"],
//            ["Записаться"],
//            ["Отменить запись"]
//        ]);
//        break;
//}


//case "test";
//
//$this->Telegram->sendInline_keyboard("test", [
//    [["text" => "test", "callback_data" => "button_0"]]
//]);
//
//break;