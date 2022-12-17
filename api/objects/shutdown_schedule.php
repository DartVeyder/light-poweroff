<?php

    class ShutdownShedule{
        // підключення до бази даних і таблиці "shutdown_schedule"
        private $conn;
        private $table_name = "shutdown_schedule";

        private $group_id;
        private $weekday_id;
        private $time_id;
        private $status_id;

        // конструктор для підключення до бази даних 
        public function __construct($db)
        {
            $this->conn = $db;
        }

        //метод для получення загального графіку відключення 
        public function read(){
            $query = "SELECT 
                w.name as weekday_name, s.group_id, s.weekday_id, s.time_id, s.status_id, 
                t.shutdown_time, t.power_time,
                
            FROM 
                ".$this->table_name." s
                LEFT JOIN
                    weekdays w
                        ON s.weekday_id = w.weekday_id
                LEFT JOIN
                    time t
                        ON s.time_id = t.time_id
            ";

              // подготовка запроса
                $stmt = $this->conn->prepare($query);

                // выполняем запрос
                $stmt->execute();
                return $stmt;
        }

        //метод для получення графіку відключення по групах
        private function readGroup(){

        }

        //метод для получення часу наступного відключення
        private function readNext(){

        }
    }

?>