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
    private $phone;
    private $post;
    private $club_id;
    private $last_step;
    private $type_services;

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

        if (isset($data->message->chat->id)) {
            $this->chatId = $data->message->chat->id;
        } elseif (isset($data->callback_query->from->id)) {
            $this->chatId = $data->callback_query->from->id;
        }

        $checkUser_db = $this->db->checkUser($this->chatId);

        if (isset($checkUser_db->post)) {

            $this->phone = $checkUser_db->phone;
            $this->post = $checkUser_db->post;
            $this->club_id = $checkUser_db->club_id;
            $this->type_services = $checkUser_db->type;
            if (isset($checkUser_db->current_step)) {
                $this->last_step = $checkUser_db->current_step;
            }
            switch ($checkUser_db->post) {
                case "Personal trainer":
                    $this->stepsPersonaltrainer($data);
                    break;
                case "Masseur":
                    $this->stepsMasseur($data);
                    break;
                case "Car wash":
                    $this->stepsCarwash($data);
                    break;
                case "Employee":
                    $this->stepsEmployee($data);
                    break;
                case "Service":
                    $this->stepsService($data);
                    break;
                case "Client":
                    $this->stepsClient($data);
                    break;
            }
        } elseif (isset($data->message->contact->phone_number)) {
            $this->registerUser($data->message->contact->phone_number);
            $this->Telegram->sendMessage("test", [ //временный вариант перенести в регистрацию пользовтеля метод registerUser
                ["Получить информацию о записях"],
                ["Записаться"],
                ["Вернуться в меню"]
            ]);
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

    private function stepsPersonaltrainer($data)
    {

        if (isset($data->message->text)) {
            $this->Telegram->sendMessage("testPersonaltrainer \n text", [
                [["text" => "test", 'request_contact' => true]]]);
        } elseif ($data->message->contact) {
            $this->Telegram->sendMessage("testPersonaltrainer contact", [
                [["text" => "test", 'request_contact' => true]]]);
        }
    }

    private function stepsClient($data)
    {
        if (isset($data->message->text)) {

            switch ($data->message->text) {
                case "Получить информацию о записях":
                    $this->get_info_list_all();
                    break;
                case "Отменить запись":
                    $this->delete_info_list_all();
                    break;
                case "Записаться":
                    $this->newOrder_client();
                    break;
                case "Персональная тренировка":
                    $this->services_PT_Order_client();
                    break;
                case "Групповое занятие":
                    $this->services_group_Order_client();
                    break;
                case "Услуги":
                    $this->services_Order_client();
                    break;
                case "Тренера":
                    $this->trainer_Order_client();
                    break;
                case "ул. Шекспира, 1-А":
                    $this->club_Order_client($data->message->text);
                    break;
                case "пр. Юбилейный, 65-В":
                    $this->club_Order_client($data->message->text);
                    break;
                default:
                    $this->Telegram->sendMessage("Выберите действие!", [
                        ["Получить информацию о записях"],
                        ["Записаться"],
                        ["Отменить запись"]
                    ]);
                    break;
            }

        } elseif ($data->message->contact) {
            $this->Telegram->sendMessage("testClient contact", [
                [["text" => "test", 'request_contact' => true]]]);
        } elseif ($data->callback_query) {
            $this->callback_query_Order($data->callback_query);
        } else {
            $this->Telegram->sendMessage("Я понимаю только текстовые сообщения(");
        }
    }

//    private function stepsMasseur($data)
//    {
//        $this->Telegram->sendMessage("testMasseur");
//
//    }
//
//    private function stepsCarwash($data)
//    {
//        $this->Telegram->sendMessage("test Carwash");
//
//    }
//
//    private function stepsEmployee($data)
//    {
//        $this->Telegram->sendMessage("testEmployee");
//
//    }
//
//    private function stepsService($data)
//    {
//        $this->Telegram->sendMessage("test Service");
//
//    }


    private function get_info_list_all()
    {
        $list_all = $this->Api_1c->get_info_list_all($this->phone, $this->club_id);
        if ($list_all == true) {
            if (isset($list_all[1])) {
                foreach ($list_all as $list_item) {
                    $this->Telegram->sendMessage($list_item['date'] . "\n" . $list_item['start'] . " - " . $list_item['end'] . "\n" . $list_item['Service'], [["Вернуться в меню"]]);
                }
            }else{
                $this->Telegram->sendMessage($list_all['date'] . "\n" . $list_all['start'] . " - " . $list_all['end'] . "\n" . $list_all['Service'], [["Вернуться в меню"]]);
            }
        } else {
            $this->Telegram->sendMessage("Записей нет.", [["Вернуться в меню"]]);
        }
    }

    private function delete_info_list_all()
    {
        $this->db->addCurrentstep($this->chatId, 'delete_info_services');
        $list_all = $this->Api_1c->get_info_list_all($this->phone, $this->club_id);
        if ($list_all == true) {
            if (isset($list_all[1])) {
                foreach ($list_all as $list_item) {
                    $this->Telegram->sendInline_keyboard($list_item['date'] . "\n" . $list_item['start'] . " - " . $list_item['end'] . "\n" . $list_item['Service'], [[["text" => 'Удалить', "callback_data" => "servicedelete_" . $list_item['IDshedule']]]]);
                }
            }else{
                $this->Telegram->sendInline_keyboard($list_all['date'] . "\n" . $list_all['start'] . " - " . $list_all['end'] . "\n" . $list_all['Service'], [[["text" => 'Удалить', "callback_data" => "servicedelete_" . $list_all['IDshedule']]]]);
            }
        } else {
            $this->Telegram->sendMessage("Записей нет.", [["Вернуться в меню"]]);
        }
    }

    private function get_info_list_date()
    {
        $this->db->addCurrentstep($this->chatId, 'get_info_list_date');

    }

    private function newOrder_client()
    {
        $this->db->addCurrentstep($this->chatId, 'newOrder_client');
        $checkOrder = $this->db->checkOrder($this->chatId);
        if (empty($checkOrder)) {
            $phone = str_replace("+", "", $this->phone);
            $this->db->newOrder($this->chatId, $phone);
//            $this->Telegram->sendMessage("Нужно придумать заголовок, Шаг: выбор как пользователь будет начинать создание заказа.", [["Персональная тренировка", "Групповое занятие"], ["Вернуться в меню"]]);
//            $this->Telegram->sendMessage("Нужно придумать заголовок, Шаг: выбор как пользователь будет начинать создание заказа.", [["Услуги", "Тренера"], ["Вернуться в меню"]]);
        }
//        else {
//            $this->Telegram->sendMessage('Возникла ошибка при создании заказа, попробуйте позже', [["Вернуться в меню"]]);
            //some do
//        }
        $this->Telegram->sendMessage("Нужно придумать заголовок, Шаг: выбор как пользователь будет начинать создание заказа.", [["Персональная тренировка", "Групповое занятие"], ["Вернуться в меню"]]);
    }

    private function services_PT_Order_client()
    {
        $this->db->updateOrder($this->chatId, 'PT', 'type'); //добавляем значение что выбрал пользователь персональные тренировки
        $this->Telegram->sendMessage("Нужно придумать заголовок, Шаг: выбор как пользователь будет начинать создание заказа.", [["Услуги", "Тренера"], ["Вернуться в меню"]]);
    }

    private function services_group_Order_client()
    {
        $this->db->updateOrder($this->chatId, 'group', 'type'); //добавляем значение что выбрал пользователь групповые тренировки
        $this->Telegram->sendMessage("Нужно придумать заголовок, Шаг: выбор как пользователь будет начинать создание заказа.", [["Услуги", "Тренера"], ["Вернуться в меню"]]);
    }

    private function services_Order_client()
    {
        $this->db->addCurrentstep($this->chatId, 'services_Order_client'); //добавляем в базу значение что пользователь выбрал ветку услуг
        $this->Telegram->sendMessage("Выберите Клуб!", [
            ["ул. Шекспира, 1-А", "пр. Юбилейный, 65-В"],
            ["Отменить запись"]
        ]);
    }

    private function trainer_Order_client()
    {
        $this->db->addCurrentstep($this->chatId, 'trainer_Order_client'); //добавляем в базу значение что пользователь выбрал ветку тренеров
        $this->Telegram->sendMessage("Выберите Клуб!", [
            ["ул. Шекспира, 1-А", "пр. Юбилейный, 65-В"],
            ["Отменить запись"]
        ]);
    }


    private function club_Order_client($text)
    {

        switch ($text) {
            case "ул. Шекспира, 1-А":
                $club_id = 1;
                break;
            case "пр. Юбилейный, 65-В":
                $club_id = 5;
                break;
        }
        $this->db->updateOrder($this->chatId, $club_id, 'club_id'); //добавляем значение в базу выбранный клуб пользователя
        //проверяем какую ветку пользователь выбрал в методе services_Order_client()/trainer_Order_client() к этому методу ведет метод services_PT_Order_client/services_group_Order_client
        if ($this->last_step == "services_Order_client") {
            $checkOrder = $this->db->checkOrder($this->chatId);

            if ($checkOrder->type == "PT") { //проверяем что выбрал польователь ранее персональные занятия либо груповые
                $get_list_services_club = $this->Api_1c->get_list_services_Pt_category_club($club_id); //получаем из 1с категории занятий
                $this->Telegram->sendInline_keyboard(
                    "Выберите категорию персональной услуги:", $get_list_services_club
                );
            } elseif ($checkOrder->type == "group") {
                $get_list_services_club = $this->Api_1c->get_list_services_group_category_club($club_id);
                $this->Telegram->sendInline_keyboard(
                    "Выберите категорию груповых занятий:", $get_list_services_club
                );
            }
        } elseif ($this->last_step == "trainer_Order_client") {
//            $get_list_trainers_club = $this->Api_1c->get_list_trainer_club(5);
//            $get_list_trainers_club = $get_list_trainers_club['Trainers'];
//            $i = 0;
//            $trainers_array = array();
//            foreach ($get_list_trainers_club as $trainers_club_values){
//                foreach ($trainers_club_values as $trainers_club_value){
//                    $i++;
//                    if ($i < 5){ //нунжно для ограничения выводимых тренеров
//                        $trainers_array[] = array(
//                            array("text" => $trainers_club_value["TrainerName"], "callback_data" => "Trainerclient_".$trainers_club_value['TrainerId'])
//                        );
//                    }
//                }
//            }
//            $this->Telegram->sendInline_keyboard(
//                "Выберите тренера", $trainers_array
//            );
            $this->Telegram->sendMessage('Мой создатель еще не сделал это((');
        }
    }

    private function callback_query_Order($data)
    {
        $data = $data->data;
        $callback_array = explode('_', $data);
        switch ($this->last_step) { //получаем из базы последний шаг
            case "services_Order_client":  //если последний шаг
                $this->services_Order_client_branch($callback_array);
                break;
            case "delete_info_services":
                $response = $this->Api_1c->remove_info_trainer($callback_array[1], $this->phone);
                $this->Telegram->sendMessage($response, [["Вернуться в меню"]]);
                break;

        }
    }

    private function services_Order_client_branch($callback_array)
    {
//        $this->Telegram->sendMessage('test ' . $callback_array[0] . $callback_array[1]);
        $checkOrder = $this->db->checkOrder($this->chatId);
        switch ($callback_array[0]) {
            case "serviceCategoryPt":
                $this->Telegram->sendMessage('test Pt'. $callback_array[0]. $callback_array[1]);
                $get_list_services_club = $this->Api_1c->get_list_services_Pt_by_category_club($checkOrder->club_id, $callback_array[1]);
                $this->Telegram->sendInline_keyboard(
                    "Выберите услугу", $get_list_services_club
                );
                break;
            case "serviceCategorygroup":
                $this->Telegram->sendMessage('test group'. $callback_array[0]. $callback_array[1]);
                $get_list_services_club = $this->Api_1c->get_list_services_group_by_category_club($checkOrder->club_id, $callback_array[1]);
                $this->Telegram->sendInline_keyboard(
                    "Выберите услугу", $get_list_services_club
                );
                break;
            case "servicebycategory":
                if ($callback_array[1]) {
                    $this->db->updateOrder($this->chatId, $callback_array[1], 'id_groupe');
                }
                $this->Telegram->sendMessage('servicebycategory test ' . $callback_array[0] . $callback_array[1]);
                $get_list_trainer_by_services = $this->Api_1c->get_list_trainer_by_services($checkOrder->club_id, $callback_array[1]);
                $this->Telegram->sendInline_keyboard(
                    "Выберите Тренера:", $get_list_trainer_by_services
                );
                break;
            case "trainerbyservices":
                if ($callback_array[1] and $callback_array[2]) {
                    $this->Telegram->sendMessage('test ' . $callback_array[0] . $callback_array[1]);
                    $this->db->updateOrder($this->chatId, $callback_array[1], 'id_trener');
                    $this->db->updateOrder($this->chatId, $callback_array[2], 'id_service');
                }
                $this->Telegram->sendMessage('test ' . $callback_array[0] . $callback_array[1]. $callback_array[2]);
                $date = $this->Api_1c->get_date_services($callback_array[2],$callback_array[1]);
                if (isset($date)) {
                    $this->Telegram->sendInline_keyboard(
                        "Стоимость занятия с данным тренером: " . $callback_array[3] . "грн\nДоступные даты \nВыберите дату:", $date
                    );
                }
                break;
            case "dateservices":
                if ($callback_array[1]){
                    $this->db->updateOrder($this->chatId, $callback_array[1], 'date');
//                    $checkOrder = $this->db->checkOrder($this->chatId);
                }
                $time_service = $this->Api_1c->get_time_services($checkOrder->id_service, $callback_array[1], $checkOrder->id_trener);
                $this->Telegram->sendInline_keyboard('Выберете удобное для вас время', $time_service);
                break;
            case "timeservices":
                if ($callback_array[1]){
                    $this->Telegram->sendMessage('test ' . $callback_array[0] . $callback_array[1]);
                    $this->db->updateOrder($this->chatId, $callback_array[1], 'time');
//                    $checkOrder = $this->db->checkOrder($this->chatId);
                    $result = $this->Api_1c->add_info_trainer($checkOrder->club_id, $checkOrder->id_service, $this->phone, $checkOrder->date."/".$callback_array[1], $checkOrder->id_trener);
                    $this->Telegram->sendMessage($result, [["Вернуться в меню"]]);
                }
                break;
//            case "serviceclient":
//                $this->db->updateOrder($this->chatId, $callback_array[1], 'id_service');
//                break;
//            case "Trainerclient":
//                $this->db->updateOrder($this->chatId, $callback_array[1], 'id_trener');
//                break;
        }
    }
}
