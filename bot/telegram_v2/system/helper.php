<?php 
    class Helper{
        public static function dd($array)
        {
            header('Content-Type: application/json');
            print_r($array);
        }
    }