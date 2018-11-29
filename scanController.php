<?php require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

switch ($_GET['action']){
    case 'sync':
        $scanner = ScannerDAO::loadScannerById(12747);
        $token = new Token();
        $scan = ScanDAO::loadScanById((int)$_GET['scan_id']);
        
            $hosts = HostDAO::listHostsFromScan($scan);
            foreach ($hosts as $host) {
                $vulns= Integration::getScanVulnerabitiesFromHost($token->getToken($scanner), $scanner, $scan, $host);
                foreach ($vulns as $vulnerability) {
                    VulnerabilityDAO::insertVulnerability($vulnerability);
                }
            }
        break;
    case 'detail':
        $scanner = ScannerDAO::loadScannerById(12747);
        $token = new Token();
        $scan = ScanDAO::loadScanById((int)$_GET['scan_id']);
        break;
}
redirect("scanDetail.php?scan_id=".$scan->getId());
function redirect($url, $statusCode = 303){
    header('Location: ' . $url, true, $statusCode);
    die();
}




?>