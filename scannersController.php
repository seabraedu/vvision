<?php require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

switch ($_GET['action']){
    case 'update':
        $scanner=ScannerDAO::loadScannerById($_POST['scanner-id']);
        $scanner->setHost($_POST['hostname']);
        $scanner->setPort($_POST['port']);
        $scanner->setUsername($_POST['username']);    
        //isso deve serCriptografado, porém deve ser capaz de decriptografar pois para geração do token se faz necessario a senha em claro.
        $scanner->setPassword($_POST['password']);
        ScannerDAO::updateScanner($scanner);
        break;
    case 'delete':
        $scanner= ScannerDAO::loadScannerById($_POST['scanner-id']);
        ScannerDAO::deleteScanner($scanner);
        break;
    case 'insert':
        $scanner= new Scanner();
        if($scanner->setHost($_POST['hostname']) && $scanner->setPort($_POST['port']) && $scanner->setUsername($_POST['username']) && $scanner->setPassword($_POST['password'])){
            ScannerDAO::insertScanner($scanner);
        }
        break;
}
redirect("scanners.php");
function redirect($url, $statusCode = 303){
    header('Location: ' . $url, true, $statusCode);
    die();
}




?>