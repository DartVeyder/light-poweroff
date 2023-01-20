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
            Helper::send($shutdowm_shedule);
        }
    }