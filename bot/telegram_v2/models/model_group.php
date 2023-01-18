<?php
    class Model_group
    {
        public static function index($id)
        {
            $data  = [];
            $text = Service_text::get_message_text();
            $region = Core::cUrl("/regions/readOne.php?", ['region_id' => $id]);

            if($region['active']){
                for ($i = 1; $i <= $region['number_groups'] ; $i++) { 
                    $buttons_group[] = [
                        'text' => "Група $i",
                        'callback_data' => "group_$i"
                    ];
                }   

             
                $button_back = Service_buttons::back($text['button_back_text'], 'back_start');
                
 
                $data = [
                    'text' =>  $text['title_create_group'],
                    'buttons_group' => $buttons_group,
                    'button_back' =>$button_back
                 ]; 
                
               
            }else{

            } 
            
            return $data; 
        } 
 
    }