<?php
    // необхідні HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header("Content-Type: application/json");

    // підключення бази даних та файл, що містить об'єкти
    include_once "../../class/dataBase/database.php";
    include_once "../objects/shutdown_schedule.php";

    // отримуємо з'єднання з базою даних
    $database = new Database();
    $db = $database->getConnection();

    // ініціалізуємо об'єкт
    $shutdown_schedule = new ShutdownShedule($db);
    
    // встановимо властивість ID запису для читання
    $shutdown_schedule->group_id = isset($_GET["group_id"]) ? $_GET["group_id"] : die();
    $shutdown_schedule->region_id = isset($_GET["region_id"]) ? $_GET["region_id"] : die();

    // получим графік відключення по групі
    $stmt = $shutdown_schedule->readGroup();

    $num = $stmt->rowCount();


    if($num > 0){
        $shutdown_schedule_arr = array();
        $shutdown_schedule_arr['records'] = array();

        // отримуємо вміст нашої таблиці
        // fetch() быстрее, чем fetchAll()
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // извлекаем строку
            extract($row);
            $shutdown_schedule_item = array(
                "group_id" => $group_id,
                "group_name" => $group_name,
                "weekday_id" => $weekday_id,
                "weekday_name" => $weekday_name,
                "shutdown_time" => $shutdown_time,
                "power_time" => $power_time,
                "status_id" => $status_id,
                "status_name" => $status_name,
                "region_id"=> $region_id,
                "region_name" => $region_name
            );
            array_push($shutdown_schedule_arr["records"], $shutdown_schedule_item);
        }

        // встановлюємо код відповіді – 200 OK
        http_response_code(200);

        // виводимо дані про графік у форматі JSON
        // echo json_encode($shutdown_schedule_arr);
        print_r($shutdown_schedule_arr);
    }else {
        //встановимо код відповіді - 404 Не знайдено
        http_response_code(404);

        // повідомляємо користувачеві, що графіки відключень не знайдені
        echo json_encode(array("message" => "Графіка виключень не знайдено."), JSON_UNESCAPED_UNICODE);
    }

?>