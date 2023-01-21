<?php
class Model_region extends Model
{
    public static function index($result_telegram)
    {
        $lang_text   = Service_text::get_message_text($result_telegram);
        $regions = Core::get("/regions/read.php");
        $buttons_region = Button_region::list($regions['records']);
        $text    = $lang_text['start'];
        
        return   self::message($text, $buttons_region);
    }

    public static function edit($result_telegram, $region_id = ""){
        $lang_text   = Service_text::get_message_text();
        $regions = Core::get("/regions/read.php");
        $user        = Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
        $region_id      = ($region_id) ? $region_id : $user['region_id'];
        $buttons_region = Button_region::list($regions['records'],$region_id, "update");
        $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_setting');
        $text    = $lang_text['text_title_edit_region'];
  
        return   self::message($text, $buttons_region, $button_back);
    }
}
