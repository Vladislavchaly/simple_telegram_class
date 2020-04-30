<?php
//autoload class
require_once "class/autoload.php";

require_once "config.php";


$bot = new Bot($token,$api_url, $username_1c, $password_1c, $db_host, $db_name, $db_user, $db_password);
$run = $bot->Run();
print_r($run);


//$dbhost = 'lenzcars.mysql.tools';
//$dbport = '3306';
//$dbname = 'lenzcars_trenerbot';
//
//$dsn = "mysql:host=$dbhost;port=$dbport;dbname=$dbname";
//$username = 'lenzcars_trenerbot';
//$password = 'n5P_m#fH80';
//
//
//
//
//
//$chat_id = 12345;
//$dbh = new PDO($dsn, $username, $password);
//$check_user_db = $dbh->prepare('SELECT telegram_id FROM customers WHERE telegram_id ='. $chat_id);
//$check_user_db->bindParam(':telegram_id', $chat_id, PDO::PARAM_INT); //<-- Автоматически очищено с помощью PDO
//$check_user_db_execute = $check_user_db->execute();
//$row = $check_user_db->fetch(PDO::FETCH_OBJ);
//print_r($row);
//$row = $check_user_db->fetch(PDO::FETCH_OBJ);
//print_r($row);
//$mysqli = new mysqli("lenzcars.mysql.tools", "lenzcars_trenerbot", "n5P_m#fH80", "lenzcars_trenerbot");
//if ($mysqli->connect_errno) {
//    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
//}
//$res = $mysqli->query("SELECT * FROM customers");
//$row = $res->fetch_assoc();
//print_r($row);


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