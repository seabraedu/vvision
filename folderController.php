<?php require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."Vvision".DIRECTORY_SEPARATOR.'config.php');

switch ($_GET['action']){
    case 'update':

        break;
}
redirect("folders_.php");
function redirect($url, $statusCode = 303){
    header('Location: ' . $url, true, $statusCode);
    die();
}




?>