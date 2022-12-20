<?php
    
    // необходимые HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // підключення бази даних та файл, що містить об'єкти
    include_once "../../class/core.php";
    include_once "../../class/dataBase/database.php";
    include_once "../objects/user.php";

    $database = new Database();
    $db = $database->getConnection($config['database']);
    $user = new User($db);

    if(
        !empty($_GET['user_telegram_id']) &&
        !empty($_GET['group_id']) &&
        !empty($_GET['region_id'])
    ){
        $user->region_id = $_GET["region_id"];
        $user->group_id = $_GET['group_id'];
        $user->user_telegram_id =  mt_rand();
        $user->date_added = date("Y-m-d H:i:s");

        $result = $user->create(); 
        if ($result['status'] == 'success') {
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
    }else{
        echo json_encode(array("status"=>"failed","message" => "Неможливо добавити користувача, нема усіх даних"), JSON_UNESCAPED_UNICODE);
    }
    
    
?>