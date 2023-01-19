<?php

use JetBrains\PhpStorm\Language;

Class Service_buttons{

    public static function back($text, $callback_data ){
        return [[['text'=>$text,'callback_data'=> $callback_data]]];
    }

    public static function region_none_active($text, $callback_data ){
        return [[
            ['text'=>$text,'url'=> $callback_data],
            ['text'=>$text,'url'=> $callback_data],
            ]];
    }
}