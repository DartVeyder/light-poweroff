<?php
    class Model_notification_admin extends Model{
        public static function new_user($user){
            $lang_text   = Service_text::get_message_text();
            $data = $user['data'];
            $text = $lang_text['text_notification_new_user'] . " " . $data['first_name'];
            return   self::message($text);
        }
    }