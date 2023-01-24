<?php
    class View{
        protected static function get_message($text, $message_id = "", $chat_id, $reply_markup = "", $action){
            
        $data = [ 
            'chat_id'      => $chat_id, 
            'parse_mode'    => 'html',
        ];
        if($reply_markup){
            $data['reply_markup'] = $reply_markup;
        }

        if($message_id){
            $data['message_id'] = $message_id;
        }
        if($text){
            $data['text'] = $text;
        } 
        if($action == "send"){
            Core::getTelegram()->sendMessage($data);
        }else if($action == "edit"){
            Core::getTelegram()->editMessageText($data);
        }
        }
    }