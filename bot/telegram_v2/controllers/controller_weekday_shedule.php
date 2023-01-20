<?php
    class Controller_weekday_shedule extends Controller{
        public static function index($result_telegram, $weekday_id, $action){
            $shedule =  Model_weekday_shedule::index($result_telegram, $weekday_id);
            $shedule['action'] = $action;
            View_shedule::index($result_telegram, $shedule);
        }
    }

?> 