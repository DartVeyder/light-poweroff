<?php
    class Model{
        public static function  message($text, $buttons = [], $button_merge = []){
            
        return [
            'text'         => $text,
            'buttons'      => (array) $buttons,
            'button_merge' => (array) $button_merge,
           
        ];
        } 
    }