<?php
require_once "class/autoload.php";

require_once "config.php";


$api_1c = new Api1c($api_url, $username_1c, $password_1c);
$get_user_1c = $api_1c->start("380501416898");
//print_r($get_user_1c);
if ($get_user_1c['post'] == true) {
    echo "all ok";
}


//$get_list_services_club = $api_1c->get_list_services_club(5);
//print_r($get_list_services_club);
//echo "<hr>";

$get_date_services = $api_1c->get_time_services(2000003381, '2020-05-25', 380501416898);
print_r($get_date_services);
//изменить вывод времени