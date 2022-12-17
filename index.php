<?php
 
    require_once('libs/simple_html_dom.php');
    require_once('class/light-poweroff.php');
    require_once('class/region/poweroff-lviv.php');
    
    $search = [
        "otg" => "Трускавецька",
        "city" => "",
        "street" => "", 
    ];


    $poweroffLviv = new PoweroffLviv($search);
    header('Content-Type: application/json');
    print_r( $poweroffLviv->getParseHtml());



