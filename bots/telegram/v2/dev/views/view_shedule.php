<?php
class View_shedule extends View
{
    public static function index($result_telegram, $data)
    {
        $text = ""; 
        extract($data);
        $text = $title_text;
        foreach ($shutdowm_shedule as $item) {
            $row_time = "$item[shutdown_time] -  $item[power_time] $item[status_name] ";
            if (@$item['now']) {
                $text .= "➤<b>$row_time</b>\n";
            } else {
                $text .= "    $row_time\n";
            }
        }

        if ($result_telegram['route']['action'] == 'group' || $result_telegram['route']['action'] == 'shedule') {
            $reply_markup = Keyboard::reply_markup([4], [], $reply_button, [], "keyboard");
            self::get_message('Графік відключень', $result_telegram['message_id'], $result_telegram['chat_id'], $reply_markup, 'send');
        }
        
        $reply_markup = Keyboard::reply_markup([4], [], $buttons, $button_merge, "inline_keyboard");
        self::get_message($text, $result_telegram['message_id'], $result_telegram['chat_id'], $reply_markup, $action);
        
    }
 
}
