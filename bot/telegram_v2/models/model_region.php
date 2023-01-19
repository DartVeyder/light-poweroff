<?php
class Model_region extends Model
{
    public static function index($data)
    {
        $lang_text   = Service_text::get_message_text($data);
        $regions = Core::get("/regions/read.php");
        $buttons_region = Button_region::list($regions['records']);
        $text    = $lang_text['start'];
        
        return   self::message($text, $buttons_region);
    }
}
