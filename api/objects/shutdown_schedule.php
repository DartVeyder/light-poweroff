<?php

    class ShutdownShedule{
        // підключення до бази даних і таблиці "shutdown_schedule"
        private $conn;
        private $table_name = "shutdown_schedule";

        public $group_id; 
        public $today; 
        public $to_weekday_id;
        public $region_id;

        // конструктор для підключення до бази даних 
        public function __construct($db)
        {
            $this->conn = $db;
        }

        //метод для получення загального графіку відключення 
        public function read(){
            $query = $this->getQuery();
            $query .=  "ORDER BY
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
            $query = $this->getQuery();
            $query .=  "WHERE
                    s.group_id = ? AND
                    s.region_id  = ?
                ORDER BY
                s.group_id ASC , s.weekday_id ASC";
            ;
                    
            // подготовка запроса
            $stmt = $this->conn->prepare($query);

            // привязываем id товара, который будет получен
            $stmt->bindParam(1, $this->group_id);
            $stmt->bindParam(2, $this->region_id);

            // выполняем запрос
            $stmt->execute(); 
            return $stmt;
        }

        //метод для получення часу наступного відключення
        public function readNext(){
            $query = $this->getQuery();
            $query .=  "WHERE
                    s.group_id   = ? AND
                    s.region_id  = ? AND
                    s.weekday_id = ? AND
                    t.shutdown_time > ? AND
                    s.status_id IN (1,3)
                ORDER BY
                    s.group_id ASC , s.weekday_id ASC
                LIMIT 
                    0,2";
            ;
                    
            // подготовка запроса
            $stmt = $this->conn->prepare($query);

            // привязываем id товара, который будет получен
            $stmt->bindParam(1, $this->group_id);
            $stmt->bindParam(2, $this->region_id);
            $stmt->bindParam(3, $this->to_weekday_id);
            $stmt->bindParam(4, $this->today);
        
            
            // выполняем запрос
            $stmt->execute(); 
            return $stmt;
        }

        private function getQuery(){
            $query = "SELECT 
            s.weekday_id, s.group_id, s.time_id, s.status_id, s.region_id,
            st.name as status_name, 
            t.shutdown_time, t.power_time,
            gr.name as group_name,
            w.name as weekday_name,
            r.name as region_name
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
                LEFT JOIN
                    regions r
                        on s.region_id = r.region_id ";
            return $query;
        }
    }

?>