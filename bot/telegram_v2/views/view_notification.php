<?php
    class View_notification extends View{
        public static function edit($result_telegram, $notification){
            extract($notification);
            $reply_markup = Keyboard::reply_markup([1], [], $buttons, $button_merge, "inline_keyboard");
            self::get_message($text, $result_telegram['message_id'], $result_telegram['chat_id'], $reply_markup, $action);
        }

        public static function off($result_telegram, $notification){
            extract($notification); 
            self::get_message($text, '', $result_telegram['chat_id'], '', $action);
        }
        
    }