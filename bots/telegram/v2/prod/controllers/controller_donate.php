<?php
    Class Controller_donate{
        public static function index($result_telegram, $action){
            $donate = Model_donate::index($result_telegram);
            $donate['action'] = $action; 

            View_donate::index($result_telegram, $donate); 
        }
    }