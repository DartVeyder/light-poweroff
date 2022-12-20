<?php 

include_once "config.php";
// показывать сообщения об ошибках
ini_set("display_errors", 1);
error_reporting(E_ALL);

//часовий пояс
date_default_timezone_set($config["timezone"]);

// URL домашней страницы
$home_url_api = "https://bear-dev.zzz.com.ua/light-poweroff/api"; 


?>