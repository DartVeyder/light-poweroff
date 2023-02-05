<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once "../../class/core.php";
include_once "../../class/dataBase/database.php";
include_once "../objects/shutdown_schedule.php";

// получаем соединение с базой данных
$config_db = $config['database'];
$database = new Database();
$db = $database->getConnection($config_db );

// инициализируем объект
$shutdown_schedule = new ShutdownShedule($db,$config_db);

$stmt = $shutdown_schedule->read();
$num = $stmt->rowCount();


if($num > 0){
    $shutdown_schedule_arr = array();
    $shutdown_schedule_arr['records'] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
        extract($row);
        $shutdown_schedule_item = array(
            "group_id" => $group_id,
            "weekday_id" => $weekday_id,
            "weekday_name" => $weekday_name,
            "time_start" => $time_start,
            "time_end" => $time_end,
            "status_id" => $status_id,
            "status_name" => $status_name,
            "region_id"=> $region_id,
            "region_name" => $region_name
        );
        array_push($shutdown_schedule_arr["records"], $shutdown_schedule_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
   echo json_encode($shutdown_schedule_arr);
   //print_r($shutdown_schedule_arr);
}else {
    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Графіка виключень не знайдено."), JSON_UNESCAPED_UNICODE);
}
