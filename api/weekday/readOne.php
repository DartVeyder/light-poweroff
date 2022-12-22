<?php
    
    // необходимые HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // подключение базы данных и файл, содержащий объекты
    include_once "../../class/core.php";
    include_once "../../class/dataBase/database.php";
    include_once "../objects/weekday.php";
 
    // получаем соединение с базой данных
    $config_db = $config['database'];
    $database = new Database();
    $db = $database->getConnection( $config_db );

    // инициализируем объект
    $weekday = new Weekday($db);

    $stmt = $weekday->readOne($_GET);
    $num = $stmt->rowCount();

    if($num > 0){ 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // извлекаем строку
            extract($row);
            $weekday_arr = array(
                "weekday_id" => $weekday_id,
                "weekday_name" => $name
            ); 
        }
    
        // устанавливаем код ответа - 200 OK
        http_response_code(200);
    
        // выводим данные о товаре в формате JSON
        echo json_encode($weekday_arr,1);
       //print_r($regions_arr);
    }else {
        // установим код ответа - 404 Не найдено
        http_response_code(404);
    
        // сообщаем пользователю, что товары не найдены
        echo json_encode(array("message" => "День тижня не знайдено."), JSON_UNESCAPED_UNICODE);
    }
?>