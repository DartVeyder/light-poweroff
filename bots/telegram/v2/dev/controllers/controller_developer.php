<?php
    Class Controller_developer{
        public static function index($result_telegram, $action){
            $developer = Model_developer::index($result_telegram);
            $developer['action'] = $action; 
            View_developer::index($result_telegram, $developer);
        }
    }