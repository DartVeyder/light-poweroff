<?php
    include('vendor/autoload.php');
    include('menu.php');
    use Telegram\Bot\Api;

    $telegram = new Api('5953514111:AAHTQGQnJ8ek0cTq8NZd7PkFqpDmikx8xwQ');
    $result = $telegram->getWebhookUpdates();

    $text = $result["message"]["text"];
    $chta_id = $result["message"]["chat"]["id"];
    $name = $result["message"]["from"]["username"];
    $first_name = $result["message"]["from"]["first_name"];
    $last_name = $result["message"]["from"]["last_name"];

    switch ($text) {
        case '/start':
            $reply = "Menu: ";
            $reply_markup = $telegram->replyKeyboardMarkup(
                [
                    'keyboard'          => $menu, 
                    'resize_keyboard'   => true, 
                    'one_time_keyboard' => false
                ]
            );
            $telegram->sendMessage(
                [
                    'chat_id'      => $chta_id, 
                    'text'         => $reply, 
                    'reply_markup' => $reply_markup
                ]
            );
        break; 
        case 'Привіт':
            $reply = "Привіт: $first_name $last_name";
            $reply_markup = $telegram->replyKeyboardMarkup(
                [
                    'keyboard'          => $menu, 
                    'resize_keyboard'   => true, 
                    'one_time_keyboard' => false
                ]
            );
            $telegram->sendMessage(
                [
                    'chat_id'      => $chta_id, 
                    'text'         => $reply, 
                    'reply_markup' => $reply_markup
                ]
            );
        break; 
    }
   
?>