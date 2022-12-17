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
                
                s.weekday_id, s.group_id, s.time_id, s.status_id, 
                st.name as status_name, 
                t.shutdown_time, t.power_time,
                gr.name as group_name,
                w.name as weekday_name
            FROM 
                ".$this->table_name." s
                LEFT JOIN
                    weekdays w
                        ON s.weekday_id = w.weekday_id
                LEFT JOIN
                    time t 
                        ON s.time_id = t.time_id
                LEFT JOIN
                    status st
                        ON s.status_id = st.status_id
                LEFT JOIN
                    cluster gr
                        on s.group_id = gr.group_id 
                ORDER BY
                s.group_id ASC , s.weekday_id ASC";
            ;
        
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