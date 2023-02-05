<?php

    class ShutdownShedule{
        // підключення до бази даних і таблиці "shutdown_schedule"
        private $conn;
        private $table_name = "shutdown_schedule";
        private $table_prefix;
        public $group_id; 
        public $today; 
        public $to_weekday_id;
        public $region_id;

        // конструктор для підключення до бази даних 
        public function __construct($db, $config)
        {
            $this->conn = $db;
            $this->table_prefix = $config['prefix'] . "_";
            $this->table_name = $this->table_prefix . $this->table_name;
            
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
            $wher_wd ="";
            if($this->to_weekday_id){
                $wher_wd = "AND s.weekday_id  = :weekday_id";
            }
            $query = $this->getQuery();
            $query .=  "WHERE
                    s.group_id = :group_id AND
                    s.region_id  = :region_id
                    $wher_wd
                ORDER BY
                s.group_id ASC , s.weekday_id ASC";
            ;   
            // подготовка запроса
            $stmt = $this->conn->prepare($query);

            // выполняем запрос
            $stmt->execute($_GET); 
            return $stmt;
        }

        //метод для получення часу наступного відключення
        public function readNext(){
            $query = $this->getQuery();
            $query .=  "WHERE
                    s.group_id   = ? AND
                    s.region_id  = ? AND  
                    s.status_id IN (1,3) 
                ORDER BY
                   s.weekday_id ASC, t.shutdown_time ASC";
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

        private function getQuery(){
            $query = "SELECT 
            s.weekday_id, s.group_id, s.status_id, s.region_id, s.time_start, s.time_end,
            st.name as status_name,
            w.name as weekday_name,
            r.name as region_name
            FROM 
                ".$this->table_name." s
                LEFT JOIN
                    ".$this->table_prefix."weekdays w
                        ON s.weekday_id = w.weekday_id 
                LEFT JOIN
                ".$this->table_prefix."status st
                        ON s.status_id = st.status_id 
                LEFT JOIN
                ".$this->table_prefix."regions r
                        on s.region_id = r.region_id ";
            return $query;
        }
    }

?>