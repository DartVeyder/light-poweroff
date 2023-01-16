<?php
    class Controller_group extends Controller
    {
        public static $params;

        
        public static function create()
        {
            self::init();
            Core::getTelegram()->sendMessage(
                    [
                        'chat_id'       => 691027924,    
                        'text'          =>  "id" , 
                        'parse_mode'    => 'html',
                    ]
                );  
            /*
            $array = [];
            $chat_id = self::getChat_id();
            
            $text = Language::get_message_text()['title_create_group'];

            $array['data'] = Model_group::index();

            $array['message'] = [
                'text' =>   $text,
                'chat_id' => $chat_id
            ];

            return $array;*/
        }

    }
    