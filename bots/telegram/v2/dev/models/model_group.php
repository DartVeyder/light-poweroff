<?php
class Model_group extends Model
{
    public static function index($region_id, $user_id)
    { 
        $lang_text   = Service_text::get_message_text();
        $region      = Core::get("/regions/readOne.php", ['region_id' => $region_id]);
        $button_merge = Service_buttons::back($lang_text['button_back_text'], 'back_start');

        if ($region['active']) {
            $buttons_group = Button_group::list($region['number_groups'], $lang_text);
            $text          =  $lang_text['title_create_group'];
        } else { 
            $text = $lang_text['text_region_none_active'];

            if ($region['status'] == "free") { 
                $text         .= $lang_text['text_region_free'];
                $buttons_group = Button_group::none_active($region, $lang_text);
                $buttons_controls = Service_buttons::controls($lang_text, ["donate", "developer"]);
                $button_merge     = array_merge($buttons_controls, $button_merge);
            }

            if ($region['alert']) {
                $text .= $region['alert'];
            }

         
        } 
        Core::get("/user/update.php",[ "user_telegram_id" => $user_id, 'region_id' => $region_id]);
      
        return self::message($text, $buttons_group, $button_merge  );
    }

    public static function edit($result_telegram, $group_id = ''){
        $user        = Core::get("/user/readOne.php", ['user_telegram_id' => $result_telegram['user_id']]);
        $region      = Core::get("/regions/readOne.php", ['region_id' => $user['region_id']]);
        $lang_text   = Service_text::get_message_text();
        $group_id     = ($group_id) ? $group_id : $user['group_id'];
        $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_setting');
        if($region['number_groups']){
            $buttons_group = Button_group::list($region['number_groups'], $lang_text, 'update', $group_id );
            $text          = $lang_text['text_title_edit_group'];
        }else{
            $text = $lang_text['text_title_none_group'];
        } 
        
        return self::message($text, $buttons_group, $button_back);
    } 

    
}
