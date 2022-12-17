<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once "../../class/dataBase/database.php";
include_once "../objects/shutdown_schedule.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$shutdown_schedule = new ShutdownShedule($db);

$stmt = $shutdown_schedule->read();
$num = $stmt->rowCount();

if($num > 0){
    $shutdown_schedule_arr = array();
    $shutdown_schedule_arr['records'] = array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // извлекаем строку
       print_r($row);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
   
}
