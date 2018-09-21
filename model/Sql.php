<?php

require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

class Sql extends PDO {
    private  $connection;
    
    //M�todo construtor da classe SQL
    //Cria uma conex�o com o banco de dados
    public function __construct() {
        $this->connection = new PDO("mysql:hostname=localhost;dbname=vvsiondb","root","admin");
    }
    
    //Metodo que percorre o array de parametros passados e chama o bindParameters
    // para setar os parametros.
    private function setParams ($statement,$parameters=array()){
        foreach ($parameters as $key=>$value){
            $this->bindParameters($statement, $key, $value);
        }
    }
    
    //Metodo que trata dos parametros da query
    private function bindParameters ($statementBind,$key,$value){
        $statementBind->bindParam($key, $value);
    }
    
    //Metodo que prepara a query e executa a mesma e retorna statemento com a execu��o
    public function query($rawQuery, $param=array()) {
        $stmt=$this->connection->prepare($rawQuery);
        $this->setParams($stmt,$param);
        $stmt->execute();
        return $stmt;
    }
    
    public function select($rawQuery,$params = array()):array {
        $stmt = $this->query($rawQuery,$params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
}


?>