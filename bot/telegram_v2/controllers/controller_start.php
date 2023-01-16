<?php
    class Controller_start extends Controller
    {
        public static $params;

       
        public static function index($data)
        {
            $array = [];
              
            $text = Language::get_message_text($data,'start');

            $array['data'] = Model_region::index();

            $array['message'] = [
                'text' =>   $text,
                'chat_id' =>  $data['chat_id']
            ];
            View_start::index($array); 
            
        }

    }
    