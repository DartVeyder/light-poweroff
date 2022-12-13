<?php

    class PoweroffLviv extends LightPoweroff{
        private $url = "https://poweroff.loe.lviv.ua/";
        private $utc;
        private $city;
        private $street;

        public function __construct()
        {
            $this->getUtc();
        }

        private function getUtc(){
            $utc = "Трускавецька";
            //$utc ="";
            $this->utc = urlencode($utc);
        }

        private function getUrlParse(){

            $url =$this->url . "search_off?city=&street=&otg=$this->utc&q=%D0%9F%D0%BE%D1%88%D1%83%D0%BA";
            return $url;
        }

        private function getHtml(){
            return $this->getParseUrlHtml($this->getUrlParse());
        }

        public function getParseHtml(){
            $html = $this->getHtml(); 
            $array= [];
            $table = $html->find('table[style="background-color: white;"] tbody');
            foreach($table as $tbody){
                $tr = $tbody->find('tr',0);
                $array[] = $this->setArrayList($tr); 

            }
            $array = $this->setArray($array);

            return $array;
        } 

        private function setArrayList($html){
            $array = []; 
            $array['region'] = $html->find('th',0)->plaintext;
            $array['utc'] = $html->find('td',0)->plaintext;
            $array['city'] = mb_strtoupper($html->find('td',1)->plaintext);
            $array['street'] = $html->find('td',2)->plaintext;
            $array['house'] = $html->find('td',3)->plaintext;
            $array['shutdown_time'] = $html->find('td',6)->plaintext;
            $array['power_time'] = $html->find('td',7)->plaintext;

            return $array;
        }
        
    }

?>