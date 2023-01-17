<?php
class Controller_region extends Controller
{
    public static $params;


    public static function index($data)
    {
        $array = [];

        $language = Language::get_message_text($data);

        $array['data'] = Model_region::index();

        $array['message'] = [
            'text' =>   $language['start'],
            'message_id' => $data['message_id'],
            'chat_id' =>  $data['chat_id']
        ];
        View_region::index($array);
    }
}
