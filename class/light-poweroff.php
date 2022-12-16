<?php

class LightPoweroff{

    public function __construct()
    { 
        
    }


    private function get($url = '', $cookie = ''){
        $ch = curl_init();
        Curl_setopt($ch, CURLOPT_URL, $url);
        Curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Retrieve the information obtained by curl_exec() as a file stream instead of directly.
        
        Curl_setopt($ch, CURLOPT_HEADER, 0);
        Curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Check the source of the certificate
        Curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Check if the SSL encryption algorithm exists from the certificate
        Curl_setopt($ch, CURLOPT_SSLVERSION,  CURL_SSLVERSION_TLSv1);//Set the SSL protocol version number

        If($cookie){
            Curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
            Curl_setopt ($ch, CURLOPT_REFERER, 'https://wx.qq.com');
        }
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94  Safari/537.36');
        
        Curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); $output = curl_exec($ch); if ( curl_errno($ch) ) return curl_error($ch);
        Curl_close($ch); 
        return $output;
    } 

    protected function getParseUrlHtml($url){    
        $html = new simple_html_dom();      
        return $html->load($this->get($url));
    }

    private function setArrayRegion($data){
        $array = [];  
        $array =  array_values(array_unique(array_column($data, "region")));
        return $array;

    }

    private function setArrayCity($data){
        $array = [];
        $array = array_values(array_unique(array_column($data, "city")));

        return $array;
    }

    private function setArrayOtg($data){
        $array = [];
        $array = array_values(array_unique(array_column($data, "otg")));
        return $array;
    }
 
    protected function setArray($data){
        $array = [];
        $array['region'] = $this->setArrayRegion($data);
        $array['city']   = $this->setArrayCity($data);
        $array['otg']    = $this->setArrayOtg($data);
        $array['list'] = $data;
        return $array;
    }

    protected function viewJson(){

    }


}