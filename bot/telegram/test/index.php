<?php
    error_reporting(0);

    include_once "../../../class/core.php";
    include('bot.php');
    include('../../../vendor/autoload.php');
    use Telegram\Bot\Api;

    $telegram = new Api($config["bot"]["telegram"]["token"]["test"]);
    $result = $telegram->getWebhookUpdates();
    $bot = new Bot($result); 
    
    $bot->telegram = $telegram;
    $bot->home_url_api = $home_url_api;
    $bot->config = $config;
    $text = $result["message"]["text"];
    
    switch ($text) {
        case '/start':
            $bot->getTextStart(); 
            break;
        case 'Графік відключень':
            $bot->getShutdownSchedule();
        break; 
    }
 
    $bot->callbackQuery( $result);

?>