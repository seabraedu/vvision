<?php

class Scanner {
    private $username;
    private $password;
    private $host;
    private $port;
    private $id;
    
    //constructor
    public function __construct($username="",$password="",$host="",$port="",$id=""){
        $this->username=$username;
        $this->password=$password;
        $this->port=$port;
        $this->host=$host;
        $this->id=$id;
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
        $this->username = $username;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function setHost($host){
        $this->host = $host;
    }
    public function setPort($port){
        $this->port = $port;
    }
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    
}
?>