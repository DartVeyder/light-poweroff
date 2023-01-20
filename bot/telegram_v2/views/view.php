<?php
    class View{
        protected static function get_message($text, $message_id = "", $chat_id, $reply_markup){
        return[
            'text'         => $text,
            'message_id'   => $message_id,
            'chat_id'      => $chat_id,
            'reply_markup' => $reply_markup,
            'parse_mode'    => 'html',
        ];
        }
    }