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
            $this->chat_id          = @$result["message"]["chat"]["id"];
            $this->username         = @$result["message"]["from"]["username"];
            $this->user_telegram_id = @$result["message"]["from"]["id"];
            $this->first_name       = @$result["message"]["from"]["first_name"];
            $this->last_name        = @$result["message"]["from"]["last_name"];
            $this->language_code    = @$result["message"]["from"]["language_code"];
        }

        public function getTextStart(){
            $reply = 'Привіт, цей бот буде вас попереджувати про відключення світла. Для початку виберіть свою область.';
            $this->getKeyBoardRegion($reply); 
        
            $data = [
                "username" => $this->username,
                "user_telegram_id" => $this->user_telegram_id,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "language_code" => $this->language_code,
                "telegram_chat_id" => $this->chat_id
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
                    "telegram_chat_id" => $this->chat_id
                ];
                $callback = explode("_", $data_callback);
                switch ($callback[0]) {
                    case 'region':
                        $data["region_id" ] = $callback[1];  
                        $reply = "Тепер виберіть вашу групу.";
                        $this->get($this->home_url_api . "/user/update.php?", $data);
                        $this->getKeyboardGroup($reply);
                    break; 
                    case 'group':
                        $data["group_id" ] = $callback[1]; 
                        $this->get($this->home_url_api . "/user/update.php?", $data);
                        $this->replyKeyboardShutdownShedule();
                        $this->getShutdownSchedule();
                    break;
                case 'weekday':
                    $this->getShutdownSchedule($callback[1]);
                    break;
                } 

               
            } 
        }

        public function getShutdownSchedule($weekday_id=""){
            $text = "";
            $text .= "Графік відключення на ";
            $today = date("d.m.Y");
            if(empty($weekday_id)){
                $weekday_id = date("N");
            } 
            if($weekday_id == date("N")){
                $text .= "сьогодні:\n$today ";
            }
            $response = $this->get($this->home_url_api . "/user/readOne.php?", ["user_telegram_id" =>  $this->user_telegram_id]);
            $result = json_decode($response,true);  

            $response  = $this->get($this->home_url_api . "/shutdown_schedule/read_group.php?", ["group_id" => $result['group_id'], "region_id" => $result['region_id'], "weekday_id" => $weekday_id ]);
            $result = json_decode($response,true); 
            $text .= $this->getGenerateView($result['records']);
            $reply_markup = $this->getKeyboardWeekdays($weekday_id);
            $this->telegram->sendMessage(
                [
                    'chat_id'       => $this->chat_id, 
                    'text'          => $text ,
                    'parse_mode'    => 'html',
                    'reply_markup' => $reply_markup
                ]
            );  
           
        }

        private function getKeyboardWeekdays($weekday_id){
            $response = $this->get($this->home_url_api . "/weekday/read.php");   
            $weekdays = json_decode($response, true);  
            
            $k = 0;
            foreach ($weekdays['records'] as $weekday) {
                if($weekday_id == $weekday['weekday_id']){
                    $to_wd = "✅";
                }
                else if(date("N") == $weekday['weekday_id']){
                    $to_wd = "✔️";
                }
                else {
                    $to_wd = "";
                }
                
                $row =  ['text' => $weekday['weekday_short_name']." $to_wd", 'callback_data' => 'weekday_' . $weekday['weekday_id'] ];
               if($weekday['weekday_id'] > 3){
                $row_2[] = $row ;
               }else{
                $row_1[] = $row;
               }
            }
            $menu[] = $row_1;
            $menu[] = $row_2;

            $reply_markup = $this->telegram->replyKeyboardMarkup(
                [
                    'inline_keyboard' => $menu,
                    'resize_keyboard' => true
                ]
            );

            return $reply_markup;
        }

        private function getGenerateView($data){
            $text = "";
            $text .= "({$data[0]["weekday_name"]}) \n{$data[0]["group_name"]} \n\n"; 
            foreach ($data as $item) { 
                $row_time = "$item[shutdown_time] -  $item[power_time] $item[status_name] ";

                if($item['now']){
                    $text .= "➤ <b>$row_time</b>\n";
                }else{
                    $text .= "     $row_time\n";
                }
            }
            return $text;
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

        private function replyKeyboardShutdownShedule(){
            $menu = [["Графік відключень"]];
            $reply = "Графік відключень";
            $reply_markup = $this->telegram->replyKeyboardMarkup([ 'keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
            $this->telegram->sendMessage(['chat_id' => $this->chat_id, 'text' => $reply, 'reply_markup' => $reply_markup]);
        }

        private function getKeyBoardRegion($reply){
            $response = $this->get($this->home_url_api . "/regions/read.php");   
            $regions_arr = json_decode($response, true);  
            foreach ($regions_arr['records'] as $key => $region) {
                $menu_regions[] = 
                [
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

        public function notification($telegram){
            $response_user = $this->get($this->home_url_api . "/user/read.php");  
            $data = json_decode($response_user, true);
            $item = $data['records'][0];
            
                
                    $response_schedule = $this->get($this->home_url_api . "/shutdown_schedule/read_next.php?group_id=$item[group_id]&region_id=$item[region_id]") ;
                    $data_schedule = json_decode($response_schedule , true); 
                    foreach ($data_schedule['records'] as $schedule ) {
            print_r($schedule['notification']);
                        if(in_array(date('H:i'), $schedule['notification'])) {
                            echo "Сповіщееня";
                        }else{
                            exit;
                          
                        }
                        $text = $schedule["date"] == date("Y-m-d") ? "Сьогодні \n" :  "Завтра \n";
                    
                        $text .= "<b>➤$schedule[shutdown_time] - $schedule[power_time]  $schedule[status_name] </b>\n";
                    }
                    
                    $telegram->sendMessage(
                        [
                            'chat_id'       => $item["user_telegram_id"], 
                            'text'          => $text ,
                            'parse_mode'    => 'html'
                        ]
                    );
                    echo $item['user_telegram_id'] . "<br>";
                 

                
               
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