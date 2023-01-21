<?php

class View_group extends View{
    public static function index($result, $array)
    {
        extract($array); 
        $reply_markup = Keyboard::reply_markup([3], [], $buttons, $button_merge, "inline_keyboard");
        self::get_message($text, $result['message_id'], $result['chat_id'], $reply_markup, $action);
       
    }

    public static function edit($result_telegram, $group){
        extract($group);
        $reply_markup = Keyboard::reply_markup([1], [], $buttons, $button_merge, "inline_keyboard");
        self::get_message($text, $result_telegram['message_id'], $result_telegram['chat_id'], $reply_markup, $action);
    }

}
