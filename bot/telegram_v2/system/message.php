<?php
    class Message{
        public $text;
        private $telegram;
        private $result;
        
        public function __construct($telegram)
        {
            $this->setTelegram($telegram);

            $result = $telegram->getWebhookUpdates();
            $this->setResult($result);

            $text = $result["message"]["text"];
            $this->text = $text;
           

            $this->route($this->get_text());
        } 

        private function get_text()
        {
            return $this->text;
        }

        private function route($text)
        {
            switch ($text) {
                case '/start':
                    $result = Controller_start::send($this->getResult());
					View_start::send($result);  
                break; 
            }
        }
    
	/**
	 * @param mixed $telegram 
	 * @return self
	 */
	public function setTelegram($telegram): self {
		$this->telegram = $telegram;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTelegram() {
		return $this->telegram;
	}

	/**
	 * @return mixed
	 */
	public function getResult() {
		return $this->result;
	}
	
	/**
	 * @param mixed $result 
	 * @return self
	 */
	public function setResult($result): self {
		$this->result = $result;
		return $this;
	}
}