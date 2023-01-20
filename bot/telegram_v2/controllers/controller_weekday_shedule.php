<?php
    class Controller_weekday_shedule extends Controller{
        public static function index($result_telegram, $weekday_id){
            $shedule =  Model_weekday_shedule::index($result_telegram, $weekday_id);
            View_shedule::index($result_telegram, $shedule);
        }
    }

?>