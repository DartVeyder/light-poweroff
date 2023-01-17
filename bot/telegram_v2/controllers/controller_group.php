<?php
class Controller_group extends Controller
{
    public static $params;


    public static function index($data)
    { 
        $array = [];

        $language = Language::get_message_text($data);
        
        $array['data'] = Model_group::index(['region_id' => $data['callback_data']['id']]);

        $array['message'] = [
            'text' =>    $language['title_create_group'],
            'message_id' => $data['message_id'],
            'chat_id' => $data['chat_id']
        ]; 

        $array['buttons'] = Buttons::back($language['button_back_text'], 'back_start');
 
        View_group::index($array);
    }
}
