<?php
    class View_notification_admin extends View{
        public static function new_user($data){
        extract($data);
        self::get_message($text, $result['message_id'], 691027924, $reply_markup, $action);
        }
    }