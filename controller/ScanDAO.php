<?php
require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');


class ScanDAO {
    //Retorna lista de todos os scan cadastrados no banco.
    public static function listScans():array {
        $sql = new Sql();
        $result = $sql->select("select * from scans");
        $return_array=array();
        foreach ($result as $row){
            $scan = new Scan();
            $scan->setId($row['id']);
            $scan->setName($row['name']);
            $scan->setFolder_id($row['folder_id']);
            $scan->setCreation_date($row['creation_date']);
            $scan->setLast_modification_date($row['last_modification_date']);
            $scan->setStatus($row['status']);
            $scan->setOwner($row['owner']);
            $scan->setHistory_of($row['history_of']);
            $scan->setScanner_id($row['scanner_id']);
            array_push($return_array, $scan);
        }
        return $return_array;
    }
    //Retorna lista de todos os scan e vulnlerabilidade de seus hosts.
    public static function listScansHosts():array {
        $sql = new Sql();
        $result = $sql->select("select s.id,s.name,IFNULL(sum(h.critical),0) as critical,IFNULL(sum(h.medium),0) as medium,IFNULL(sum(h.high),0) as high,IFNULL(sum(h.low),0) as low ,IFNULL(sum(h.info),0) as info,from_unixtime(s.last_modification_date,('%d-%m-%Y %h:%i')) as last_modification_date, s.history_of from hosts h right join scans s on h.scan_id = s.id where s.last_modification_date in (select CAST(last_modification_date as UNSIGNED) from scans where history_of is NULL  ) and s.history_of is NULL group by s.name,s.last_modification_date,s.history_of,s.id");
        return $result;
    }
    
    //Retorna lista de todos os scan e quantitativo de vulnerabilidades encontradas de seus hosts, por folder monitorada
    public static function listScansHostsMonitored():array {
        $sql = new Sql();
        $result = $sql->select("select s.scanner_id,s.id,s.name,IFNULL(sum(h.critical),0) as critical,IFNULL(sum(h.medium),0) as medium,IFNULL(sum(h.high),0) as high,IFNULL(sum(h.low),0) as low ,IFNULL(sum(h.info),0) as info,from_unixtime(s.last_modification_date,('%d-%m-%Y %h:%i')) as last_modification_date, s.history_of from hosts h right join scans s on h.scan_id = s.id inner join folders f on f.id = s.folder_id where s.last_modification_date in (select CAST(last_modification_date as UNSIGNED) from scans where history_of is NULL  ) and s.history_of is  NULL and f.monitored = 'yes' and s.scanner_id = f.scanner_id group by s.name,s.last_modification_date,s.history_of,s.id");
        return $result;
    }
    public static function getScanHistory($id,$scanner_id):array {
        $sql = new Sql();
        $result = $sql->select("select s.scanner_id,s.id,s.name,IFNULL(sum(h.critical),0) as critical,IFNULL(sum(h.medium),0) as medium,IFNULL(sum(h.high),0) as high,IFNULL(sum(h.low),0) as low ,IFNULL(sum(h.info),0) as info,from_unixtime(s.last_modification_date,('%d/%m/%y')) as last_modification_date, s.history_of from hosts h right join scans s on h.scan_id = s.id inner join folders f on f.id = s.folder_id where s.history_of = :ID  and s.scanner_id = :SCANNER_ID and f.monitored = 'yes' and f.scanner_id =s.scanner_id group by s.name,s.last_modification_date,s.history_of,s.id;",
                               array(
                                   ":ID"=>$id,
                                   ":SCANNER_ID"=>$scanner_id
                               ));
        return $result;
    }
    
    public static function checkScanHistory($id,$scanner_id):bool {
        $sql = new Sql();
        $result = $sql->select("select count(id) as scan from scans where id = :ID and scanner_id = :SCANNER_ID",array(
                ":ID"=>$id,
                ":SCANNER_ID"=>$scanner_id));
        if (isset($result[0])&&($result[0]['scan']!=0)){
            return false;
        }else return true;
    }
    
    
    
    
    
