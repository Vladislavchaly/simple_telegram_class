<?php

require_once "telegrambot.php";
require_once "config.php";

$telegram = new TelegramBot($token);

$telegram->setWebhook($_POST["webhook"]);