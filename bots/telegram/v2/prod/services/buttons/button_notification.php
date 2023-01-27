<?php
    Class Button_notification{
        public static function list($status_notification,  $lang_text){
            $status_on = ($status_notification)? "✅": "  ";
            $status_off = (!$status_notification)? "✅": "  ";
            $buttons = [
                [
                    "text" => $lang_text['button_notification_on'] . " " .$status_on,
                    "callback_data"  =>  "update-notification_1"
                ],
                [
                    "text" => $lang_text['button_notification_off'] . " ". $status_off,
                    "callback_data"  => "update-notification_0"
                ]
            ];
            return $buttons ;
        }
    }