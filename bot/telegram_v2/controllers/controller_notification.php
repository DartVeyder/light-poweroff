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
            Core::get("/user/update.php", ["user_telegram_id" => $result_telegram['user_id'], 'notification' => $notification_id]);
            View_notification::edit($result_telegram, $notification);
        }
        

        public static function off($result_telegram, $action){
            $notification = Model_notification::off();
            $notification['action'] = $action;  
            Core::get("/user/update.php", ["user_telegram_id" => $result_telegram['user_id'], 'notification' => 0]);
            View_notification::off($result_telegram, $notification);

        }
    }