<?php
class Model_group extends Model
{
    public static function index($id)
    { 
        $lang_text   = Service_text::get_message_text();
        $region      = Core::get("/regions/readOne.php", ['region_id' => $id]);
        $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_start');

        if ($region['active']) {
            $buttons_group = Button_group::list($region['number_groups'], $lang_text);
            $text          =  $lang_text['title_create_group'];
        } else { 
            $text = $lang_text['text_region_none_active'];

            if ($region['status'] == "free") {
                $text         .= $lang_text['text_region_free'];
                $buttons_group = Button_group::none_active($region, $lang_text);
            }

            if ($region['alert']) {
                $text .= $region['alert'];
            }
        } 
        return self::message($text, $buttons_group, $button_back);
    }

    public static function edit($result_telegram){
        $user        = Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
        $region      = Core::get("/regions/readOne.php", ['region_id' => $user['region_id']]);
        $lang_text   = Service_text::get_message_text();
        $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_setting');
        $buttons_group = Button_group::list($region['number_groups'], $lang_text, 'update');
        $text          = $lang_text['text_title_edit_group'];
        return self::message($text, $buttons_group, $button_back);
    } 

    
}
