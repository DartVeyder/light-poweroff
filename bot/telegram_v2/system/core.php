<?php
    use Telegram\Bot\Api;
    class Core{
 
     
	/**
	 * @return mixed
	 */
	public static function getTelegram() {
        $token = (DEV) ? TOKEN_DEV : TOKEN_PROD;
        
        $telegram = new Api($token);
         
		return $telegram;
	}

    public static function getTelegramResult()
    { 
        $array = [];
        $telegram = self::getTelegram();
        $result = $telegram->getWebhookUpdates();
        
        if (isset($result['callback_query'])) {
            $array['action'] = "callback";
            $message_id =   $result["callback_query"]["message"]["message_id"];
            $message_text =  $result["callback_query"]["message"]['text'];
            $message_buttons =$result["callback_query"]["message"]['reply_markup']['inline_keyboard']; 
          
            $text = $result['callback_query']['data'];
            $result = $result['callback_query']['from'];
           
        }else{
            $array['action'] = "message";
            $text = $result['message']['text'];

            $result =  $result["message"]["from"];
           
        }
        $array['data'] = [
            "user_id" => $result["id"],
            "chat_id" => $result["id"],
            "first_name" => $result["first_name"],
            "last_name" => $result["last_name"],
            "username" => $result["username"],
            "language_code" => $result["language_code"],
            "text" => $text
        ];

        if($message_id){
            $array['data']['message_id'] = $message_id;
        }

        if($message_text){
            $array['data']['message_text'] = $message_text;
        }

        if($message_buttons) {
            $array['data']['message_buttons'] = $message_buttons;
        }
        return $array;
    }

    public static function log($text, $file_name, $mode, $type_file = 'txt'){ 
        $file = "../logs/$file_name.$type_file"; 
        $fOpen = fopen($file, $mode);
        if ( $fOpen ){          
            fwrite($fOpen, $text."\r");
            fclose($fOpen);
        } else {
            return 'Wrong open log-file.';
        }
            
    }

    public static function get($url = '',$data = [] , $type = true, $cookie = ''){
        $url = URL_API . $url;
        $url .= "?".http_build_query($data);
            $ch = curl_init();
            Curl_setopt($ch, CURLOPT_URL, $url);
            Curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Retrieve the information obtained by curl_exec() as a file stream instead of directly.
            Curl_setopt($ch, CURLOPT_HEADER, 0);
            Curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Check the source of the certificate
            Curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Check if the SSL encryption algorithm exists from the certificate
            Curl_setopt($ch, CURLOPT_SSLVERSION,  CURL_SSLVERSION_TLSv1);//Set the SSL protocol version number
            curl_setopt($ch, CURLINFO_HEADER_OUT,true);
            If($cookie){
                Curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
                Curl_setopt ($ch, CURLOPT_REFERER, 'https://wx.qq.com');
            }
            Curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94  Safari/537.36');          
            Curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
            $output = curl_exec($ch); 
            if ( curl_errno($ch) ) return curl_error($ch);
            $info = curl_getinfo($ch);
            Curl_close($ch);

            if( $type){
                return json_decode($output, true);
            }else{
                return $output;
            } 

    } 
}