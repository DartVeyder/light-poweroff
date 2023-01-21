<?php
class Helper
{
    public static function dd($array)
    {
        header('Content-Type: application/json');
        print_r($array);
        exit;
    }

    public static function send($data, $exit = true)
    {
       
    
        if (is_array($data)) {
            $text = "<pre>" . json_encode($data, JSON_UNESCAPED_UNICODE) . "</pre>";
        }else{
            $text = $data;
        }


        if ($data == '') {
            $text = "Помилка!!! Пусте поле";
        }

        /*if(count($data) > 1){
            $text = "Помилка!!! Масив містить більше одного елемента";
        }*/


        $array = [
            "chat_id" => 691027924,
            "text" => $text,
            'parse_mode'    => 'html',
        ];

        Core::getTelegram()->sendMessage($array);
        if ($exit) {
            exit;
        }
    }
}
