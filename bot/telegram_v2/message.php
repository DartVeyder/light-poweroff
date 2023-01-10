<?php
    class Message{
        public $text;
        
        public function __construct($result)
        {
            $text = $result["message"]["text"];
            $this->text = $text;

            $this->route($this->get_text());
        } 

        private function get_text()
        {
            return $this->text;
        }

        private function route($text)
        {
            switch ($text) {
                case '/text':
                     
                break; 
            }
        }
    }