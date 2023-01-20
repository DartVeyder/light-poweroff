<?php
    class Model_shedule extends Model{
        public static function index($result_telegram, $group_id = '', $weekday_id){ 
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
            $title_text .= "<b>$lang_text[text_title_today] " . $shutdowm_shedule['records'][0]['weekday_name'] . "</b>\n";
            $title_text .= $lang_text['text_title_your_group'] . " $user[group_id] \n\n";
           
           
            $buttons_weekdays = Button_shedule::weekdays($weekdays['records'], $weekday_id);
            $reply_button_shedule = Service_buttons::shedule_shutdown($lang_text['button_shutdown_shedule']);
          
            $data = [
                'shutdowm_shedule' => $shutdowm_shedule['records'],
                'title_text'       => $title_text,
                'buttons'         => $buttons_weekdays, 
                'button_merge' => $buttons_controls,
                'reply_button' => $reply_button_shedule
            ]; 
             
            return $data;
        }
    }