<?php
session_start(); // стартуем сессию

// если в сессии нет массива корзины, то создаем его
if ( !isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

include_once 'config/config.php';         // Инициализация настроек
include_once 'library/mainFunctions.php'; // Основные функции


// Определяем с каким контроллером будем работать
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';

// Определяем с какой функцией будем работать
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

loadPage($smarty, $controllerName, $actionName);
?>