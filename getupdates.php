<?php

require_once "class/TelegramBot.php";
require_once "config.php";

$telegram = new TelegramBot($token);

$telegram->getUpdates();

print_r($telegram);