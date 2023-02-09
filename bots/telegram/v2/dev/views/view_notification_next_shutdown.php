<?php
    class View_notification_next_shutdown extends View{
        public static function index($data, $chat_id = ""){
            extract($data); 
            $reply_markup = Keyboard::reply_markup([1], [], $buttons,  $button_merge, "inline_keyboard");
             
            self::get_message($text,$message_id, $chat_id, $reply_markup, $action);
        }
        
    }