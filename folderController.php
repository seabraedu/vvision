<?php require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

switch ($_GET['action']){
    case 'update':
        if(preg_match('/^\d+$/',$_POST['scanner_id']) && preg_match('/^\d+$/',$_POST['id'])){
            $id=(int) $_POST['id'];
            $scanner_id=(int) $_POST['scanner_id'];
            if (isset($_POST['monitorStatus'])) {
                FolderDAO::monitoredFolderUpdate($id,$scanner_id,"yes");               
            }else{
                FolderDAO::monitoredFolderUpdate($id,$scanner_id,"no");
            }
        }
        break;
    case 'sync':
        $scannerArray = ScannerDAO::listScanners();
        foreach ($scannerArray as $scanner) {
            $token = new Token();
            FolderDAO::refreshFolderFromScanner($token->getToken($scanner),$scanner);
        }
        break;
}
redirect("folders_.php");
function redirect($url, $statusCode = 303){
    header('Location: ' . $url, true, $statusCode);
    die();
}




?>