<?php
    
    // необходимые HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // підключення бази даних та файл, що містить об'єкти
    $config = include_once "../../class/config.php";
    include_once "../../class/dataBase/database.php";
    include_once "../objects/user.php";

    $database = new Database();
    $db = $database->getConnection($config['database']);
    $user = new User($db);

    $user->region_id = $_GET["region_id"];
    $user->group_id = $_GET['group_id'];
    $user->user_telegram_id = $_GET['user_telegram_id'];

    $result = $user->update();
    if ($result['success']) {
        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }else{
            // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode( $result, JSON_UNESCAPED_UNICODE);
    }


    
?>