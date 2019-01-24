<?php

defined('ABS_PATH') or die;

spl_autoload_register( function($class) {

    $folders = ['component', 'controller', 'model'];
    $folder = '';
    foreach($folders as $fol) {
        if(stripos($class, $fol) !== false) {
            $folder = $fol . 's/'; 
            break; 
        }
    }
    
    $file = ABS_PATH . '/' . $folder .  $class . '.php';   

    if(file_exists($file)) {
        include_once $file; 
    } 
});


function myLog($txt, $module = '') {

    file_put_contents( ABS_PATH .'/myLog.log', "\r\n [".date("Y-m-d H:i:s").'] '. (string)$module ."\r\n" .
    print_r($txt, true)
    , FILE_APPEND);

}


