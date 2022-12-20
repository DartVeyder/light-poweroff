<?php
    include_once "../../class/core.php";
    include('../../vendor/autoload.php');
    include('menu.php');
    use Telegram\Bot\Api;

    $telegram = new Api($config["bot"]["telegram"]["token"]);
    $result = $telegram->getWebhookUpdates();

    $text = $result["message"]["text"];
    $chta_id = $result["message"]["chat"]["id"];
    $name = $result["message"]["from"]["username"];
    $user_telegram_id = $result["message"]["from"]["id"];
    $first_name = $result["message"]["from"]["first_name"];
    $last_name = $result["message"]["from"]["last_name"];
     
    switch ($text) {
        case '/start':
            
            $reply = "Menu: ";
            $reply_markup = $telegram->replyKeyboardMarkup(
                [
                    'keyboard'          => $menu, 
                    'resize_keyboard'   => true, 
                    'one_time_keyboard' => false
                ]
            );
            $response = get($home_url_api . "/user/create.php?user_telegram_id=$user_telegram_id");
            $telegram->sendMessage(
                [
                    'chat_id'      => $chta_id, 
                    'text'         => $response, 
                    'reply_markup' => $reply_markup
                ]
            );
        
       
        break; 
        case 'Привіт':
            $reply = "Привіт: $first_name $last_name";
            $reply_markup = $telegram->replyKeyboardMarkup(
                [
                    'keyboard'          => $menu, 
                    'resize_keyboard'   => true, 
                    'one_time_keyboard' => false
                ]
            );
            $telegram->sendMessage(
                [
                    'chat_id'      => $chta_id, 
                    'text'         => $reply, 
                    'reply_markup' => $reply_markup
                ]
            );
        break; 
        case 'Кнопка 2':
            $reply = "Привіт: $first_name $last_name кнопка 2 " ;
            $reply_markup = $telegram->replyKeyboardMarkup(
                [
                    'keyboard'          => $menu, 
                    'resize_keyboard'   => true, 
                    'one_time_keyboard' => false
                ]
            );
            $telegram->sendMessage(
                [
                    'chat_id'      => $chta_id, 
                    'text'         => $reply, 
                    'reply_markup' => $reply_markup
                ]
            );
        break; 
    }
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
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94  Safari/537.36');
        
        Curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); $output = curl_exec($ch); if ( curl_errno($ch) ) return curl_error($ch);
        Curl_close($ch); 
        return $output;
    } 
?>