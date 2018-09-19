<?php
class Host {
    private $id;
    private $hostname;
    private $scan_id;
    private $severity;
    private $critical;
    private $medium;
    private $high;
    private $low;
    private $info;
    
    
    
    public function getSeverity(){
        return $this->severity;
    }

    public function getCritical(){
        return $this->critical;
    }

    public function getMedium(){
        return $this->medium;
    }

    public function getHigh(){
        return $this->high;
    }

    public function getLow(){
        return $this->low;
    }

    public function getInfo(){
        return $this->info;
    }

    public function setSeverity($severity){
        $this->severity = $severity;
    }

    public function setCritical($critical){
        $this->critical = $critical;
    }

    public function setMedium($medium){
        $this->medium = $medium;
    }

    public function setHigh($high){
        $this->high = $high;
    }

    public function setLow($low){
        $this->low = $low;
    }

    public function setInfo($info){
        $this->info = $info;
    }

    public function getId(){
        return $this->id;
    }
    public function getHostname(){
        return $this->hostname;
    }
    public function getScan_id(){
        return $this->scan_id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setHostname($name){
        $this->hostname = $name;
    }
    public function setScan_id($scan_id){
        $this->scan_id = $scan_id;
    }
    
}