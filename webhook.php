<?php

require_once "class/TelegramBot.php";
require_once "config.php";

$telegram = new TelegramBot($token);

echo $telegram->setWebhook("https://chalybot.chaly.xyz/telegram.php");