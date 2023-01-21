<?php
class Model_setting extends Model
{
    public static function index($result_telegram)
    {
        $user =  Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
        $lang_text   = Service_text::get_message_text($user);
        $notification = ($user['notification']) ? $lang_text['setting_title_text_nottification_on'] : $lang_text['setting_title_text_nottification_off']; 
        $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_weekday');

        $buttons = [
            "editNotification" => $lang_text['button_edit_notification'],
            "editGroup" => $lang_text['button_edit_group'],
            "editRegion" => $lang_text['button_edit_region'],
        ];  
        $text = $lang_text['setting_title_text'];
        $text .= $lang_text['setting_title_text_notification'] . $notification;
        $buttons_setting =  button_setting::list($buttons);
        
         return self::message($text, $buttons_setting, $button_back);;
    }
}
