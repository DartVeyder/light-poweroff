<?php
    error_reporting(0);

    include_once "../../class/core.php";
    include('bot.php');
    include('../../vendor/autoload.php');
    include('menu.php');
    use Telegram\Bot\Api;

    $telegram = new Api($config["bot"]["telegram"]["token"]);
    $result = $telegram->getWebhookUpdates();

    $bot = new Bot($result); 
    
    $text = $result["message"]["text"];
    $chat_id = $result["message"]["chat"]["id"];
    $username = $result["message"]["from"]["username"];
    $user_telegram_id = $result["message"]["from"]["id"];
    $first_name = $result["message"]["from"]["first_name"];
    $last_name = $result["message"]["from"]["last_name"];
    $language_code = $result["message"]["from"]["language_code"];
    
    switch ($text) {
        case '/start':
        $reply = 'Привіт, цей бот буде вас попереджути про відключення світла. Для початку виберіть свою область?';
        $response = get($home_url_api . "/regions/read.php");   
        $regions_arr = json_decode($response, true);  
        foreach ($regions_arr['records'] as $key => $region) {
            $menu_regions[] = [
                [
                    'text' => $region['region_name'],
                    'callback_data' => 'region_' . $region['region_id']
                ]
            ];
        } 
 
        $reply_markup = $telegram->replyKeyboardMarkup(
            [
                'inline_keyboard' => $menu_regions,
                'resize_keyboard' => true
            ]
        );
        $telegram->sendMessage(
            [
                'chat_id'=>$chat_id, 
                'text'=>$reply, 
                'reply_markup' => $reply_markup
            ]
        ); 
        
            $data = [
                "username" => $username,
                "user_telegram_id" => $user_telegram_id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "language_code" => $language_code

            ];
            //$response = get($home_url_api . "/user/create.php?", $data);

        break;  
    }

    if(isset($result['callback_query'])){
        $chat_id = $result['callback_query']['from']['id'];
        switch($result['callback_query']['data']){
            case 'p1':
                $reply = "Ви вибрали Львівську область";
                $reply_markup = $telegram->replyKeyboardMarkup(
                    [
                        'keyboard'          => $menu, 
                        'resize_keyboard'   => true, 
                        'one_time_keyboard' => false
                    ]
                );
                $telegram->sendMessage(
                    [
                        'chat_id'      => $chat_id, 
                        'text'         => $reply, 
                        'reply_markup' => $reply_markup
                    ]
                );
                break;
            case 'p2':
                /* действия */
                break;
        }
    }
    function get($url = '',$data = [] , $cookie = ''){
        if($data){
            $url .= http_build_query($data);
        }    
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