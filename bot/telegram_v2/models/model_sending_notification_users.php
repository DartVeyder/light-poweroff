<?php
    class Model_sending_notification_users extends Model{
        public static function admin_message($text, $params){
            $users =  Core::get("/user/read.php",)['records'];
            foreach ($users as $user) {
                foreach ($params as $key => $param) { 
                    $user['date_added'] = date('Y-m-d', strtotime($user['date_added']));
                    $user['date_modified'] = date('Y-m-d', strtotime($user['date_modified']));
                    if($user[$key] != $param){
                        continue 2;
                    }
                }
                $data = self::message($text);
                View_sending_notification_users::admin_message($data, $user['user_telegram_id']);
                usleep(50000);
            }
        }
    }