<?php

class View_setting extends View{
    public static function index($result_telegram, $setting){
       
        extract($setting);
        
        $reply_markup = Keyboard::reply_markup([1], [], $buttons, $button_merge, "inline_keyboard");
        self::get_message($text, $result_telegram['message_id'], $result_telegram['chat_id'], $reply_markup, $action);
    }
}