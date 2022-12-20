<?php 

$config = include_once "config.php";
// показывать сообщения об ошибках
ini_set("display_errors", 1);
error_reporting(E_ALL);

//часовий пояс
date_default_timezone_set("Europe/Kiev");

// URL домашней страницы
$home_url = "http://light-poweroff/api/"; 


?>