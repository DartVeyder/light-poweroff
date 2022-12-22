<?php
    class Bot{
        private $chat_id;
        private $username;
        private $user_telegram_id;
        private $first_name;
        private $last_name;
        private $language_code; 

        public $telegram;
        public $home_url_api;

        public function __construct( $result)
        {
            $this->chat_id          = $result["message"]["chat"]["id"];
            $this->username         = $result["message"]["from"]["username"];
            $this->user_telegram_id = $result["message"]["from"]["id"];
            $this->first_name       = $result["message"]["from"]["first_name"];
            $this->last_name        = $result["message"]["from"]["last_name"];
            $this->language_code    = $result["message"]["from"]["language_code"];
        }

        public function getTextStart(){
            $reply = 'Привіт, цей бот буде вас попереджути про відключення світла. Для початку виберіть свою область.';
            $this->getKeyBoardRegion($reply); 
        
            $data = [
                "username" => $this->username,
                "user_telegram_id" => $this->user_telegram_id,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "language_code" => $this->language_code

            ];
            $this->get($this->home_url_api . "/user/create.php?", $data);
        } 
 
        public function callbackQuery( $result){
            if(isset($result['callback_query'])){
                $this->chat_id = $result['callback_query']['from']['id'];
                $this->user_telegram_id = $result["callback_query"]["from"]["id"];
                $data_callback = $result['callback_query']['data'];
                $data = [ 
                    "user_telegram_id" =>  $this->user_telegram_id,
                ];
                $callback = explode("_", $data_callback);
                switch ($callback[0]) {
                    case 'region':
                        $data["region_id" ] = $callback[1]; 
                        
                        $reply = "Тепер виберіть вашу групу.";
                        $this->getKeyboardGroup($reply);
                    break; 
                    case 'group':
                        $data["group_id" ] = $callback[1]; 
                        $this->getShutdownSchedule();
                    break;
                } 

                $this->get($this->home_url_api . "/user/update.php?", $data);
            } 
        }

        private function getShutdownSchedule(){
            $text = "Графік відключення";
            $this->telegram->sendMessage(
                [
                    'chat_id'       => $this->chat_id, 
                    'text'          => $text 
                ]
            );  
        }

        private function getKeyboardGroup($reply){
            $menu = [[
                ['text'=>'Група 1','callback_data'=>'group_1'],
                ['text'=>'Група 2','callback_data'=>'group_2'],
                ['text'=>'Група 3','callback_data'=>'group_3']
            ]];
            
            $reply_markup = $this->telegram->replyKeyboardMarkup(
                [
                    'inline_keyboard' => $menu,
                    'resize_keyboard' => true
                ]
            );
            $this->telegram->sendMessage(
                [
                    'chat_id'       => $this->chat_id, 
                    'text'          => $reply,
                    'reply_markup'  => $reply_markup 
                ]
            );  
        }   

        private function getKeyBoardRegion($reply){
            $response = $this->get($this->home_url_api . "/regions/read.php");   
            $regions_arr = json_decode($response, true);  
            foreach ($regions_arr['records'] as $key => $region) {
                $menu_regions[] = [
                    [
                        'text'          => $region['region_name'],
                        'callback_data' => 'region_' . $region['region_id']
                    ]
                ];
            } 

            $reply_markup = $this->telegram->replyKeyboardMarkup(
                [
                    'inline_keyboard' => $menu_regions,
                    'resize_keyboard' => true
                ]
            );
            $this->telegram->sendMessage(
                [
                    'chat_id'       => $this->chat_id, 
                    'text'          => $reply, 
                    'reply_markup'  => $reply_markup
                ]
            ); 
        }

        private function get($url = '',$data = [] , $cookie = ''){
            $url .= http_build_query($data);
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
            Curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94  Safari/537.36');          
            Curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); $output = curl_exec($ch); if ( curl_errno($ch) ) return curl_error($ch);
            Curl_close($ch); 
            return $output ;
        } 
    }
?>