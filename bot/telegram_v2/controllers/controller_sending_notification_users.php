<?php
    class Controller_sending_notification_users extends Controller{
        public static function admin_message($text, $param){
            Model_sending_notification_users::admin_message($text, $param);
        }
    } 