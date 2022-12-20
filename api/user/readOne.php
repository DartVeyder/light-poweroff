<?php

// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once "../../class/core.php";
include_once "../../class/dataBase/database.php";
include_once "../objects/user.php";

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection($config['database']);

// подготовка объекта
$user = new User($db);

// установим свойство ID записи для чтения
$user->user_telegram_id = isset($_GET["user_telegram_id"]) ? $_GET["user_telegram_id"] : die();

// получим детали товара
$user->readOne();

if ($user->user_telegram_id != null) {

    // создание массива
    $user_arr = array(
        "user_id" => $user->user_id,
        "region_id" => $user->region_id,
        "region_name" => $user->region_name,
        "group_id" => $user->group_id,
        "group_name" => $user->group_name,
        "user_telegram_id" => $user->user_telegram_id,
        "username" => $user->username,
        "first_name" => $user->first_name,
        "last_name" => $user->last_name,
        "language_code" => $user->language_code,
        "date_added" => $user->date_added,
        "date_modified" => $user->date_modified
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($user_arr);
} else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что такой товар не существует
    echo json_encode(array("message" => "Користувача нема"), JSON_UNESCAPED_UNICODE);
}