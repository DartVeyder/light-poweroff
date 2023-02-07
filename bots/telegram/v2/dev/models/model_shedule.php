<?php
class Model_shedule extends Model
{
    public static function index($result_telegram, $group_id = '', $weekday_id)
    {
        if($group_id){
            Core::get("/user/update.php", ["user_telegram_id" => $result_telegram['user_id'], 'group_id' => $group_id , 'notification' => 1] );    
        }
        
        
        $user             =  Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
        $shutdowm_shedule =  Core::get("/shutdown_schedule/read_group.php", [
            "group_id"    => $user['group_id'],
            "region_id"   => $user['region_id'],
            "weekday_id"  => $weekday_id
        ]); 
        $weekday          = Core::get("/weekday/readOne.php", ['weekday_id' => date("N")]);
        
        $weekdays = Core::get("/weekday/read.php");
        $lang_text   = Service_text::get_message_text($user);
        $buttons_controls = Service_buttons::controls($lang_text , ["setting", "donate", "developer"]);

        $title_text = "<b>" . $lang_text['text_title_shedule_shutdown'] . "</b>\n\n";

        $title_text .= "<b>$lang_text[text_title_today] " . $weekday['weekday_name'] . "</b>\n";
        $title_text .= $lang_text['setting_title_text']."\n";
        if ($shutdowm_shedule['status'] == 'failed') {
            $title_text .= $lang_text['text_region_none_active'] . "\n\n";
        }

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
