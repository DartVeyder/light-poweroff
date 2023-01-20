<?php
    class View{
        protected static function get_message($text, $message_id = "", $chat_id, $reply_markup, $action){
            
        $data = [ 
            'chat_id'      => $chat_id,
            'reply_markup' => $reply_markup,
            'parse_mode'    => 'html',
        ];
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