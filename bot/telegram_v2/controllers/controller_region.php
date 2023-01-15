<?php
    class Controller_region extends Controller
    {
        public static $params;

        
       
        public static function create($result)
        {
            $array = [];
            $chat_id = $result["message"]["chat"]["id"];
            $data = [
                "first_name" => $result["message"]["from"]["first_name"],
            ];
            
            $text = Language::get_message_text($data)['start'];

            $array['data'] = Model_region::index();

            $array['message'] = [
                'text' =>   $text,
                'chat_id' => $chat_id
            ];

            return $array;
        }

    }
    