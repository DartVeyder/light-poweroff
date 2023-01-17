<?php
    class Callback{ 
        
        
        public static function route($result, $action = '')
        {
            $callback_data = self::callback_data($result['data']['text']);
            if(!$action){ 
                $name = $callback_data['name'];
            }else{
                $name = $callback_data['id'];
            }
            
            switch ($name) {
                case 'start':
                    Controller_region::index($result['data']);
                break;
                case 'region':
                    Controller_group::index($result['data']);
                break; 
                case 'back':   
                    Callback::route($result, 1); 
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