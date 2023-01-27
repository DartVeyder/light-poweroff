<?php
class Controller_shedule extends Controller{
    public static function index($result_telegram, $group_id, $weekday_id, $action){    
        $shedule =  Model_shedule::index($result_telegram, $group_id, $weekday_id);
        $shedule['action'] = $action;
        View_shedule::index($result_telegram, $shedule);
    }
 
}   