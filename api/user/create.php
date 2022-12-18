<?php
    
    // необходимые HTTP-заголовки
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // підключення бази даних та файл, що містить об'єкти
    include_once "../../class/dataBase/database.php";
    include_once "../objects/user.php";

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    
?>