<?php
    class User{
            // підключення до бази даних і таблиці "users"
            private $conn;
            private $table_name = "users";
    
            public $region_id;
            public $user_telegram_id;
            public $group_id;
    
            // конструктор для підключення до бази даних 
            public function __construct($db)
            {
                $this->conn = $db;
            }
            
            public function create(){
                $error = [];
                 // запрос для вставки (создания) записей
                    $query = "INSERT INTO
                    " . $this->table_name . "
                    (user_telegram_id, region_id, group_id)
                VALUES
                    (:user_telegram_id, :region_id, :group_id)";

                // подготовка запроса
                $stmt = $this->conn->prepare($query);
 
                // привязка значений
                $stmt->bindParam(":user_telegram_id", $this->user_telegram_id, PDO::PARAM_INT);
                $stmt->bindParam(":region_id", $this->region_id, PDO::PARAM_INT); 
                $stmt->bindParam(":group_id", $this->group_id, PDO::PARAM_INT);  

                // выполняем запрос
                try {
                    $stmt->execute();
                    return [
                        'status' => 'success',
                        "message" => "Користувач добавлений."
                    ];
                } catch (Exception $ex) {
                    $error = [
                        'response' => $ex->getMessage(),
                        'message' => 'Неможливо створити користувача',
                        'status' => 'failed'
                    ];

                    return $error;
                } 
            }

            public function update(){
                $error = [];
                 // запрос для вставки (создания) записей 
                    $query = "UPDATE
                    " . $this->table_name . "
                SET 
                    group_id  = :group_id,
                    region_id = :region_id 
                WHERE
                    user_telegram_id = :user_telegram_id";
                // подготовка запроса
                $stmt = $this->conn->prepare($query);
 
                // привязка значений
                $stmt->bindParam(":user_telegram_id", $this->user_telegram_id, PDO::PARAM_INT);
                $stmt->bindParam(":region_id", $this->region_id, PDO::PARAM_INT); 
                $stmt->bindParam(":group_id", $this->group_id, PDO::PARAM_INT);  
                
                // выполняем запрос
                try {
                    $stmt->execute(); 
                    if($stmt->rowCount()){
                        $error =  [
                            'status' => 'success',
                            "message" => "Дані користувача оновлено"
                        ];
                    }else{
                        $error =  [
                            'status' => 'failed',
                            "message" => "Користувача не знайдено. Дані не оновлено"
                        ];
                    }
                    return $error;
                } catch (Exception $ex) {
                    $error = [
                        'response' => $ex->getMessage(),
                        'message' => 'Неможливо оновити дані користувача',
                        'status' => 'failed'
                    ];

                    return $error;
                } 
            }

            public function read(){
                $query = "SELECT u.user_id, u.region_id, u.user_telegram_id, u.group_id, u.name,
                r.name as region_name,
                gr.name as group_name
            FROM 
                ".$this->table_name." u
            LEFT JOIN
                regions r
                    ON u.region_id = r.region_id
            LEFT JOIN
                cluster gr
                    on u.group_id = gr.group_id 
            ";
        
                // подготовка запроса
                $stmt = $this->conn->prepare($query);

                // выполняем запрос
                $stmt->execute();
                return $stmt;
            }

        }
    

?>