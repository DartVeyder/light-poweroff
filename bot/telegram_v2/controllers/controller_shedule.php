<?php
class Controller_shedule extends Controller{
    public static function index($result_telegram, $group_id, $weekday_id){
        $shedule =  Model_shedule::index($result_telegram, $group_id, $weekday_id);
        View_shedule::index($result_telegram, $shedule);
    }
}  