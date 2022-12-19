<?php
    
    // необходимые HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // подключение базы данных и файл, содержащий объекты
    $config = include_once "../../class/config.php";
    include_once "../../class/dataBase/database.php";
    include_once "../objects/user.php";

    // получаем соединение с базой данных
    $config_db = $config['database'];
    $database = new Database();
    $db = $database->getConnection( $config_db );

    // инициализируем объект
    $user = new User($db);

    $stmt = $user->read();
    $num = $stmt->rowCount();

    if($num > 0){
        $user_arr = array();
        $user_arr['records'] = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // извлекаем строку
            extract($row);
            $user_item = array(
                "region_id" => $region_id,
                "region_name" => $region_name,
                "group_id" => $group_id,
                "group_name" => $group_name,
                "user_telegram_id" => $user_telegram_id
            );
            array_push($user_arr["records"], $user_item);
        }
    
        // устанавливаем код ответа - 200 OK
        http_response_code(200);
    
        // выводим данные о товаре в формате JSON
        echo json_encode($user_arr,1);
       //print_r($regions_arr);
    }else {
        // установим код ответа - 404 Не найдено
        http_response_code(404);
    
        // сообщаем пользователю, что товары не найдены
        echo json_encode(array("message" => "Графіка виключень не знайдено."), JSON_UNESCAPED_UNICODE);
    }
?>