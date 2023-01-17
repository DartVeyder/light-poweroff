<?php
    class Model_group
    {
        public static function index($array)
        {
            $data  = [];
            $region = Core::cUrl("/regions/readOne.php?", $array);
            if($region['active']){
                for ($i = 1; $i <= $region['number_groups'] ; $i++) { 
                    $buttons_group[] = [
                        'text' => "Група $i",
                        'callback_data' => "group_$i"
                    ];
                } 
                $data['language'] = "title_create_group";
            }else{

            }
            $data['buttons_group'] = $buttons_group;
            return $data; 
        } 
 
    }