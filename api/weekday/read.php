<?php
    
    // необходимые HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // подключение базы данных и файл, содержащий объекты
    include_once "../../class/core.php";
    include_once "../../class/dataBase/database.php";
    include_once "../objects/weekday.php";
 
    // получаем соединение с базой данных 
    $database = new Database();
    $db = $database->getConnection(  $config['database']);

    // инициализируем объект
    $weekday = new Weekday($db,$config['database']);

    $stmt = $weekday->read();
    $num = $stmt->rowCount();

    if($num > 0){
        $weekday_arr = array();
        $weekday_arr['records'] = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // извлекаем строку
            extract($row);
            $weekdays_item = array(
                "weekday_id" => $weekday_id,
                "weekday_name" => $name,
                "weekday_short_name" => $short_name
            );
            array_push($weekday_arr["records"], $weekdays_item);
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
        echo json_encode(array("message" => "Дні тижня не знайдено."), JSON_UNESCAPED_UNICODE);
    }
?>