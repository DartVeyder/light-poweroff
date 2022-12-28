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

    // отримуємо з'єднання з базою даних
    $config_db = $config['database'];
    $database = new Database();
    $db = $database->getConnection($config_db);

    // ініціалізуємо об'єкт
    $shutdown_schedule = new ShutdownShedule($db);


    // встановимо властивість ID запису для читання
    $shutdown_schedule->group_id = isset($_GET["group_id"]) ? $_GET["group_id"] : die();
    $shutdown_schedule->region_id = isset($_GET["region_id"]) ? $_GET["region_id"] : die();

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
    $shutdown_schedule_arr["metadata"][] = [
        "datetime" => $datetime
    ];
    if($num > 0){
      
        $shutdown_schedule_arr['records'] = array();

    
        // отримуємо вміст нашої таблиці
        // fetch() быстрее, чем fetchAll()
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            // извлекаем строку
                 extract($row);
                $datetime_week =  getDatesWeekday($to_weekday_id, $weekday_id, $date);
                $datetime_shutdown = $datetime_week . " " . $shutdown_time;
            if ($date > $datetime_week) {
            continue;
            }
           
            if ($datetime > $datetime_shutdown) {
                continue;
            }

            $min = strtotime($datetime_shutdown) - strtotime($datetime) ;
            $notification = [];

            if($status_id == 3){
                $notification[] = date('H:i', strtotime('-1 hour', strtotime($shutdown_time)));
            }else{
                $notification[] = date('H:i', strtotime('-1 hour', strtotime($shutdown_time)));
                $notification[] = date('H:i', strtotime('-30 minute', strtotime($shutdown_time)));
                $notification[] = date('H:i', strtotime('-15 minute', strtotime($shutdown_time)));
            }
            

            $shutdown_schedule_item = array(
                "group_id" => $group_id,
                "group_name" => $group_name,
                "weekday_id" => $weekday_id,
                "weekday_name" => $weekday_name,
                "shutdown_time" => $shutdown_time,
                "power_time" => $power_time,
                "status_id" => $status_id,
                "status_name" => $status_name,
                "region_id" => $region_id,
                "region_name" => $region_name,
                "notification" => $notification,
                "date" => $datetime_shutdown,
                "min" => $min
            );
            array_push($shutdown_schedule_arr["records"], $shutdown_schedule_item);
           
        
        }
        
        $shutdown_schedule_arr["records"] = [getNextShutdown($shutdown_schedule_arr["records"])];
        // встановлюємо код відповіді – 200 OK
        http_response_code(200);

        // виводимо дані про графік у форматі JSON
        echo json_encode($shutdown_schedule_arr);
        
    }else {
        //встановимо код відповіді - 404 Не знайдено
        http_response_code(404);

        // повідомляємо користувачеві, що графіки відключень не знайдені
        echo json_encode(array("message" => "Графіка виключень не знайдено."), JSON_UNESCAPED_UNICODE);
    }

function getNextShutdown($data){
    $arr_min = array_column($data, 'min');
    asort($arr_min);
    $id = array_key_first($arr_min);
    
    return $data[$id];
}

function getDatesWeekday($to_weekday_id, $weekday_id,  $today){
    if($to_weekday_id > $weekday_id ){
        $add_day = -($to_weekday_id-$weekday_id);
    }else if ($to_weekday_id < $weekday_id){
        $add_day = $weekday_id - $to_weekday_id;
    }
    else{
         $add_day = 0;
    }

    if($weekday_id == 1 && $to_weekday_id == 7){
        $add_day = 1;
    }

    return date("Y-m-d",strtotime( "$add_day  day", strtotime($today)));  
}
?>