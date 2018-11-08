<?php
class Scan {
    private $id;
    private $name;
    private $folder_id;
    private $creation_date;
    private $last_modification_date;
    private $status;
    private $owner;
    private $history_of;
    private $scanner_id;
 



    



    /*------------ Getters ------------*/
    public function getId(){
        return $this->id;}
    public function getName(){
        return $this->name;}
    public function getFolder_id(){
        return $this->folder_id;}
    public function getCreation_date(){
        return $this->creation_date;}
    public function getLast_modification_date(){
        return $this->last_modification_date;}
    public function getStatus(){
        return $this->status;}
    public function getOwner(){
        return $this->owner;}
    public function getHistory_of(){
        return $this->history_of;}
    public function getScanner_id(){
        return $this->scanner_id;}
    /*------------ Setters ------------*/
    public function setId($id){
        $this->id = $id;}
    public function setName($name){
        $this->name = $name;}
    public function setFolder_id($folder_id){
        $this->folder_id = $folder_id;}
    public function setCreation_date($creation_date){
        $this->creation_date = $creation_date;}
    public function setLast_modification_date($last_modification_date){
        $this->last_modification_date = $last_modification_date;}
    public function setStatus($status){
        $this->status = $status;}
    public function setOwner($owner){
        $this->owner = $owner;}
    public function setHistory_of($history_of){
        $this->history_of = $history_of;}
    public function setScanner_id($scanner_id){
        $this->scanner_id = $scanner_id;}


    public function __toString() {
        return "".$this->id.
             ",".$this->name.
             ",".$this->folder_id.
             ",".$this->creation_date.
             ",".$this->last_modification_date.
             ",".$this->status.
             ",".$this->owner;
             ",".$this->history_of;
        
    }
    /*
    public function __construct($id='',$name='',$folder_id='',$creation_date='',$last_modification_date='',$status,$owner='') {
        $this->id=$id;
        $this->name=$name;
        $this->folder_id=$folder_id;
        $this->creation_date=$creation_date;
        $this->last_modification_date=$last_modification_date;
        $this->status=$status;
        $this->owner=$owner;
        
    }
    */
}

?>