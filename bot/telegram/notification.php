<?php
    include_once "../../class/core.php";
    include('bot.php');
    include('../../vendor/autoload.php');

    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    use Telegram\Bot\Api;

    $telegram = new Api($config["bot"]["telegram"]["token"]["prod"]);
    $result = $telegram->getWebhookUpdates();
    $bot = new Bot( $result); 
    $bot->home_url_api = $home_url_api;
    
    echo $bot->notification($telegram );
?>