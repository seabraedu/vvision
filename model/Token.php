<?php
class Token {
    private $token;
    private $lastLogin;
    private $timeNewSession;
    
    public function getToken($scanner){
        if(!isset($this->token)){
            $this->createNewToken($scanner);
        }elseif ($this->timeNewSession<=$this->lastLogin) {
            $this->createNewToken($scanner);
        }
        return $this->token;
    }
    private function createNewToken($scanner){
        $result=Integration::createSession($scanner);
        $this->token = $result['token'];
        $response = Integration::getSession($this->token, $scanner);
        $this->lastLogin = $response['lastlogin'];
        $this->timeNewSession = $this->lastLogin+1500;
    }
    public function __toString() {
        return $this->token;
    }

    
}