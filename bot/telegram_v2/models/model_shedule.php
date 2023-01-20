<?php
    class Model_shedule extends Model{
        public static function index($result_telegram, $group_id){
            $weekday_id       =  date("N");
            $user             =  Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
            $shutdowm_shedule =  Core::get("/shutdown_schedule/read_group.php", [
                "group_id"    => $user['group_id'], 
                "region_id"   => $user['region_id'], 
                "weekday_id"  => $weekday_id
            ]);
            $weekdays = Core::get("/weekday/read.php");

            $title_text = "------Графік відключення------ \n";
            $title_text .= "Сьогодні: " . $shutdowm_shedule['records'][0]['weekday_name'] . "\n";
            $title_text .= "Ваша група: $user[group_id] \n\n";

            $lang_text   = Service_text::get_message_text($result_telegram);
            $buttons_weekdays = Button_shedule::weekdays($weekdays['records'], $weekday_id); 
            
            $data = [
                'shutdowm_shedule' => $shutdowm_shedule['records'],
                'title_text'       => $title_text,
                'buttons'         => $buttons_weekdays, 
            ]; 
            return $data;
        }
    }