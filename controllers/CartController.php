<?php

/**
 * CartController.php
 * 
 * контроллер работы с корзиной
 */

// Подключаем модули
include_once 'models/CategoriesModel.php';
include_once 'models/ProductsModel.php';


/**
 * Формирование страницы корзины
 * 
 */
function indexAction($smarty) {
    $rsCategories = getAllMainCats();

    $smarty->assign('pageTitle', 'Reprint');
    $smarty->assign('rsCategories', $rsCategories);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'order');
    loadTemplate($smarty, 'footer');
}
