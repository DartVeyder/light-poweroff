<?php
    include_once "../../../class/core.php";
    include('bot.php');
    include('../../../vendor/autoload.php');
    set_time_limit(0);
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    use Telegram\Bot\Api;

    $telegram = new Api($config["bot"]["telegram"]["token"]["test"]);
    $result = $telegram->getWebhookUpdates();
    $bot = new Bot( $result); 
    $bot->home_url_api = $home_url_api;
    $text = "Сповіщення!!";

    echo $bot->notification($telegram );
?>