<?php

use JetBrains\PhpStorm\Language;

Class Service_buttons{

    public static function back($text, $callback_data ){
        return [[['text'=>$text,'callback_data'=> $callback_data]]];
    }
}