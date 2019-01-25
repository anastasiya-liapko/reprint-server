<?php

define('ABS_PATH', __DIR__);
session_start(); 

include_once  ABS_PATH .'/config/config.php';         // Инициализация настроек
include_once  ABS_PATH .'/library/autoload.php'; 


new RoutedComponent; 


