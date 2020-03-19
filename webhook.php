<?php

$webhook = $_POST["webhook"];

require_once "telegrambot.php";

$telegram = new TelegramBot("759558834:AAEK8E9huakI5RmkytQkyf-6HMSF76a0A8M");

$telegram->setWebhook($webhook);