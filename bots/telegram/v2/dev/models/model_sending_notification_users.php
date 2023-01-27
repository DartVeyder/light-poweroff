<?php
    class Model_sending_notification_users extends Model{
        public static function admin_message($text, $params){
            $lang_text  = Service_text::get_message_text();
            $users =  Core::get("/user/read.php",)['records'];
            foreach ($users as $user) {
                $error = "";
                foreach ($params as $key => $param) { 
                    $user['date_added'] = date('Y-m-d', strtotime($user['date_added']));
                    $user['date_modified'] = date('Y-m-d', strtotime($user['date_modified']));
                    if($user[$key] != $param){
                        continue 2;
                    }
                }
                if($user['notification'] == 1){
                    $back_shedule =  [['text' =>   $lang_text['button_to_shedule'], 'callback_data' => 'shedule']];
                    $data = self::message($text, $back_shedule);
                }else{
                    $data = self::message($text);
                }
               
                
                try {
                    View_sending_notification_users::admin_message($data, $user['user_telegram_id']);
                    $active = 1;
                    $status = 'Відправлено'; 
                   
                } catch (Exception $e) {
                    $error = trim(explode(":", $e->getMessage())[1]);
                    $info['error'] = $error; 
                    $active        = 0;
                    $status = 'Не відправлено ' . $error ;
                }

                Core::get("/user/update.php", ["user_telegram_id" => $user['user_telegram_id'], 'active' => $active]);
                $info['active'] = $active;
                $info['status'] = $status; 
                $text_log = date("Y-m-d H:i:s") . " [$user[user_id]] [$user[user_telegram_id]] [$user[first_name]] [$status]";
                Core::log($text_log, "sending_message_users", "a+", 'txt');
                Helper::dd($text_log, false);

               
                usleep(20000);
            }
        }
    }