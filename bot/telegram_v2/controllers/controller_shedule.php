<?php
class Controller_shedule extends Controller{
    public static function index($result_telegram, $group_id){
       
        Model_shedule::index($result_telegram['data'], $group_id);
    }
}