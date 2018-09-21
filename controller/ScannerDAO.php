<?php
require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

class ScannerDAO{
    
    //Retorna lista de todos os scanner cadastrados no banco.
    public static function listScanners():array {
        $sql = new Sql();
        $result = $sql->select("select * from scanner");
        return $result;
    }
    //Insere um novo scanner no banco de dados
    public static function insertScanner($scanner) {
        $sql = new Sql();
        
        $sql->query("insert into scanner (host,port,username,password) values ( :HOST , :PORT , :USERNAME , :PASSWORD)",array(
                            ":HOST"=>$scanner->getHost(),
                            ":PORT"=>$scanner->getPort(),
                            ":USERNAME"=>$scanner->getUsername(),
                            ":PASSWORD"=>$scanner->getPassword()));
        
        
    }
    //Retorna um scanner a partir de um ID
    public static function loadScannerById($id):Scanner {
        $sql = new Sql();
        $result = $sql->select("select * from scanner where id = :ID",array(":ID"=>$id));
        
        if (isset($result[0])){
            $row=$result[0];
            $scanner = new Scanner($row['username'],$row['password'],$row['host'],$row['port'],$row['id']);
            return $scanner;
        }else echo "Não foi encontrado scanner com o ID fornecido";
        
    }
    //Deleta um scanner da base de dados
    public static function deleteScanner($scanner) {
        $sql = new Sql();
        $sql->select("delete from scanner where id = :ID",array(":ID"=>$scanner->getId()));
    }
    //Atualiza os dados de um scanner no banco de dados.
   public static function updateScanner($scanner):Scanner {
       $sql = new Sql();
       $sql->query("update scanner set host = :HOST , port = :PORT , username = :USERNAME , password = :PASSWORD where id = :ID",array(
           ":HOST"=>$scanner->getHost(),
           ":PORT"=>$scanner->getPort(),
           ":USERNAME"=>$scanner->getUsername(),
           ":PASSWORD"=>$scanner->getPassword(),
           ":ID"=>$scanner->getId()));
         return ScannerDAO::loadScannerById($scanner->getId());
   }
    
    
}

?>