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
    public static function loadScanById($id):Scan {
        $sql = new Sql();
        $result = $sql->select("select * from scans where id = :ID",array(":ID"=>$id));
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