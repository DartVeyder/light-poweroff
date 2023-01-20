<?php
class Controller_shedule extends Controller{
    public static function index($result_telegram, $group_id){
        $shedule =  Model_shedule::index($result_telegram['data'], $group_id);
        View_shedule::index($result_telegram['data'], $shedule);
    }
} 