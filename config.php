<?php
/*Importando as classes necessarias.*/
spl_autoload_register(function ($className) {
    switch ($className){
        
        case 'Integration':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$className.".php");
            break;
            /*
        case 'Scanner':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case 'Scan':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case 'Folder':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case 'Host':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case 'Sql':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case 'Token':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
            */
        case strpos($className, 'DAO') !== false:
            require_once(__DIR__.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$className.".php");
            break;
            /*
        case 'ScannerDAO':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case 'ScanDAO':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case 'FolderDAO':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$className.".php");
            break;
            */
        default:
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
            
    }
        
})


?>