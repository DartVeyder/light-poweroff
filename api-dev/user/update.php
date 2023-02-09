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
    $user = new User($db,$config['database']);

    if(@$_GET["user_telegram_id"]){
    $data = $_GET;
    
    $not_update = @explode(",", $_GET['not_update'] );
    unset($data['not_update']);
     
    if(!in_array("modified" , $not_update)){
        $data['date_modified'] = date("Y-m-d H:i:s");
    }
    

    if(!in_array("last_activity" , $not_update)){
        $data["date_last_activity"] = date("Y-m-d H:i:s");
    } 
    
    $result = $user->update($data, $_GET["user_telegram_id"]);
    if ($result["status"] == 'success') {
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
    echo json_encode( array('message' => 'відсутній user_telegram_id'), JSON_UNESCAPED_UNICODE);
}

    
?>