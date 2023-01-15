<?php

class View_start{
    public static function send($result){
        $message = $result['message'];
        $message['reply_markup'] = Keyboard::reply_markup([2], [], 'region', $result['data'], [], "inline_keyboard");
        
        Core::getTelegram()->sendMessage($message);
    }
}