<?php
class Message
{ 
    public static function route($result)
    {
        $result_telegram = $result['data'];
        $route_text = $result['data']['text'];
        
        $text_log = date("Y-m-d H:i:s") . " [message] [$result_telegram[user_id]] [$result_telegram[first_name]]  [$route_text] ";
        Core::log($text_log, "active_users", "a+", 'txt');
        switch ($route_text) {
            case '/start':
                Controller_start::index($result['data'], 'send');
            break;
            case 'Графік відключень':
              
                Controller_shedule::index($result['data'], '', date("N"), 'send');
            break;
        }
       
    }
}
