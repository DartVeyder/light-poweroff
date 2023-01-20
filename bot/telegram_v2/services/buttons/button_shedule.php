<?php
    class Button_shedule{
        public static function weekdays($weekdays, $weekday_id){
            foreach ($weekdays as $day) {
                $i = ($day['weekday_id'] == $weekday_id) ? '✅' : '';
                if($day['weekday_id'] == $weekday_id){
                    $i = '✅';
                }else if(date("N") == $day['weekday_id']){
                    $i = '☑️';
                }else{
                    $i = '';
                }
                $buttons[] = [
                    'text' => $day['weekday_short_name'] . " " .  $i,
                    'callback_data' => "weekday_" . $day['weekday_id']
                ];
            }
            return $buttons;
        }
    }