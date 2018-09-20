<?php
/*Importando as classes necessarias.*/
spl_autoload_register(function ($className) {
    switch ($className){
        case 'Integration':
            require_once(__DIR__.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        case strpos($className, 'DAO') !== false:
            require_once(__DIR__.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.$className.".php");
            break;
        default:
            require_once(__DIR__.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR.$className.".php");
            break;
            
    }
        
})


?>