<?php

    class ShutdownShedule{
        // підключення до бази даних і таблиці "shutdown_schedule"
        private $conn;
        private $table_name = "shutdown_schedule";

        private $group_id;
        private $weekday_id;
        private $time_id;

        // конструктор для підключення до бази даних 
        public function __construct($db)
        {
            $this->conn = $db;
        }

        //метод для получення часу відключення
        private function read(){
            
        }
    }

?>