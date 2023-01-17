<?php
class Controller_start extends Controller
{
    public static $params;


    public static function index($data)
    {
        $array = [];

        $language = Language::get_message_text($data);

        $array['data'] = Model_region::index();

        $array['message'] = [
            'text' =>   $language['start'],
            'chat_id' =>  $data['chat_id']
        ];
        View_start::index($array);
    }
}
