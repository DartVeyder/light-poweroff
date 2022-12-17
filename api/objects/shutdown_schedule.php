<?php

    class ShutdownShedule{
        // підключення до бази даних і таблиці "shutdown_schedule"
        private $conn;
        private $table_name = "shutdown_schedule";

        public $group_id;
        public $weekday_id;
        public $time_id;
        public $status_id;
        public $group_name;
        public $weekday_name;
        public $shutdown_time;
        public $power_time;
        public $status_name;

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
        public function readGroup(){
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
                WHERE
                    s.group_id = ?
                ORDER BY
                s.group_id ASC , s.weekday_id ASC";
            ;
                    
            // подготовка запроса
            $stmt = $this->conn->prepare($query);

            // привязываем id товара, который будет получен
            $stmt->bindParam(1, $this->group_id);

            // выполняем запрос
            $stmt->execute(); 
            return $stmt;
        }

        //метод для получення часу наступного відключення
        private function readNext(){

        }
    }

?>