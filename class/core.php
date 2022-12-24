<?php 

include_once "config.php";
// показывать сообщения об ошибках
ini_set("display_errors", 1);
error_reporting(E_ALL);

//часовий пояс
date_default_timezone_set($config["timezone"]);

// URL домашней страницы
$home_url_api = $config["home_url_api"];

if($config["bot"]["telegram"]["test"]){
    $token = $config["bot"]["telegram"]["token"]["test"];
}else{
    $token = $config["bot"]["telegram"]["token"]["prod"];
}




?>