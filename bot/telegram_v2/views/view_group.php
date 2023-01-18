<?php

class View_group
{
    public static function index($result, $array)
    {
        extract($array); 
        $reply_markup = Keyboard::reply_markup([3], [], $buttons_group, $button_back , "inline_keyboard");
           
        
           $data = [
            'text' =>  $text,
            'message_id' => $result['message_id'],
            'chat_id' => $result['chat_id'],
            'reply_markup' => $reply_markup
        ];
         
        Core::getTelegram()->editMessageText($data);
    }
 
}
