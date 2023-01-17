<?php

class View_region{
    public static function index($array){
        $message = $array['message'];
        $message['reply_markup'] = Keyboard::reply_markup([2], [], 'region', $array['data'], [], "inline_keyboard");
        
        Core::getTelegram()->editMessageText($message);
    }
}