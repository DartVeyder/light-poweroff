<?php
    class Controller_group extends Controller
    {
        public static $params;

        
        public static function index($data)
        {
 
            $array = [];
            
            $text = Language::get_message_text($data, "title_create_group");

            $array['data'] = Model_group::index();

            $array['message'] = [
                'text' =>   $text,
                'message_id' => $data['message_id'],
                'chat_id' => $data['chat_id']
            ];

           

            View_group::index($array);
        }

    }
    