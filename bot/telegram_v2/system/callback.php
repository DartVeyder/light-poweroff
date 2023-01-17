<?php
    class Callback{ 
        
        
        public static function route($result, $action = '')
        {
            $callback_data = self::callback_data($result['data']['text']);
            $result['data']['callback_data'] =  $callback_data;
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
                    Controller_back::index($result);
                break; 
                case 'group':
                    
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