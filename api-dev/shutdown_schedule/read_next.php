<?php
date_default_timezone_set("Europe/Kyiv");

// необхідні HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// підключення бази даних та файл, що містить об'єкти
include_once "../../class/core.php";
include_once "../../class/dataBase/database.php";
include_once "../objects/shutdown_schedule.php";
include_once "../objects/user.php";

// отримуємо з'єднання з базою даних 
$database = new Database();
$db = $database->getConnection($config['database']);

$users = new User($db, $config['database']);

// ініціалізуємо об'єкт
$shutdown_schedule = new ShutdownShedule($db, $config['database']);


$to_weekday_id = date("N");
$date = date("Y-m-d");
$datetime = date("Y-m-d H:i");
/*
    $to_weekday_id = 7;
    $date = date("2022-12-25");
    $datetime = date("2022-12-25 13:00");
*/
$shutdown_schedule->to_weekday_id = $to_weekday_id;

// получим графік відключення по групі
$stmt = $shutdown_schedule->readNext();

$num = $stmt->rowCount();
$shutdown_schedule_arr = array();

if ($num > 0) {

    $shutdown_schedule_arr['records'] = array();

    // отримуємо вміст нашої таблиці
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $datetime_week =  getDatesWeekday($to_weekday_id, $weekday_id, $date);
        $datetime_start = $datetime_week . " " . $time_start;
        $min = strtotime($datetime_start) - strtotime($datetime);
        if ($date > $datetime_week) {
            continue;
        }

        if ($datetime > $datetime_start) {
            continue;
        }

        $shutdown_schedule_item = array(
            "group_id" => $group_id,
            "weekday_id" => $weekday_id,
            "weekday_name" => $weekday_name,
            "time_start" => $time_start,
            "time_end" => $time_end,
            "status_id" => $status_id,
            "status_name" => $status_name,
            "region_id" => $region_id,
            "region_name" => $region_name,
            "datetime_start" => $datetime_start,
            "min" => $min
        );
        array_push($shutdown_schedule_arr["records"], $shutdown_schedule_item);
    }
    $shutdown_schedule_arr = getNextShutdown($shutdown_schedule_arr["records"], $users);
    // встановлюємо код відповіді – 200 OK
    http_response_code(200);

    // виводимо дані про графік у форматі JSON
    echo json_encode($shutdown_schedule_arr);
} else {
    //встановимо код відповіді - 404 Не знайдено
    http_response_code(404);

    // повідомляємо користувачеві, що графіки відключень не знайдені
    echo json_encode(array("message" => "Графіка виключень не знайдено."), JSON_UNESCAPED_UNICODE);
}

function getNextShutdown($data, $users)
{
    $arr_min = array_column($data, 'min');
    $time_start = $data[0]['time_start'];
    $send_users = [];
    foreach ($data as $item) {

        if ($item['min'] == min($arr_min)) {
            $stmt = $users->read(['group_id' => $item['group_id'], 'region_id' => $item['region_id'], 'notification' => 1]);
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $send_users['list'][] = [
                        "user_telegram_id" => $row['user_telegram_id'],
                        "status_name" => $item['status_name'],
                        "time_start"  => $item["time_start"],
                        "time_end"    => $item["time_end"],
                        'group_id'    => $item['group_id'],
                        'region_name' => $item['region_name'],
                    ];
                } 
            } else {
                break;
            }
        }
    }
    $send_users['metadata'] = [
        "quantity" => count($send_users['list'])
    ] ;
    $send_users["notification"] = date('H:i', strtotime('-30 minute', strtotime($time_start)));
    return $send_users;
}

function getDatesWeekday($to_weekday_id, $weekday_id,  $today)
{
    if ($to_weekday_id > $weekday_id) {
        $add_day = - ($to_weekday_id - $weekday_id);
    } else if ($to_weekday_id < $weekday_id) {
        $add_day = $weekday_id - $to_weekday_id;
    } else {
        $add_day = 0;
    }

    if ($weekday_id == 1 && $to_weekday_id == 7) {
        $add_day = 1;
    }

    return date("Y-m-d", strtotime("$add_day  day", strtotime($today)));
}
