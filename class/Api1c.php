<?php

/**
 * Class Api1c
 */
class Api1c
{
    /**
     * @var
     */
    private $api_url;
    private $username;
    private $password;

    /**
     * Api1c constructor.
     * @param $api_url
     * @param $username
     * @param $password
     */
    function __construct($api_url, $username, $password)
    {
        $this->api_url = $api_url;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param $phone
     * @return bool|string
     * Проверка есть ли пользователь, в 1с
     */
    public function start($phone)
    {
        return $this->requestGET('Start', $phone);

    }

    /**
     * @param $id
     * @param $club_id
     * @return mixed
     * Получить все записи тренера/пользователя
     */
    public function get_info_list_all($id, $club_id)
    {
        $get_info_list_all =  $this->requestPOST('get_info_list_all', ['id' => $id, 'club_id' => $club_id]);
        foreach ($get_info_list_all as $shedules){
            foreach ($shedules as $shedule);
        }
        return $shedule;
    }

    /**
     * @param $id_service
     * @param $date
     * @param $id
     * @return mixed
     * получить даты по выбранному тренеру и услуге
     */
    public function get_time_services($id_service, $date, $id){
        $get_time_services = $this->requestPOST('get_time_services', ['id' => "$id", "date" => "$date", 'id_Service' => "$id_service"]);
        $get_time_services = $get_time_services['shedules'];
        $get_time_services = $get_time_services['shedule'];
        $array_time = array("00:00:00", "01:00:00", "02:00:00", "03:00:00", "04:00:00", "05:00:00", "06:00:00", "07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00",
            "15:00:00", "16:00:00", "17:00:00", "18:00:00", "19:00:00", "20:00:00", "21:00:00", "22:00:00", "23:00:00", "24:00:00");
        $start = $get_time_services['start'];
        $end = $get_time_services['end'];
        $time_array[] = array();
        foreach ($array_time as $array_time_value){
            if ($start <= $array_time_value and $end >= $array_time_value){
                $time_array[] = array(
                    array("text" => $array_time_value, "callback_data" => "timeservices_" . $array_time_value)
                );
            }
        }
        return $time_array;
    }
    /**
     * @param $id_service
     * @param $id
     * @return mixed
     * получить даты по выбранному тренеру и услуге
     */
    public function get_date_services($id_service, $id){
        $get_date_services = $this->requestPOST('get_date_services', ['id' => "$id", 'id_Service' => "$id_service"]);
        $get_date_services = $get_date_services['shedules'];
        $date_array = array();
        foreach ($get_date_services as $get_date_services_values){
            foreach ($get_date_services_values as $get_date_services_value){
                        $date_array[] = array(
                            array("text" => $get_date_services_value["date"], "callback_data" => "dateservices_" . $get_date_services_value["date"])
                        );
            }
        }
        return $date_array;
    }

    public function get_list_services_Pt_by_category_club($club_id, $id_category){
        $get_list_services_club = $this->requestGET('get_list_services_club', $club_id);
        $get_list_services_club = $get_list_services_club['Services'];
        $services_array = array();
        $IdService = array();
        foreach ($get_list_services_club as $services_club_values){
            foreach ($services_club_values as $services_club_value){
                if($services_club_value["is_pt"] == 1) {
                    if ($services_club_value['IdCategory'] == $id_category) {
//                        if (!in_array($services_club_value['IdService'], $IdService)) {
                            $services_array[] = array(
                                array("text" => $services_club_value["ServiceName"], "callback_data" => "servicebycategory_" . $services_club_value['IdGroupe'])
                            );
                            $IdService[] = $services_club_value['IdGroupe'];
//                        }
                    }
                }
            }
        }
        return $services_array;
    }

    public function get_list_services_group_by_category_club($club_id, $id_category){
        $get_list_services_club = $this->requestGET('get_list_services_club', $club_id);
        $get_list_services_club = $get_list_services_club['Services'];
        $services_array = array();
        $IdService = array();
        foreach ($get_list_services_club as $services_club_values){
            foreach ($services_club_values as $services_club_value){
                if($services_club_value["is_group"] == 1) {
                    if ($services_club_value['IdCategory'] == $id_category) {
//                        if (!in_array($services_club_value['IdService'], $IdService)) {
                        $services_array[] = array(
                            array("text" => $services_club_value["ServiceName"], "callback_data" => "servicebycategory_" . $services_club_value['IdGroupe'])
                        );
                        $IdService[] = $services_club_value['IdGroupe'];
//                        }
                    }
                }
            }
        }
        return $services_array;
    }
    /**
     * @param $club_id
     * @return array
     *
     */
    public function get_list_services_Pt_category_club($club_id){
        $get_list_services_club = $this->requestGET('get_list_services_club', $club_id);
        $get_list_services_club = $get_list_services_club['Services'];
        $services_array = array();
        $idCategory = array();
        foreach ($get_list_services_club as $services_club_values){
            foreach ($services_club_values as $services_club_value){
                if($services_club_value["is_pt"] == 1) {
                    if (!in_array($services_club_value['IdCategory'], $idCategory)) {
                         $services_array[] = array(
                            array("text" => $services_club_value["NameCategory"], "callback_data" => "serviceCategoryPt_".$services_club_value['IdCategory'])
                        );
                        $idCategory[] = $services_club_value['IdCategory'];
                    }
                }

            }
        }
        return $services_array;
    }

    /**
     * @param $club_id
     * @return array
     */
    public function get_list_services_group_category_club($club_id){
        $get_list_services_club = $this->requestGET('get_list_services_club', $club_id);
        $get_list_services_club = $get_list_services_club['Services'];
        $services_array = array();
        $idCategory = array();
        foreach ($get_list_services_club as $services_club_values){
            foreach ($services_club_values as $services_club_value){
                if($services_club_value["is_group"] == 1) {
                    if (!in_array($services_club_value['IdCategory'], $idCategory)) {
                        $services_array[] = $services_array[] = array(
                            array("text" => $services_club_value["NameCategory"], "callback_data" => "serviceCategorygroup_".$services_club_value['IdCategory'])
                        );
                        $idCategory[] = $services_club_value['IdCategory'];
                    }
                }

            }
        }
        return $services_array;
    }

    /**
     * @param $club_id
     * @param $id
     * @return mixed
     * Получить все услуги конкретного тренера
     */
    public function get_list_trainer_services($club_id, $id){
        $get_list_trainer_services =  $this->requestPOST('get_list_trainer_services', ['id' => $id, 'club_id' => $club_id]);
        foreach ($get_list_trainer_services as $services){
            foreach ($services as $service);
        }
        return $service;
    }

    /**
     * @param $club_id
     * @param $id_service
     * @param $IDClient
     * @param $date
     * @param $id
     * @return bool|string
     * добавить запись клиента тренеру
     */
    public function add_info_trainer($club_id, $id_service, $IDClient, $date, $id){
        //тут должен быть метод добавления пользователя
        $add_info_trainer =  $this->requestPOST('add_info_trainer', ["club_id" => $club_id, "id_service" => $id_service, "IDClient" => $IDClient, "date" => $date, "id" => $id]);
        return $add_info_trainer;
    }

    public function add_info_trainer($club_id, $id_service, $IDClient, $date, $id){
        //тут должен быть метод добавления пользователя
        $add_info_trainer =  $this->requestPOST('add_info_trainer', ["club_id" => $club_id, "id_service" => $id_service, "IDClient" => $IDClient, "date" => $date, "id" => $id]);
        return $add_info_trainer;
    }


    /**
     * @param $club_id
     * @return bool|string
     * 
     */
    public function get_list_services_club($club_id){
        return $this->requestGET('get_list_services_club', $club_id);
    }
    /**
     * @param $club_id
     * @return bool|string
     *
     */
    public function get_list_trainer_club($club_id){
        return $this->requestGET('get_list_trainer_club', $club_id);
    }
    /**
     * @param $data
     * @return false|string
     */
    public function removeBOM($data)
    {
        if (0 === strpos(bin2hex($data), 'efbbbf')) {
            return substr($data, 3);
        }
        return $data;
    }

    /**
     * @param $club_id
     * @param $id_Groupe_Service
     * @return bool|string
     * Получить трениров по выбранной услуге
     */
    public function get_list_trainer_by_services($club_id, $id_Groupe_Service){
        $get_list_trainer_by_services = $this->requestPOST('get_list_trainer_by_services', [ "Id_Groupe_Service" => "$id_Groupe_Service", "club_id" => "$club_id"]);

        $get_list_trainer_by_services = $get_list_trainer_by_services['Trainers'];
        $trainers_array = array();
        foreach ($get_list_trainer_by_services as $trainer_by_services_values){
            foreach ($trainer_by_services_values as $trainer_by_services_value){
                $trainers_array[] = array(
                    array("text" => $trainer_by_services_value["TrainerName"], "callback_data" => "trainerbyservices_".$trainer_by_services_value['TrainerId']."_". $trainer_by_services_value["IdService"]."_".$trainer_by_services_value["Price"])
                );
            }
        }
        return $trainers_array;
    }
    /**
     * @param $method
     * @param $posts
     * @return bool|string
     */
    public function requestPOST($method, $posts)
    {

        $ch = curl_init();
        $url = $this->api_url . '/' . $method . "/";
        $username = $this->username;
        $password = $this->password;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($posts));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $result = $this->removeBOM($result);
        $result =json_decode($result,true);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    /**
     * @param $method
     * @param $parameter
     * @return bool|string
     */
    public function requestGET($method, $parameter)
    {
        // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
        $ch = curl_init();
        $url = $this->api_url . '/' . $method . "/" . $parameter;
        $username = $this->username;
        $password = $this->password;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $result =  $this->removeBOM($result);
        $result =json_decode($result,true);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }


}