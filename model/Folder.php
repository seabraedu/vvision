<?php

class Folder {
    private $id;
    private $name;
    private $unread_count;
    private $scanner_id;
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getUnread_count(){
        return $this->unread_count;
    }
    public function getScanner_id(){
        return $this->scanner_id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setUnread_count($unread_count){
        $this->unread_count = $unread_count;
    }
    public function setScanner_id($scanner_id){
        $this->scanner_id = $scanner_id;
    }
    public function __construct($id,$scanner_id,$name="",$unread_count="") {
        $this->id = $id;
        $this->name = $name;
        $this->unread_count = $unread_count;
        $this->scanner_id = $scanner_id;
    }
}



?>