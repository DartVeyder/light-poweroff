<?php
    class Model_group
    {
        public static function index($data)
        {
            $region = Core::cUrl("/regions/readOne.php?", $data);
            Helper::send($region);
            $data = [
                [
                    "group_id" => 1,
                    "group_name" => "Група 1"
                ],
                [
                    "group_id" => 2,
                    "group_name" => "Група 2"
                ],
                [
                    "group_id" => 3,
                    "group_name" => "Група 3"
                ]
            ];
            $menu = [];
            foreach ($data as $item)
            {
                $menu[] = [
                    'name' => $item['group_name'],
                    'id' => $item['group_id']
                ];
            }
            return $menu; 
        }
        public static function notAvailable1($data){
            Core::cUrl("/regions/readOne.php?", $data);   
        }
 
    }