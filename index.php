<?php
    include('libs/simple_html_dom.php');
    $url = "https://poweroff.loe.lviv.ua/search_off?city=&street=&otg=&q=%D0%9F%D0%BE%D1%88%D1%83%D0%BA";

    function get($url = '', $cookie = ''){
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
        Curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        Curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); $output = curl_exec($ch); if ( curl_errno($ch) ) return curl_error($ch);
        Curl_close($ch); 
        return $output;
    } 

    $html = new simple_html_dom();
    $html->load(get($url));

    $table = $html->find('table[style="background-color: white;"]');
    foreach($table as $tbody){
        echo $tbody;
    }

