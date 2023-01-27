<?php
    class Controller_notification_admin extends Controller{
        public static function new_user($data, $action){ 
           $notification_new_user =  Model_notification_admin::new_user($data);
           $notification_new_user['action'] = $action;
           View_notification_admin::new_user($notification_new_user);
        }
    }