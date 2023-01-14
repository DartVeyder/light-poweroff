<?php
     include_once "../../vendor/autoload.php";
    include_once "config.php";
    include_once "autoload.php";
    include_once "application.php";

    date_default_timezone_set(TIMEZONE);
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    set_time_limit(0);
  
 
    $application = new Application();    
    $application->run();
    
    use Telegram\Bot\Api;
   

    $token = (DEV) ? TOKEN_DEV : TOKEN_PROD;

    $telegram = new Api($token);

    

    $message = new Message($telegram);

    $array =  Model_region::index();
    Helper::dd($array);
?>