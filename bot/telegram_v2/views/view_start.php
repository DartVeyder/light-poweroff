<?php

class View_start{
    public static function index($array){
       
        $message = $array['message'];
        $message['reply_markup'] = Keyboard::reply_markup([2], [], $array['data'], [], "inline_keyboard");
        
        Core::getTelegram()->sendMessage($message);
    }
}