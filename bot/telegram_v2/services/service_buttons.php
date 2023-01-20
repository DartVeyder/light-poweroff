<?php

use JetBrains\PhpStorm\Language;

Class Service_buttons{

    public static function back($text, $callback_data ){
        return [[['text'=>$text,'callback_data'=> $callback_data]]];
    }

    public static function controls($lang_text){
        $list = ["setting", "donate", "developer"];
        foreach ($list as $item) {
            $buttons[] = [
                'text'=>$lang_text["button_$item"],'callback_data'=> $item
            ];
        }
        return array_chunk($buttons, 2);
    }

    public static function shedule_shutdown($lang_text){
        
        return [[['text'=>$lang_text, "callback_data" => "shedule"]]];
    }
}