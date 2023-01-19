<?php
    class Button_group{
        public static function active($region, $lang_text){ 
            for ($i = 1; $i <= $region['number_groups']; $i++) {
                $buttons[] = [
                    'text' => "$lang_text[button_group_text] $i",
                    'callback_data' => "group_$i"
                ];
            } 
            return $buttons; 
        }

        public static function none_active($region, $lang_text){
            $buttons = [
                [
                    "text" => $lang_text['button_oficial_site'],
                    "url"  => $region['site']
                ],
                [
                    "text" => $lang_text['button_facebook'],
                    "url"  => $region['facebook']
                ]
            ];
            return $buttons;
        }
    }