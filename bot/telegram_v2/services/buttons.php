<?php

use JetBrains\PhpStorm\Language;

Class Buttons{

    public static function back($text, $callback_data ){
        return [[['text'=>$text,'callback_data'=> $callback_data]]];
    }
}