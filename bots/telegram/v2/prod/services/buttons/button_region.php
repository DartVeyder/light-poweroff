<?php
    class Button_region{
        public static function list($regions, $region_id = "", $prefix = ""){
            $prefix = ($prefix) ? $prefix . "-" : "";
            foreach ($regions as $region) {
            $check     = ($region_id == $region['region_id']) ? "✅" : "";
                $buttons[] = [
                    'text' => $region['region_name'] ." ".  $check,
                    'callback_data' => $prefix . "region_" . $region['region_id']
                ];
            }
            return $buttons;
        }
    }