<?php
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
        $result = $sql->select("select * from hosts");
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
    
}

?>