<?php

/**
 * Контроллер главной страницы
 */

// Подключаем модели
include_once 'models/CategoriesModel.php';
include_once 'models/ProductsModel.php';

/**
 * Формирование главной страницы сайта
 * 
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty) {

    // получаем url текущей страницы
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pro = 'https';
    } else {
        $pro = 'http';
    }
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    $current_url =  $pro."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
    $explode_url_1 = explode('?controller=', $current_url);
    $explode_url_2 = explode('&', $explode_url_1[1]);
    $currentUrl = $explode_url_2[0];
    
    
    $rsCategories = getAllMainCats();

    $smarty->assign('pageTitle', 'Reprint');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign("currentUrl",$currentUrl);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'index');
    loadTemplate($smarty, 'footer');
}
