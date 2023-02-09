<?php
class Model_notification_next_shutdown extends Model
{
    public static function index($action)
    { 
        $next_shutdown = Core::get("/shutdown_schedule/read_next.php");
        $lang_text   = Service_text::get_message_text();
        $info = [];
        if(date("16:30") ==  $next_shutdown['notification'])
            foreach ($next_shutdown['list'] as $item) {
                $text =  "<b>➤" . $item['time_start'] . " - " . $item['time_end'] . " " .  $item['status_name'] . "</b>"; 
                $button = [['text' =>  $lang_text['button_notification_off'], 'callback_data' => 'update-nns_0']]; 
                $button_merge =  [[['text' =>   $lang_text['button_to_shedule'], 'callback_data' => 'shedule']]];
                $data = self::message($text, $button, $button_merge);
                $data['action'] = $action;
                try { 
                    View_notification_next_shutdown::index($data, $item['user_telegram_id']); 
                    $active = 1;
                    $status = 'Відправлено'; 
                } catch (Exception $e) {  
                    $active = 0;
                    $status = 'Не відправлено';
                    $error  =  $error = trim(explode(":", $e->getMessage())[1]);

                   // Core::get("/user/update.php", ["user_telegram_id" => $item['user_telegram_id'], 'active' => 0, 'date_not_active' => date("Y-m-d H:i:s"), 'not_update' => 'last_activity']);
                }
                $info[] = [
                    "user_telegram_id" => $item['user_telegram_id'],
                    "status_name" => $item['status_name'],
                    "active" => $active,
                    "status" => $status, 
                    "error" => $error 
                ];
                $text_log = date("Y-m-d H:i:s") . " [$next_shutdown[notification]] [Група $item[group_id]] [$item[user_telegram_id]] [$text] [$status]";
                Core::log($text_log, "sending_notification_users", "a+", 'txt');
                break;
                usleep(20000);
            }
            
            Helper::dd($info, false); 

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
