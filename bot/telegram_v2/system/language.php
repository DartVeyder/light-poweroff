<?php
    class Language{

        public static function get_message_text($data = [], $title){
            $array = [
                "start" => "Привіт, ".@$data["first_name"]." ! Цей бот буде вас попереджувати про відключення світла. Для початку виберіть свою область.",
                "title_create_group" => "Тепер виберіть вашу групу."
            ];
            return  $array[$title];
        } 
    }
    