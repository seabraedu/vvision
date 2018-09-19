<?php

require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');
/*
//Inserindo novo scanner
$scanner = new Scanner();
$scanner->setHost("10.1.2.3");
$scanner->setPort("443");
$scanner->setUsername("teste");
$scanner->setPassword("teste");
//
ScannerDAO::insertScanner($scanner);
echo "inserção realizada com sucesso<br>";
$result = ScannerDAO::listScanners();
*/
//Final da inserção

//Atualizando um scanner
/*
$scanner = ScannerDAO::loadScannerById(1);
$scanner->setPassword("noPassword2copy");

echo $teste->getPassword();
*/

//Listando todas as folders de um scanner
/*
$scanner = ScannerDAO::loadScannerById(1);
$token = new Token();
var_dump(Integration::listFolders($token->getToken($scanner), $scanner));
var_dump(FolderDAO::refreshFolderFromScanner($token->getToken($scanner),$scanner));
*/
//Listando a Sessão e pastas com mesmo token
/*
$scanner = ScannerDAO::loadScannerById(1);
$token = new Token();
$response= Integration::getSession($token->getToken($scanner), $scanner);
var_dump( $token->getToken($scanner));

echo '<br>username: '.$response['username']."<br>".'lastLogin: '.date("d-m-Y  H:i:s",$response['lastlogin']);
echo '<br>';
var_dump( $token->getToken($scanner));
echo '<br>';
echo var_dump(Integration::listFolders($token->getToken($scanner), $scanner));
echo '<br>';
var_dump( $token->getToken($scanner));
*/

//Listando todos os Scans de uma determinada folder
/*
$scanner = ScannerDAO::loadScannerById(1);
$token = new Token();
//$folder = FolderDAO::getFolderById($scanner, 3);
$folders = Integration::listFolders($token->getToken($scanner), $scanner);
foreach ($folders['folders'] as $folderArray) {    
    $scansArray=Integration::scanListFromFolder($token->getToken($scanner), $scanner, $folder = FolderDAO::getFolderById($scanner, $folderArray['id']));
    foreach ($scansArray['scans'] as $scanRead) {
        echo '<br>';
        $scan = new Scan();
        $scan->setId((int)$scanRead['id']);
        $scan->setName($scanRead['name']);
        $scan->setFolder_id((int) $folder->getId());
        $scan->setCreation_date((int)$scanRead['creation_date']);
        $scan->setLast_modification_date((int)$scanRead['last_modification_date']);
        $scan->setStatus($scanRead['status']);
        $scan->setOwner($scanRead['owner']);
        //$scan->setHost_ids($scanRead['host_ids']);
        $scan->setHistory_of($scanRead['history_of']);
        ScanDAO::insertScan($scan); 
    }
};
*/
//Inserindo todos os Scans_history de todos os Scans cadastrados
/*
$scanner = ScannerDAO::loadScannerById(1);
$token = new Token();
$scans = ScanDAO::listScans();
//$scans = ScanDAO::loadScanById(39);
foreach ($scans as $scan) {
    $scanArray = Integration::getScanHistory($token->getToken($scanner), $scanner,$scan);
    ScanDAO::insertScanFromArray($scanArray);  
}
*/

//Listando Hosts de um Scan e inserindo no banco de dados
/*
 $scanner = ScannerDAO::loadScannerById(1);
 $token = new Token();
 $scan = ScanDAO::loadScanById(40);

*/ 

//Inserindo todos os hosts de todos os Scans -- tarefa demorada 50 segundos.
/*
 $scanner = ScannerDAO::loadScannerById(1);
 $token = new Token();
 $scans = ScanDAO::listScans();
 //$scans = ScanDAO::loadScanById(39);
 foreach ($scans as $scan) {
    $hostArray=Integration::getScanHosts($token->getToken($scanner), $scanner, $scan);
    HostDAO::insertArray($hostArray);
 }
*/
 
  
//Listando todas vulnerabilidades de todos os host e todos scans e inserinfo no bando de dados

 $scanner = ScannerDAO::loadScannerById(1);
 $token = new Token();
 $scans = ScanDAO::listScans();
// $scans = ScanDAO::loadScanById(465);
 foreach ($scans as $scan) {
     $hosts = HostDAO::listHosts($scan);
     foreach ($hosts as $host) {
         $vulns= Integration::getScanVulnerabitiesFromHost($token->getToken($scanner), $scanner, $scan, $host);
         sleep(0.4);
         foreach ($vulns as $vulnerability) {
             VulnerabilityDAO::insertVulnerability($vulnerability);
        }
     }
 }











?>