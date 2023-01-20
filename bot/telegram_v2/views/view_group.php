<?php

class View_group extends View{
    public static function index($result, $array)
    {
        extract($array); 
        $reply_markup = Keyboard::reply_markup([3], [], $buttons, $button_merge, "inline_keyboard");
        self::get_message($text, $result['message_id'], $result['chat_id'], $reply_markup, $action);
       
    }

}
