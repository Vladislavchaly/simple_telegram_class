<?php
require_once "class/autoload.php";

require_once "config.php";


$api_1c = new Api1c($api_url, $username_1c, $password_1c);
$get_user_1c = $api_1c->start("380977089716");
//print_r($get_user_1c);
if ($get_user_1c['post'] == true) {
//    echo $get_user_1c['post'];
    echo "all ok";
}


//$get_list_services_club = $api_1c->get_list_services_club(5);
//print_r($get_list_services_club);
//echo "<hr>";
//$get_date_services = $api_1c->get_date_services(2000003381, 380501416898);
//print_r($get_date_services);
//изменить вывод времени
//$get_date_services = $api_1c->get_time_services(2000003381, '2020-05-25', 380501416898);
//print_r($get_date_services);
//изменить вывод времени

//print_r($api_1c->add_info_trainer('5', '2000003381', '380977089716', '2020-05-28/15:00:00', '380931036889'));
//
//
//$get_list_services = $api_1c->get_info_list_all('380667074533', '');
//print_r($get_list_services);
//$list_all = $get_list_services;
//if (isset($list_all[1])){
//foreach ($list_all as $list_item) {
//    echo $list_item['date'] . "\n" . $list_item['start'] . " - " . $list_item['end'] . "\n" . $list_item['Service'], [[["text" => 'Удалить', "callback_data" => "servicedelete_".$list_item['IDshedule']]]];
//}}else{
//    echo "only one";
//}
//echo "<hr>";
//
//$remove_info_trainer = $api_1c->remove_info_trainer('1500011303', '380667074533');
//print_r($remove_info_trainer);

$get_list_trainer_by_services = $api_1c->get_list_trainer_by_services('5', '201738');
print_r($get_list_trainer_by_services);