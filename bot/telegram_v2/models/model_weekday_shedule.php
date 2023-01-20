<?php
    class Model_weekday_shedule extends Model{
        public static function index($result_telegram, $weekday_id){ 
            $user             =  Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
            $shutdowm_shedule =  Core::get("/shutdown_schedule/read_group.php", [
                "group_id"    => $user['group_id'], 
                "region_id"   => $user['region_id'], 
                "weekday_id"  => $weekday_id
            ]);
            $weekdays = Core::get("/weekday/read.php");
            $lang_text   = Service_text::get_message_text($result_telegram);
            $buttons_controls = Service_buttons::controls($lang_text);

            $title_text = "<b>" .$lang_text['text_title_shedule_shutdown'] . "</b>\n\n";
            $title_text .= "<b>$lang_text[text_title_checked] " . $shutdowm_shedule['records'][0]['weekday_name'] . "</b>\n";
            $title_text .= $lang_text['text_title_your_group'] . " $user[group_id] \n\n";

            $lang_text   = Service_text::get_message_text($result_telegram);
            $buttons_weekdays = Button_shedule::weekdays($weekdays['records'], $weekday_id); 
            
            $data = [
                'shutdowm_shedule' => $shutdowm_shedule['records'],
                'title_text'       => $title_text,
                'buttons'         => $buttons_weekdays, 
                'button_merge' => $buttons_controls,
            ];  
            return $data;
        }
    }