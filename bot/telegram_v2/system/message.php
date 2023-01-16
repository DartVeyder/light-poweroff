<?php
    class Message{
        
        public static function route($result)
        {
            switch ($result['data']['text']) {
                case '/start':
                    Controller_start::index($result['data']);
					 
                break; 
            }
        }
     
	  
}