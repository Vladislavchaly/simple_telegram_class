<?php
//autoload class
require_once "class/autoload.php";

require_once "config.php";

$bot = new Bot($token,$api_url, $username_1c, $password_1c);
$bot->Run();