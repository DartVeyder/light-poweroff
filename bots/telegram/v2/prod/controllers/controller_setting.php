<?php
    class Controller_setting extends Controller{
        public static function index($result_telegram, $action){
            $setting = Model_setting::index($result_telegram);
            $setting['action'] = $action; 
            
            View_setting::index($result_telegram, $setting);
        }
    }