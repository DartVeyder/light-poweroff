<?php
    class Controller_notification_next_shutdown{
        public static function index($action){
            Model_notification_next_shutdown::index($action); 
        }

        public static function update($notification_id, $action){
            
            $notification_next_shutdown = Model_notification_next_shutdown::update($notification_id);
            $notification_next_shutdown['action'] = $action;
            View_notification_next_shutdown::index($notification_next_shutdown);
        }
    }