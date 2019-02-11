<?php

require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

class HostDAO {
    public static function insert(Host $host) {
        $sql = new Sql();
        $sql->query("insert into hosts (id, hostname, scan_id,severity,critical,medium,high,low,info) values (:ID,:HOSTNAME,:SCAN_ID,:SEVERITY,:CRITICAL,:MEDIUM,:HIGH,:LOW,:INFO)",array(
            ":ID"=>$host->getId(),
            ":HOSTNAME"=>$host->getHostname(),
            ":SCAN_ID"=>$host->getScan_id(),
            ":SEVERITY"=>$host->getSeverity(),
            ":CRITICAL"=>$host->getCritical(),
            ":MEDIUM"=>$host->getMedium(),
            ":HIGH"=>$host->getHigh(),
            ":LOW"=>$host->getLow(),
            ":INFO"=>$host->getInfo(),
        ));    
    }
    public static function insertArray($hostArray) {
        $sql = new Sql();
        if(count($hostArray)>0){
            foreach ($hostArray as $host) {
                $sql->query("insert into hosts (id, hostname, scan_id,severity,critical,medium,high,low,info) values (:ID,:HOSTNAME,:SCAN_ID,:SEVERITY,:CRITICAL,:MEDIUM,:HIGH,:LOW,:INFO)",array(
                    ":ID"=>$host->getId(),
                    ":HOSTNAME"=>$host->getHostname(),
                    ":SCAN_ID"=>$host->getScan_id(),
                    ":SEVERITY"=>$host->getSeverity(),
                    ":CRITICAL"=>$host->getCritical(),
                    ":MEDIUM"=>$host->getMedium(),
                    ":HIGH"=>$host->getHigh(),
                    ":LOW"=>$host->getLow(),
                    ":INFO"=>$host->getInfo(),
                )); 
            }
        }else{
        //Criar log de erro.
        }
    }
    public static function delete(Host $host) {
        $sql = new Sql();
        $sql->query("delete from hosts where id = :ID",array(
            ":ID"=>$host->getId()
        ));
    }
    public static function loadHostById(Scan $scan,$id):Host {
        $sql = new Sql();
        $result = $sql->select("select * from hosts where id = :ID and scan_id = :SCAN_ID",array(":ID"=>$id,":SCAN_ID"=>$scan->getId()));
        if (isset($result[0])){
            $row=$result[0];
            $host = new Host();
            $host->setId($row['id']);
            $host->setHostname($row['hostname']);
            $host->setScan_id($scan->getId());
            $host->setSeverity($row['severity']);
            $host->setCritical($row['critical']);
            $host->setHigh($row['high']);
            $host->setMedium($row['medium']);
            $host->setLow($row['low']);
            $host->setInfo($row['info']);
            return $host;
        }else echo "Não foi encontrado scanner com o ID fornecido";
        
    }
    public static function listHosts(Scan $scan):array {
        $sql = new Sql();
        $result = $sql->select("select * from hosts ");
        $return_array=array();
        foreach ($result as $row){
            $host = new Host();
            $host->setId($row['id']);
            $host->setHostname($row['hostname']);
            $host->setScan_id($scan->getId());
            $host->setSeverity($row['severity']);
            $host->setCritical($row['critical']);
            $host->setHigh($row['high']);
            $host->setMedium($row['medium']);
            $host->setLow($row['low']);
            $host->setInfo($row['info']);
            array_push($return_array, $host);
        }
        return $return_array;
    }
    public static function listHostsFromScan(Scan $scan):array {
        $sql = new Sql();
        $result = $sql->select("select * from hosts where scan_id = :SCAN_ID",array(":SCAN_ID"=>$scan->getId()));
        $return_array=array();
        foreach ($result as $row){
            $host = new Host();
            $host->setId($row['id']);
            $host->setHostname($row['hostname']);
            $host->setScan_id($scan->getId());
            $host->setSeverity($row['severity']);
            $host->setCritical($row['critical']);
            $host->setHigh($row['high']);
            $host->setMedium($row['medium']);
            $host->setLow($row['low']);
            $host->setInfo($row['info']);
            array_push($return_array, $host);
        }
        return $return_array;
    }
    public static function getHostHistory($hostname):array {
        
        if(preg_match("/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)|(\w+|\.|\-|\_)*)$/",$hostname)){
            return true;
        }
        else{
            $sql = new Sql();
            $result = $sql->select("select h.*,from_unixtime(s.last_modification_date,('%d-%m-%y')) as last_modification_date from hosts h inner join scans s on h.scan_id = s.id where h.hostname = :HOSTNAME order by s.last_modification_date asc; ",array(":HOSTNAME"=>$hostname));
            return $result;
        }
        
    }
    public static function getHostVulnerabilities($hostname):array {
        $sql = new Sql();
        $result = $sql->select("select h.hostname,s.id,v.scan_id,h.scan_id, v.name, v.severity from hosts h inner join scans s on h.scan_id = s.id inner join vulnerability v on v.host_id=h.id where v.scan_id=s.id and h.hostname = :HOSTNAME and s.last_modification_date = (select max(s.last_modification_date) from hosts h inner join scans s on h.scan_id = s.id inner join vulnerability v on v.host_id = h.id where h.hostname = :HOSTNAME and v.scan_id=s.id ) order by v.severity desc; ",array(":HOSTNAME"=>$hostname));
        return $result;
    }
    
}

?>