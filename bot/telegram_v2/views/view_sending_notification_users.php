<?php
    class View_sending_notification_users extends View{
        public static function admin_message($data, $chat_id){
            extract($data);
            self::get_message($text,'', $chat_id, $reply_markup, 'send');
        }
    }