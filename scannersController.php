<?php require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

switch ($_GET['action']){
    case 'update':
        $scanner= new Scanner();        
        $scanner->setId($_POST['scanner-id']);
        $scanner->setHost($_POST['hostname']);
        $scanner->setPort($_POST['port']);
        $scanner->setUsername($_POST['username']);
        //isso deve serCriptografado
        $scanner->setPassword($_POST['password']);
        ScannerDAO::updateScanner($scanner);
        redirect("scanners.php");
        break;
    case 'delete':
        $scanner= ScannerDAO::loadScannerById($_POST['scanner-id']);
        ScannerDAO::deleteScanner($scanner);
        redirect("scanners.php");
        break;
    case 'insert':
        $scanner= new Scanner();
        $scanner->setHost($_POST['hostname']);
        $scanner->setPort($_POST['port']);
        $scanner->setUsername($_POST['username']);
        //isso deve serCriptografado
        $scanner->setPassword($_POST['password']);
        ScannerDAO::insertScanner($scanner);
        redirect("scanners.php");
        break;
}

function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}




?>