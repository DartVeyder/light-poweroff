<?php
    class Callback{ 
        
        
        public static function route($result, $type = '')
        {
            $route_text = self::route_text($result['data']['text'], $type);
            //Helper::send($route_text, false);
            switch ($route_text['action']) {
                case 'start':
                    Controller_region::index($result['data']);
                break; 
                case 'region': 
                    Controller_group::index($result['data'], $route_text['id']);
                break; 
                case 'back':    
                    Controller_back::index($result);
                break; 
                case 'group': 
                    Controller_shedule::index($result, $route_text['id']);
                break;
                case 'weekday':
                    Controller_weekday_shedule::index($result, $route_text['id']);
                break;
            }
        } 

        private  static function route_text($string, $type){
            $route = explode("_", $string); 

            if(!$type){ 
                return [ 
                    'action' => $route[0],
                    'id' => $route[1]
                ]; 
            }else{
                return [
                    'action' => $route[1]
                ];
            } 
        }
    }