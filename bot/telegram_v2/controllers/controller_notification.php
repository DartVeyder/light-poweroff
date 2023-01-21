<?php
    class Controller_notification extends Controller{
        public static function edit($result_telegram, $action){
            $notification = Model_notification::edit($result_telegram);
            $notification['action'] = $action;  
            View_notification::edit($result_telegram, $notification);
        }

        public static function update($result_telegram, $notification_id, $action){
            $notification = Model_notification::edit($result_telegram,$notification_id);
    
            $notification['action'] = $action;  
            View_notification::edit($result_telegram, $notification);
        }
    }