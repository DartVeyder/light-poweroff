<?php
class Model_notification_next_shutdown extends Model
{
    public static function index($action)
    {
        $error = [];
        $info  = [];
        $next  = [];
        $alert_hours = [];
        $hour = date('00:30');
        $regions = Core::get("/regions/read.php");
        $lang_text   = Service_text::get_message_text();

        foreach ($regions['records'] as $region) {
            if ($region['active'] == 0) {
                continue;
            }
            for ($group_id = 1; $group_id <= $region['number_groups']; $group_id++) {
                $next_shutdown = Core::get("/shutdown_schedule/read_next.php", ["group_id" => $group_id, "region_id" => $region["region_id"]])['records'][0];
                $alert_hour =  $next_shutdown['notification'][0];
                $next[$next_shutdown['region_id']][$next_shutdown['group_id']] =
                    [
                        "hour" => $alert_hour,
                        "text" => "<b>➤" . $next_shutdown['shutdown_time'] . " - " . $next_shutdown['power_time'] . " " .  $next_shutdown['status_name'] . "</b>"
                    ];
                $alert_hours[] = $alert_hour;
            }
        }

        if (in_array($hour, $alert_hours)) {
            $users =  Core::get("/user/read.php",);
            $i = 1;
            foreach ($users['records'] as $key => $user) {
                if (!$user['notification'] || !$user['active']) {
                    continue;
                } 

                $user_group_id = $user['group_id'];
                $user_region_id = $user['region_id'];
                $next_hour = $next[$user_region_id][$user_group_id]['hour'];
                $text = $next[$user_region_id][$user_group_id]['text'];
                $button = [['text' =>  $lang_text['button_notification_off'], 'callback_data' => 'update-nns_0']];

                $button_merge =  [[['text' =>   $lang_text['button_to_shedule'], 'callback_data' => 'shedule']]];
                if ($next_hour  == $hour) {
                    $data = self::message($text, $button, $button_merge);
                    $data['action'] = $action;
                    $info        = [
                        "user_id"    => $user['user_telegram_id'],
                        "first_name" => $user['first_name'],
                        "user_active" => $user['active'],
                        "i" => $i++
                    ];
                    try {
                        View_notification_next_shutdown::index($data, $user['user_telegram_id']);
                        $active = 1;
                        $status = 'Відправлено';
                    } catch (Exception $e) {
                        $info['error'] = $e->getMessage();
                        Core::get("/user/update.php", ["user_telegram_id" => $user['user_telegram_id'], 'active' => 0]);
                        $active        = 0;
                        $status = 'Не відправлено';
                    }
                    $info['active'] = $active;
                    $info['status'] = $status;

     
                    Helper::dd($info, false);
                 
                }
 
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
