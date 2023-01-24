<?php
    class Callback{ 
        
        
        public static function route($result, $type = '')
        {
            $route_text = self::route_text($result['data']['text'], $type);
            $result['data']['route'] = $route_text;
            $result_telegram = $result['data']; 
          
            switch ($route_text['action']) {
                case 'start':
                    Controller_region::index($result_telegram , 'edit');
                break; 
                case 'region': 
                    Controller_group::index($result_telegram , $route_text['id'], 'edit');
                break; 
                case 'back':    
                    Controller_back::index($result); 
                break; 
                case 'group': 
                    Controller_shedule::index($result_telegram , $route_text['id'], date("N"), 'edit');
                break;
                case 'weekday': 
                    Controller_weekday_shedule::index($result_telegram , $route_text['id'], 'edit');
                break; 
                case 'setting':
                    Controller_setting::index($result_telegram, 'edit');
                break;
                case 'editGroup':
                    Controller_group::edit($result_telegram, 'edit');
                break;
                case 'update-group':
                    Controller_group::update($result_telegram,  $route_text['id'], 'edit'); 
                break;
                case 'editRegion':
                    Controller_region::edit($result_telegram, 'edit');
                break;
                case 'update-region':
                    Controller_region::update($result_telegram,  $route_text['id'], 'edit');
                break;
                case 'editNotification': 
                    Controller_notification::edit($result_telegram, 'edit');
                break;
                case 'update-notification':
                    Controller_notification::update($result_telegram,  $route_text['id'], 'edit');
                break;
                case 'update-nns':
                    Controller_notification_next_shutdown::update($route_text['id'],'edit');
                break;
                case 'donate':
                    Controller_donate::index($result_telegram, 'edit');
                break;
                case 'developer':
                    Controller_developer::index($result_telegram, 'edit');
                break; 
                case 'shedule':
                    Controller_shedule::index($result_telegram , '', date("N"), 'edit');
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