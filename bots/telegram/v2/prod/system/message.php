<?php
class Message
{ 
    public static function route($result)
    {
        $route_text = $result['data']['text'];
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
