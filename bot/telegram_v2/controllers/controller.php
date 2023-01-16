<?php
class Controller
{
    protected static $chat_id;
    protected static $user_id;
    protected static $message_id;
    protected static $first_name;
    protected static $last_name;

    public static function init()
    {
        $result_telegram = Core::getTelegramResult();
        self::setChat_id(11111); 


    }
	
    /**
	 * @return mixed
	 */
	public static function getChat_id(){
		return self::$chat_id;
	}
	
	/**
	 * @param mixed $chat_id 
	 * @return self
	 */
	public static function setChat_id($chat_id){
		self::$chat_id = $chat_id;
		return self::$chat_id;
	}

	/**
	 * @return mixed
	 */
	public function getMessage_id() {
		return $this->message_id;
	}
	
	/**
	 * @param mixed $message_id 
	 * @return self
	 */
	public function setMessage_id($message_id): self {
		$this->message_id = $message_id;
		return $this;
	}
 
	/**
	 * @return mixed
	 */
	public function getUser_id() {
		return $this->user_id;
	}
	
	/**
	 * @param mixed $user_id 
	 * @return self
	 */
	public function setUser_id($user_id): self {
		$this->user_id = $user_id;
		return $this;
	}
}