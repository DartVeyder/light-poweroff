<?php
    class Model_donate extends Model{
        public static function index($result_telegram){
            $lang_text   = Service_text::get_message_text();
            $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_weekday');
             
            return self::message($lang_text['text_donate'], [], $button_back);
        }
    }