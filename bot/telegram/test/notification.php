<?php
    include_once "../../../class/core.php";
    include('bot.php');
    include('../../../vendor/autoload.php');
    use Telegram\Bot\Api;

    $telegram = new Api($config["bot"]["telegram"]["token"]["test"]);
    $result = $telegram->getWebhookUpdates();
    $bot = new Bot( $result); 
    $bot->home_url_api = $home_url_api;
    $text = "Сповіщення!!";

    $bot->notification($telegram );
?>