    //Insere um novo scan no banco de dados
    public static function insertScan($scan) {
        $sql = new Sql(); 
        $sql->query("insert into scans (id,name,folder_id,creation_date,last_modification_date,status,owner,history_of,scanner_id) values ( :ID , :NAME , :FOLDER_ID , :CREATION_DATE , :LAST_MODIFICATION_DATE , :STATUS, :OWNER,:HISTORY,:SCANNER_ID )",
            array(
                ":ID"=>$scan->getId(),
                ":NAME"=>$scan->getName(),
                ":FOLDER_ID"=>$scan->getFolder_id(),
                ":CREATION_DATE"=>$scan->getCreation_date(),
                ":LAST_MODIFICATION_DATE"=>$scan->getLast_modification_date(),
                ":STATUS"=>$scan->getStatus(),
                ":OWNER"=>$scan->getOwner(),
                ":HISTORY"=>$scan->getHistory_of(),
                ":SCANNER_ID"=>$scan->getScanner_id()
        ));
    }
    //Retorna um scan a partir de um ID
    public static function loadScanById($id,$scanner):Scan {
        $sql = new Sql();
        $result = $sql->select("select * from scans where id = :ID and scanner_id = :SCANNER_ID",
            array(":ID"=>$id,
                  ":SCANNER_ID"=>$scanner
                  
        ));
        if (isset($result[0])){
            $row=$result[0];
            $scan = new Scan();
            $scan->setId($row['id']);
            $scan->setName($row['name']);
            $scan->setFolder_id($row['folder_id']);
            $scan->setCreation_date($row['creation_date']);
            $scan->setLast_modification_date($row['last_modification_date']);
            $scan->setStatus($row['status']);
            $scan->setOwner($row['owner']);
            $scan->setHistory_of($row['history_of']);
            $scan->setScanner_id($row['scanner_id']);
            return $scan;
        }else echo "Não foi encontrado scanner com o ID fornecido";
        
    }
    //Deleta um scan da base de dados
    public static function deleteScan($scan) {
        $sql = new Sql();
        $sql->select("delete from scans where id = :ID and folder_id = :FOLDER_ID",array(":ID"=>$scan->getId(),":FOLDER_ID"=>$scan->getFolder_id()));
    }
    //Atualiza os dados de um scan no banco de dados.
    public static function updateScanFromId($scan) {
        $sql = new Sql();
        $sql->query("update scans set  name = :NAME, folder_id = :FOLDER_ID , creation_date = :CREATION_DATE , last_modification_date = :LAST_MODIFICATION_DATE , status = :STATUS, owner = :OWNER, history_of = :HISTORY, scanner_id = :SCANNER_ID where id = :ID )",
            array(
                ":ID"=>$scan->getId(),
                ":NAME"=>$scan->getName(),
                ":FOLDER_ID"=>$scan->getFolder_id(),
                ":CREATION_DATE"=>$scan->getCreation_date(),
                ":LAST_MODIFICATION_DATE"=>$scan->getLast_modification_date(),
                ":STATUS"=>$scan->getStatus(),
                ":OWNER"=>$scan->getOwner(),
                ":HISTORY"=>$scan->getHistory_of(),
                ":SCANNER_ID"=>$scan->getScanner_id()
            ));
    }
    public static function insertScanFromArray($scanArray) {
        if (count($scanArray)>0) {
            foreach ($scanArray as $scan) {
                $sql = new Sql();
                $sql->query("insert into scans (id,name,folder_id,creation_date,last_modification_date,status,owner,history_of,scanner_id) values ( :ID , :NAME , :FOLDER_ID , :CREATION_DATE , :LAST_MODIFICATION_DATE , :STATUS, :OWNER, :HISTORY_OF,:SCANNER_ID )",
                    array(
                        ":ID"=>$scan->getId(),
                        ":NAME"=>$scan->getName(),
                        ":FOLDER_ID"=>$scan->getFolder_id(),
                        ":CREATION_DATE"=>$scan->getCreation_date(),
                        ":LAST_MODIFICATION_DATE"=>$scan->getLast_modification_date(),
                        ":STATUS"=>$scan->getStatus(),
                        ":OWNER"=>$scan->getOwner(),
                        ":HISTORY_OF"=>$scan->getHistory_of(),
                        ":SCANNER_ID"=>$scan->getScanner_id()
                    ));
            }
        }
    }
    
    
}



?>