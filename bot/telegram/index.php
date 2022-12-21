<?php
    error_reporting(0);

    include_once "../../class/core.php";
    include('bot.php');
    include('../../vendor/autoload.php');
    include('menu.php');
    use Telegram\Bot\Api;

    $telegram = new Api($config["bot"]["telegram"]["token"]);
    
    $bot = new Bot(); 
    
    $bot->telegram = $telegram;
    $bot->home_url_api = $home_url_api;

    $text = $result["message"]["text"];
    
    switch ($text) {
        case '/start':
            $bot->getTextStart();
        break;  
    }

    $bot->setRegion();

?>