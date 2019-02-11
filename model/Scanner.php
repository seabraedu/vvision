<?php

class Scanner {
    private $username;
    private $password;
    private $host;
    private $port;
    private $id;
    private $nome;
    
    //constructor
    public function __construct($username="",$password="",$host="",$port="",$id="",$nome=""){
        $this->username=$username;
        $this->password=$password;
        $this->port=$port;
        $this->host=$host;
        $this->id=$id;
        $this->nome=$nome;
        
    }
    
    

    public function getNome()
    {
        return $this->nome;
    }


    public function setNome($nome)
    {
        $this->nome = $nome;
        return  true;
    }

    //Getters and Setters
    public function getUsername(){
        return $this->username;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getHost(){
        return $this->host;
    }
    public function getPort(){
        return $this->port;
    }

    public function setUsername($username){
        if($this->validateScannerParameter($username)){
            $this->username = $username;
            return true;
        }return false;
    }
    public function setPassword($password){
        if($this->validateScannerParameter($password)){
            $this->password = $password;
            return true;
        }return false;
    }
    public function setHost($host){
        if($this->validateScannerParameter($host,'/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)|(\w+|\.|\-|\_)*)$/')){
            $this->host = $host;
            return true;
        }return false;
    }
    public function setPort($port){
        if($this->validateScannerParameter($port,'/^((6553[0-5])|(655[0-2][0-9])|(65[0-4][0-9]{2})|(6[0-4][0-9]{3})|([1-5][0-9]{4})|([0-5]{0,5})|([0-9]{1,4}))$/')){
            $this->port = $port;
            return true;
        }return false;
    }
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
    //Por default não são aceitos vazio e null
    private function validateScannerParameter($parameter,$regex="") {
            if(!isset($parameter) || $parameter == ""){
                return false;
            }elseif ($regex!=""){
                if(preg_match($regex,$parameter)){
                    return true;
                }
            }else{
                return true;
            }
    }
}
?>