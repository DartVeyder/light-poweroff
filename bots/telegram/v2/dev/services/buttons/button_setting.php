<?php
    class button_setting{
        public static function list($data){
            foreach ($data as $key => $item) {
                $buttons[] = [
                    'text'          => $item,
                    'callback_data' => $key
                ];
            }
            return  $buttons;
        }
    }