<?php
    include_once "config.php";
    include_once "../../vendor/autoload.php";
    include_once "language.php";
    include_once "message.php";
    include_once "callback.php";
    include_once "keyboard.php";
    
    use Telegram\Bot\Api;

    date_default_timezone_set(TIMEZONE);
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    set_time_limit(0);

    $token = (DEV) ? TOKEN_DEV : TOKEN_PROD;

    $telegram = new Api($token);
    $result = $telegram->getWebhookUpdates();

    $message = new Message($result);
?>