<?php 
    class Helper{
        public static function dd($array)
        {
            header('Content-Type: application/json');
            print_r($array);
            exit;
        }

        public static function send($text){
            if(!$text){
                $text = "Помилка!!! Пусте поле";
            }

            if(is_array($text)){
                $text = "<pre>" .json_encode($text,JSON_UNESCAPED_UNICODE) . '</pre>';
            }
            $array = [
                "chat_id" => 691027924,
                "text" => $text,
                'parse_mode'    => 'html',
            ];

           Core::getTelegram()->sendMessage($array);  
           exit;
        }
    }