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

/*
//Listando todos os scanners cadastrados
foreach (ScannerDAO::listScanners() as $scanner) {
    echo $scanner->getHost()."<br>".$scanner->getId();
}
*/


//Atualizando um scanner
/*
$scanner = ScannerDAO::loadScannerById(1);
$scanner->setPassword("noPassword2copy");

echo $teste->getPassword();
*/

//Listando todas as folders de um scanner

$scanner = ScannerDAO::loadScannerById(12747);
$token = new Token();
//var_dump($token->getToken($scanner));
//var_dump(Integration::listFolders($token->getToken($scanner), $scanner));
//var_dump(FolderDAO::refreshFolderFromScanner($token->getToken($scanner),$scanner));
//foreach (FolderDAO::listAllFoldersInDB() as $folders){
//    printf ("<br>ID: ".$folders->getId()." <b>FolderName: ". $folders->getName()."</b>  ScannerId:".$folders->getScanner_id());
//}


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
$scanner = ScannerDAO::loadScannerById(12747);
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
        $scan->setScanner_id($folder->getScanner_id());
        ScanDAO::insertScan($scan);
        var_dump($scan);
    }
};
*/
//Inserindo todos os Scans_history de todos os Scans cadastrados
/*
$scanner = ScannerDAO::loadScannerById(12747);
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
var_dump(ScanDAO::listScans());
 */

//Inserindo todos os hosts de todos os Scans -- tarefa demorada 50 segundos.
/*
 $scanner = ScannerDAO::loadScannerById(12747);
 $token = new Token();
 $scans = ScanDAO::listScans();
 //$scans = ScanDAO::loadScanById(39);
 foreach ($scans as $scan) {
    $hostArray=Integration::getScanHosts($token->getToken($scanner), $scanner, $scan);
    HostDAO::insertArray($hostArray);
 }

 */
  
//Listando todas vulnerabilidades de todos os host e todos scans e inserinfo no bando de dados
/*
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
*/

/*
 $scanner = ScannerDAO::loadScannerById(1);
 $token = new Token();

 $scans = ScanDAO::loadScanById(465);
 $host = HostDAO::loadHostById($scans, 2);
 $vuln = new Vulnerability();
 $vuln->setPlugin_id(102519);
$pluginInfo=(Integration::getScanVulnerabitiesPluginOutput($token->getToken($scanner), $scanner, $scans, $host, $vuln));   
*/

$result =HostDAO::getHostVulnerabilities($_GET['host']);
    var_dump($result);
    

    $critica=0;
    $high=0;
    $medium=0;
    $low=0;
    foreach ($result as $line ) {
        
        switch ($line['severity']){
            case '4':
                $critica+=1;
                break;
            case '3':
                $high+=1;
                break;
            case '2':
                $medium+=1;
                break;
            case '1':
                $low+=1;
                break;
        }
    }
    echo "critica: ".$critica."high: ".$high."medium: ".$medium."low: ".$low;
foreach ($result as $arrayHosts) {
    echo "<BR>".$arrayHosts['hostname']." ---> Horário de verificação: ".$arrayHosts['last_modification_date']."<BR>";
    
}
$result =HostDAO::getHostHistory($_GET['host']);
foreach ($result as $arrayHosts) {
    echo "<BR>".$arrayHosts['hostname']." ---> Horário de verificação: ".$arrayHosts['last_modification_date']."<BR>";
    echo "<BR> Critical --->".$arrayHosts['critical']."  high --->".$arrayHosts['high']."  Medium --->".$arrayHosts['medium']."  Low --->".$arrayHosts['low'];
}

 ?>

