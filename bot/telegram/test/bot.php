<?php
    class Bot{
        private $chat_id;
        private $username;
        private $user_telegram_id;
        private $first_name;
        private $last_name;
        private $language_code;
        private $message_id;

        public $telegram;
        public $home_url_api;
        public $config;

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
            $reply = 'Привіт, '. $this->first_name.'! Цей бот буде вас попереджувати про відключення світла. Для початку виберіть свою область.';
            $this->getKeyBoardRegion($reply); 
        
            $data = [
                "username" => $this->username,
                "user_telegram_id" => $this->user_telegram_id,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "language_code" => $this->language_code,
                "telegram_chat_id" => $this->chat_id
            ];
            $response = $this->get($this->home_url_api . "/user/create.php?", $data);
            $result = json_decode($response, 1);
            $this->notificationAdmin("create_user", $result);
            
        } 
 
        public function callbackQuery( $result){
             
            

            if(isset($result['callback_query'])){
                $this->chat_id = $result['callback_query']['from']['id'];
                $this->user_telegram_id = $result["callback_query"]["from"]["id"];
                $this->message_id = $result["callback_query"]["message"]["message_id"];
                $data_callback = $result['callback_query']['data'];
                $data = [ 
                    "user_telegram_id" =>  $this->user_telegram_id,
                    "telegram_chat_id" => $this->chat_id
                ];
                $callback = explode("_", $data_callback);

                $name   = $callback[0];
                $id     = $callback[1];
                $active = $callback[2];

                $this->log(date("Y-m-d H:i:s"). " ".$callback[0]. " ".$callback[1], "callbackQuery", "a+" , 'txt');
                switch ($callback[0]) {
                case 'region':
                        $this->selectRegion($callback);
                    break; 
                    case 'group':
                        $data["group_id" ] = $callback[1];
                        $data['notification'] = 1;
                        $this->get($this->home_url_api . "/user/update.php?", $data);
                        $this->replyKeyboardShutdownShedule();
                        $this->getShutdownSchedule();
                    break;
                    case 'weekday':
                        $this->getShutdownSchedule($callback[1],"inline_kb");   
                    break;
                    case 'settings':
                        $this->getKeyboardSettings('edit_message');
                    break;
                    case 'back-shutdownShedule':
                        $this->getShutdownSchedule('',"inline_kb");
                    break;
                    case 'edit-group':
                        $reply = "Виберіть вашу групу.";
                        $this->getKeyboardGroup($reply,'edit'); 
                    break;
                    case 'edit-region':
                        $reply = "Виберіть вашу область.";
                        $this->getKeyBoardRegion($reply); 
                    break;
                    case 'edit-notification':
                        $this->getKeyboardNotification();
                    break;
                    case 'notification': 
                        $data['notification'] = $callback[1];
                        $this->get($this->home_url_api . "/user/update.php?", $data);
                        $this->getKeyboardSettings('edit_message');
                    break;
                };  
                
            } 
        }

        private function selectRegion($callback){
            $id     = $callback[1];
            $active = $callback[2];
            $data["region_id" ] = $id;  

            if($active == 1){ 

                $reply = "Тепер виберіть вашу групу.";
                $this->get($this->home_url_api . "/user/update.php?", $data); 
                $this->getKeyboardGroup($reply, 'select');
            }else{
             $text = "   На жаль, графік по вашій області, поки, не доступний☹️ Не засмучуйтесь, бот постійно оновлюється і ми надішлемо вам сповіщення, як тільки графік по вашій області буде доступним)\n\n";
                $text .= "  Подивитись актуальний графік аварійних та планових відключень можна на сайті або у фейсбуці за посиланням нижче";
                
                $response = $this->get($this->home_url_api . "/regions/readOne.php?", $data);   
                $region_arr = json_decode($response, true); 
                if($region_arr['status'] == 'free'){
                    
                }
                $menu = [
                    [
                        ['text'=>'Оф. сайт','url' =>  $region_arr['site']],
                    ],
                    [
                        ['text'=>'Фейсбук','url' =>  $region_arr['facebook']],
                    ]
                ];
                $reply_markup = $this->telegram->replyKeyboardMarkup(
                    [
                        'inline_keyboard' => $menu,
                        'resize_keyboard' => true
                    ]
                );

                $this->telegram->sendMessage( 
                    [
                        'chat_id'       => $this->chat_id,  
                        'reply_markup' => $reply_markup,  
                        'text'          => $text, 
                        'parse_mode'    => 'html',
                    ]
                );  
            }
        }

        private function getKeyboardNotification(){ 
            $menu[] = [
                ['text' => "Включити ✅", 'callback_data' => 'notification_1'],
                ['text' => "Виключити ❌", 'callback_data' => 'notification_0'],
            ];
            $text = "<b>»»»СПОВІЩЕННЯ«««</b> \n\n";
            $reply_markup = $this->telegram->replyKeyboardMarkup(
                [
                    'inline_keyboard' => $menu,
                    'resize_keyboard' => true
                ]
            );
            $this->telegram->editMessageText(
                [
                    'chat_id'       => $this->chat_id,    
                    'message_id'    => $this->message_id,    
                    'text'          => $text,
                    'reply_markup'  => $reply_markup,
                    'parse_mode'    => 'html',
                ]
            );  
        }

        private function getKeyboardSettings($action){
            $text = "";
            $text .= "<b>»»»НАЛАШТУВАННЯ«««</b> \n\n";    
            
            $menu[] = [['text' => "Сповіщення", 'callback_data' => 'edit-notification']];
            $menu[] = [['text' => "« Назад до графіка відключень", 'callback_data' => 'back-shutdownShedule']];

            $response = $this->get($this->home_url_api . "/user/readOne.php?", ["user_telegram_id" =>  $this->user_telegram_id]);
            $result = json_decode($response,true);
            $text .= "<b>Група: </b>" .$result['group_id'] . "\n";
            $text .= "<b>Область: </b>" . $result['region_name'] . "\n";

            $notification = $result['notification'] ? "включено✅" : "виключено❌";
            $text .= "<b>Сповіщення: </b>" .  $notification . "\n";
            $reply_markup = $this->telegram->replyKeyboardMarkup(
                [
                    'inline_keyboard' => $menu,
                    'resize_keyboard' => true
                ]
            );
            if($action == 'edit_message'){
                $this->telegram->editMessageText(
                    [
                        'chat_id'       => $this->chat_id,   
                        'message_id'    => $this->message_id,    
                        'text'          => $text,
                        'reply_markup'  => $reply_markup,
                        'parse_mode'    => 'html',
                    ]
                );  
            }else{  
                $this->telegram->sendMessage(
                    [
                        'chat_id'       => $this->chat_id,    
                        'text'          => $text,
                        'reply_markup'  => $reply_markup,
                        'parse_mode'    => 'html',
                    ]
                );  
            }
            
        }

        public function getShutdownSchedule($weekday_id="", $type = ''){
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
            $this->get($this->home_url_api . "/user/update.php?", [ "user_telegram_id" =>  $this->user_telegram_id,]);
           
            $reply_markup = $this->getKeyboardWeekdays($weekday_id);

            if ($type) {
                $result = $this->telegram->editMessageText(
                    [
                        'chat_id'       => $this->chat_id,
                        'message_id'    => $this->message_id, 
                        'text'          => $text ,
                        'parse_mode'    => 'html',
                        'reply_markup' => $reply_markup
                    ]
                ); 
            }else{
                $result = $this->telegram->sendMessage(
                    [
                        'chat_id'       => $this->chat_id, 
                        'text'          => $text ,
                        'parse_mode'    => 'html',
                        'reply_markup' => $reply_markup
                    ]
                ); 
            }

            $this->log(json_encode($result,1), "getShutdownSchedule", "a+", 'json');
        }

        
        private function getKeyboardWeekdays($weekday_id){
            $response = $this->get($this->home_url_api . "/weekday/read.php");   
            $weekdays = json_decode($response, true);  
            
            foreach ($weekdays['records'] as $weekday) {
                if($weekday_id == $weekday['weekday_id']){
                    $to_wd = "✅";
                }
                else if(date("N") == $weekday['weekday_id']){
                    $to_wd = "☑️";
                }
                else {
                    $to_wd = "  ";
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
            $menu[] = [['text' => "Налаштування", 'callback_data' => 'settings']];
          

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

                if(@$item['now']){
                    $text .= "➤ <b>$row_time</b>\n";
                }else{
                    $text .= "     $row_time\n";
                }
            }
            return $text;
        }

        private function getKeyboardGroup($reply, $action){
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
            if($action == "edit"){
                $this->telegram->editMessageText(
                    [
                        'chat_id'       => $this->chat_id, 
                        'message_id'    => $this->message_id,
                        'text'          => $reply,
                        'reply_markup'  => $reply_markup 
                    ]
                );  
            }else{
                $this->telegram->sendMessage(
                    [
                        'chat_id'       => $this->chat_id, 
                        'text'          => $reply,
                        'reply_markup'  => $reply_markup 
                    ]
                );  
            }
            
        }   
        
        //Кнопка reply 
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
                $keyboards[] = [
                        'text' => $region['region_name'],
                        'callback_data' => 'region_' . $region['region_id'] . "_" . $region['active']
                ];
            } 
            $menu_regions =  array_chunk($keyboards, 2);
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
        public function message($telegram){
            $response_user = $this->get($this->home_url_api . "/user/read.php");  
            $users = json_decode($response_user, true);
            $text = 'Доброго вечора, кожному користувачу бота «Графік відключення світла». Вітаю вас з прийдешнім новим роком і з прийдешніми святами! Нехай Новий рік принесе багато радісних і щасливих днів! Бажаю, щоб в новому році здійснилися всі ваші мрії і бажання! Нехай дива трапляються частіше, ніж про них мріється! Нехай події будуть значними і красивими, а життя - благополучним і щасливим! А ще, побажаю те, чого ми найбільше чекаємо: нехай в наступному році вся русня здохне!
            ';
            foreach ($users['records'] as $key => $user) {
                try {
                    $status = "Відправлено";
                    $telegram->setAsyncRequest(true)->sendMessage(
                        [
                            'chat_id' => $user["user_telegram_id"],
                            'text' => $text,
                            'parse_mode' => 'html'
                        ]
                    );
                } catch (Exception $e) {
                    $status = 'Помилка: ' . $e->getMessage();
                }
            }
        }
        public function notification($telegram){
            $response_user = $this->get($this->home_url_api . "/user/read.php");  
            $users = json_decode($response_user, true);
            $message = [];
           
            $hour = date('H:i');

            $next_shutdown = [];
            $n = 0;
            foreach ( $users['records']as $key => $user) {
                $message[$user['user_id']]['user_id'] =  $user['user_id'];
                $message[$user['user_id']]['user_telegram_id'] = $user['user_telegram_id'];
                if($user['notification']){
                    $message[$user['user_id']]["notification_status"] = "Сповіщення включені";
                   
               

                    if(!@is_array($next_shutdown[@$user['region_id']][@$user['group_id']])){ 
                        $response_schedule = $this->get($this->home_url_api . "/shutdown_schedule/read_next.php?",["group_id" => $user["group_id"], "region_id"=>$user["region_id"]]) ;
                        $data_schedule = json_decode($response_schedule , true);
                    if (@$data_schedule['status'] != 'failed') {
                        $schedule = $data_schedule['records'][0];
                        $next_shutdown[$user['region_id']][$user['group_id']] = $schedule;
                    }
                    }else{
                         $schedule = $next_shutdown[$user['region_id']][$user['group_id']];
                    }
                    
                    $message[$user['user_id']]["notification"] = $schedule['notification'];
                    if (in_array($hour, $schedule['notification'])) {

                        $text = date("Y-m-d",strtotime($schedule["date"])) == date("Y-m-d") ? "Сьогодні " : "Завтра ";
    
                        $text .= "<b>➤$schedule[shutdown_time] - $schedule[power_time]  $schedule[status_name] </b>\n";
                        try {
                            $status = "Відправлено";
                            $telegram->sendMessage(
                                [
                                    'chat_id' => $user["user_telegram_id"],
                                    'text' => $text,
                                    'parse_mode' => 'html'
                                ]
                            );
                        } catch (Exception $e) {
                            $data = [
                                "user_telegram_id" => $user["user_telegram_id"],
                                "active" => 0
                            ];
                            $this->get($this->home_url_api . "/user/update.php?", $data);
                            $status = 'Помилка: ' . $e->getMessage();
                        }
                        
                        //echo $user['user_telegram_id'] . "<br>";
                        $message[$user['user_id']]["status_send"] = $status;
                        $text_log = date("Y-m-d H:i") . " [" . $schedule['shutdown_time'] . "] [" . $user["user_telegram_id"] . "] " ."[$status]";
                        $this->log( $text_log, "notifications", "a+", 'txt');
                    }else{
                        $status = "В очікувані";
                    }     
                $message[$user['user_id']]["hour"] = $hour;
                
                }else{
                $message[$user['user_id']]["notification_status"] = "Сповіщення відключені";
                }
 
                usleep(50000);
            }
        
        $this->log(json_encode($message,1), "notifications", "w+", 'json');
        return json_encode($message,1);
        }

        private function notificationAdmin($type, $result){
            $data = $result['data'];
            $info = [
                "success" => "Успішно",
                "failed" => "Помилка",
                "create" => "Добавився новий користувач",
                "update" => "Оновленя даних користувача"
            ];
            
            $text = date("Y-m-d H:i:s"). " " . $info[$result["action"]] . " $data[last_name] $data[first_name] [" . $info[$result["status"]]."]";
 
            $this->telegram->sendMessage(
                [
                    'chat_id' => $this->config['bot']['telegram']['admin_id'],
                    'text' => $text,
                    'parse_mode' => 'html'
                ]
            ); 
            $this->log($text, "notification_users", "a+" , 'txt');
        }

        private function log($text, $file_name, $mode, $type_file = 'txt'){ 
            $file = "logs/$file_name.$type_file"; 
            $fOpen = fopen($file, $mode);
            if ( $fOpen ){          
                fwrite($fOpen, $text."\r");
                fclose($fOpen);
            } else {
                return 'Wrong open log-file.';
            }
                
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

            $info = date("Y-m-d H:i:s")." [$info[http_code]] [$info[local_ip]] [$info[speed_download]] [$info[url]] ";
            $this->log($info, "response_log", "a+", 'txt');
            return $output ;
        } 
    }
?>