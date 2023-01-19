<?php
    class Button_region{
        public static function list($data){
            foreach ($data as $item) {
                $buttons[] = [
                    'text' => $item['region_name'],
                    'callback_data' => "region_" . $item['region_id']
                ];
            }
            return $buttons;
        }
    }