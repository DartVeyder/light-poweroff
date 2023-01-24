<?php
class Model_notification_next_shutdown extends Model
{
    public static function index()
    {
        $error = [];
        $info  = [];
        $next  = [];
        $alert_hours = [];
        $hour = date('H:i');
        $regions = Core::get("/regions/read.php");

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
                if (!$user['notification']) {
                    continue;
                }

                $user_group_id = $user['group_id'];
                $user_region_id = $user['region_id'];
                $next_hour = $next[$user_region_id][$user_group_id]['hour'];
                $text = $next[$user_region_id][$user_group_id]['text'];
                $button = [['text' => "Виключити сповіщення", 'callback_data' => 'notification-off']];

                $button_merge =  [[['text' => "Головна", 'callback_data' => 'back_weekday']]];
                if ($next_hour  == $hour) {
                    Helper::dd([$user['first_name'], $text, $user['group_name'], $user['region_name'], $user['user_telegram_id'], $i++], false);
                    $data = self::message($text, $button, $button_merge);
                    View_notification_next_shutdown::index($data, $user['user_telegram_id']);
                    break;
                }

                if ($key > 10) {
                    //break;
                }
            }
        }
    }
}
