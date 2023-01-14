<?php
    class Language{

        public static function get_message_text($data){
            return  [
                "start" => "Привіт, ".$data["first_name"]." ! Цей бот буде вас попереджувати про відключення світла. Для початку виберіть свою область."
            ];
        } 
    }
    