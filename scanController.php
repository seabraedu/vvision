<?php require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

switch ($_GET['action']){
    case 'sync':
        $scanner = ScannerDAO::loadScannerById($_GET['scanner_id']);
        $token = new Token();
        $scan = ScanDAO::loadScanById((int)$_GET['scan_id'],$_GET['scanner_id']);
        $scan_history_array = Integration::getScanHistory($token->getToken($scanner), $scanner, $scan);
        
        foreach ($scan_history_array as $scan_his){
            ScanDAO::insertScan($scan_his);
            $hostArray=Integration::getScanHosts($token->getToken($scanner), $scanner, $scan_his);
            HostDAO::insertArray($hostArray);
            $hosts = HostDAO::listHostsFromScan($scan_his);
            foreach ($hosts as $host) {
                $vulns= Integration::getScanVulnerabitiesFromHost($token->getToken($scanner), $scanner, $scan, $host);
                foreach ($vulns as $vulnerability) {
                    VulnerabilityDAO::insertVulnerability($vulnerability);
                }
            }
        }
        break;
    
      
    case 'detail':
        $scanner = ScannerDAO::loadScannerById($_GET['scanner_id']);
        $scan = ScanDAO::loadScanById((int)$_GET['scan_id'],(int)$_GET['scanner_id']);
        break;
        
        
    case 'sync_scans':
        $arrayMonitoredFolders = FolderDAO::getMonitoredFolders();        
        foreach ($arrayMonitoredFolders as $folder) {
            $token = new Token();            
            $scanner = ScannerDAO::loadScannerById($folder->getScanner_Id());
            $scansArray=Integration::scanListFromFolder($token->getToken($scanner), $scanner, $folder);
            foreach ($scansArray['scans'] as $scanRead) {
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
                
            }
        }
        redirect("scans.php");
        break;

}
redirect("scanDetail.php?scan_id=".$scan->getId()."&scanner_id=".$_GET['scanner_id']."&scan_name=".$_GET['scan_name']);
function redirect($url, $statusCode = 303){
    header('Location: ' . $url, true, $statusCode);
    die();
}




?>