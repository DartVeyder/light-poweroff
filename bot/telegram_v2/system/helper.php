<?php 
    class Helper{
        public static function dd($array)
        {
            header('Content-Type: application/json');
            print_r($array);
            exit;
        }

        public static function send($text){
            $array = [
                "chat_id" => 691027924,
                "text" => json_encode($text,JSON_UNESCAPED_UNICODE)
            ];

           Core::getTelegram()->sendMessage($array);  
           exit;
        }
    }