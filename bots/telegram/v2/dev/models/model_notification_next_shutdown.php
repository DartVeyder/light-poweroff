<?php
class Model_notification_next_shutdown extends Model
{
    public static function index($action)
    { 
        $next_shutdown = Core::get("/shutdown_schedule/read_next_v2.php");
        $lang_text   = Service_text::get_message_text();
        if(date("20:30") ==  $next_shutdown['notification'])
            foreach ($next_shutdown['list'] as $item) {

                $text =  "<b>➤" . $item['time_start'] . " - " . $item['time_end'] . " " .  $item['status_name'] . "</b>"; 
                $button = [['text' =>  $lang_text['button_notification_off'], 'callback_data' => 'update-nns_0']]; 
                $button_merge =  [[['text' =>   $lang_text['button_to_shedule'], 'callback_data' => 'shedule']]];
                $data = self::message($text, $button, $button_merge);

                try {
                    Helper::send($text);
                } catch (Exception $e) {

                }
            }
    }

    public static function update($notification_id){
        $lang_text   = Service_text::get_message_text();
        $result_telegram = Core::getTelegramResult()['data'];
       
        if($notification_id){
            $buttons = [['text' =>$lang_text['button_notification_off'], 'callback_data' => 'update-nns_0']];
        }else{
            $buttons = [['text' => $lang_text['button_notification_on'], 'callback_data' => 'update-nns_1']];
        }
      
        $button_shedule=  [[['text' => $lang_text['button_to_shedule'], 'callback_data' => 'shedule']]];
        $text =  "<b>".$result_telegram['message_text']. "</b>";
        
        Core::get("/user/update.php", ["user_telegram_id" => $result_telegram['user_id'], 'notification' => $notification_id]);
         
        $message  = self::message($text, $buttons, $button_shedule);
        $data = [
            'chat_id'    => $result_telegram['chat_id'],
            'message_id' => $result_telegram['message_id'],
        ];  

        return array_merge($data, $message);
    }
}
