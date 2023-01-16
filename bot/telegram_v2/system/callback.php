<?php
    class Callback{ 
        
        
        public static function route($result)
        {
            $callback_data = self::callback_data($result['data']['text']);
            switch ($callback_data['name']) {
                case 'region':
                      Controller_group::index($result['data']);
                break; 
            }
        } 

        private  static function callback_data($string){
            $data = explode("_", $string);
            return [
                "name" => $data[0],
                "id" => $data[1]
            ];
        }
     
    }