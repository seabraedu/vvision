<?php
require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

class FolderDAO{
    //lista todas as pastas cadastradas no banco de dados.
    public static function listAllFoldersInDB(){
        $sql = new Sql();
        $sqlResult = $sql->select("select f.id as id,f.scanner_id as scanner_id, f.name as name, f.unread_count  from folders f inner join scanner s on f.scanner_id = s.id ;");
        $returnArrray = array();
        
        foreach ($sqlResult as $row){
            $folder = new Folder((int)$row['id'], $row['scanner_id'],$row['name'],$row['unread_count']);
            array_push($returnArrray, $folder);
        }
        return $returnArrray;
    }
    //carrega uma folder a partir de um ID
    public static function getFolderById($scanner,$id):Folder{
        $sql = new Sql();
        $result = $sql->select("select * from folders where scanner_id = :SCANNER_ID and id = :ID",array(":SCANNER_ID"=>$scanner->getId(),":ID"=>$id));
        if(isset($result[0])){
            $row =$result[0];
            return new Folder($row['id'],$row['scanner_id'],$row['name'],$row['unread_count']);
        }
    }
    //insere uma pasta no banco de dados
    public static function insertFolder($folder) {
        $sql = new Sql();
        $sql->query("insert into folders (id,name,unread_count,scanner_id) values ( :ID , :NAME , :UNREAD_COUNT , :SCANNER_ID )",array(
            ":ID"=>$folder->getId(),
            ":NAME"=>$folder->getName(),
            ":UNREAD_COUNT"=>$folder->getUnread_count(),
            ":SCANNER_ID"=>$folder->getScanner_id()
        ));
    }
    //deleta a pasta informada do bando de dados
    public static function deleteFolder($folder,$scanner) {
        $sql = new Sql();
        $sql->query("delete from folders where id = :ID and scanner_id = :SCANNER_ID",array(
            ":ID"=>$folder->getId(),
            ":SCANNER_ID"=>$folder->getScanner_id()
        ));
    }
    //Este metodo deve pegar todas as pastas do scanner e inserir no banco de dados
    public static function refreshFolderFromScanner($token,$scanner):array {
        $listedFolders = Integration::listFolders($token, $scanner);
        $foldersArray = array();
        foreach ($listedFolders['folders'] as $folders){
            $folder = new Folder((int)$folders['id'], $scanner->getId(),$folders['name'],$folders['unread_count']);
            array_push($foldersArray, $folder);
            FolderDAO::insertFolder($folder);
        }
        return $foldersArray;
    }
    
    public static function monitoredFolderUpdate($folderId,$scannerId,$value) {
        $sql = new Sql();
        $sql->query("update monitoredfolder set monitoring = :BOOLEAN where folder_id = :FOLDER_ID && scanner_id = :SCANNER_ID",
            array(":BOOLEAN"=>$value,
                ":FOLDER_ID"=>$folderId,
                ":SCANNER_ID",$scannerId));
    }
    public static function monitoredGetState($folderId,$scannerId):bool {
        $sql = new Sql();
        $result=$sql->select("select * from  monitoredfolder where folder_id = :FOLDER_ID && scanner_id = :SCANNER_ID",
            array(":FOLDER_ID"=>$folderId,
                ":SCANNER_ID",$scannerId));
        if(isset($result[0])){
                $row =$result[0];
                return (boolean) $row['monitoring'];
        }else return false;
    }
    
    
    
    
}