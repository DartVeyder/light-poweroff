<?php
    
    // необходимые HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // подключение базы данных и файл, содержащий объекты
    include_once "../../class/core.php";
    include_once "../../class/dataBase/database.php";
    include_once "../objects/regions.php";
 
    // получаем соединение с базой данных
    $config_db = $config['database'];
    $database = new Database();
    $db = $database->getConnection( $config_db );

    // инициализируем объект
    $regions = new regions($db);

    $stmt = $regions->read();
    $num = $stmt->rowCount();

    if($num > 0){
        $regions_arr = array();
        $regions_arr['records'] = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // извлекаем строку
            extract($row);
            $regions_item = array(
                "region_id" => $region_id,
                "region_name" => $name
            );
            array_push($regions_arr["records"], $regions_item);
        }
    
        // устанавливаем код ответа - 200 OK
        http_response_code(200);
    
        // выводим данные о товаре в формате JSON
        echo json_encode($regions_arr,1);
       //print_r($regions_arr);
    }else {
        // установим код ответа - 404 Не найдено
        http_response_code(404);
    
        // сообщаем пользователю, что товары не найдены
        echo json_encode(array("message" => "Графіка виключень не знайдено."), JSON_UNESCAPED_UNICODE);
    }
?>