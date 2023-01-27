<?php
    
    include_once "../config.php";
    include_once DIR_MAIN . "vendor/autoload.php"; 
    include_once "../autoload.php";
    include_once "../application.php";
    date_default_timezone_set(TIMEZONE);
  // ini_set("display_errors", 1);
  // error_reporting(E_ALL);
    set_time_limit(0);
  
  
    $application = new Application();    
    $application->run();  
    
    $text = "====== Оновлення бота ======
    Всім привіт ☺️. Добавлено нові функції.
    
    🛠 Тепер ви можете в Налаштуваннях змінювати область та групу.

    Також в роботі добавлення графіків для нових областей, хто може скидуйте мені для своєї області графіки відключень, а також маєте ідеї та пропозиції пишіть сюди @dart_dim 
    
    Дякую, що користуєтесь моїм ботом )))) 
    ";
    $params = [ 
        
    ];
    Controller_sending_notification_users::admin_message($text, $params);
    
?>  