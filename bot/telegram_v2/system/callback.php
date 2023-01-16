<?php
    class Callback{ 
        
        public function __construct($result)
        {
            if (isset($result['callback_query'])) 
            {
                $callback = $result['callback_query'];
 
                $data = $this->callback_data($callback['data']);

                $this->route($data);
            }   
        }
        private function route($data)
        {
            switch ($data['name']) {
                case 'region':
                      Controller_group::create();
                    //View_start::send($result);   
                break; 
            }
        } 

        private function callback_data($string){
            $data = explode("_", $string);
            return [
                "name" => $data[0],
                "id" => $data[1]
            ];
        }
     
    }