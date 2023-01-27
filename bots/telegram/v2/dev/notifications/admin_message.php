<?php
    
    include_once "../../../vendor/autoload.php";
    include_once "../config.php";
    include_once "../autoload.php";
    include_once "../application.php";

    date_default_timezone_set(TIMEZONE);
   //ini_set("display_errors", 1);
   //error_reporting(E_ALL);
    set_time_limit(0);
  
  
    $application = new Application();    
    $application->run();  
    
    $text = "====== Оновлення бота ======
    Всім привіт ☺️. Вийшла нова версія бота.
    
    🛠 Тепер ви можете в Налаштуваннях змінювати область та групу.\n";
    $params = [ 
        'user_id' => 1
    ];
    Controller_sending_notification_users::admin_message($text, $params);
    
?> 