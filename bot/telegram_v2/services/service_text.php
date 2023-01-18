<?php
    class Service_text{

        public static function get_message_text($data = [] ){
            extract($data);
            $array = [
                "start" => "Привіт, ".$first_name." ! Цей бот буде вас попереджувати про відключення світла. Для початку виберіть свою область.",
                "title_create_group" => "Тепер виберіть вашу групу.",
                "button_back_text" => "Назад"
            ];
            return  $array;
        } 
    }
    