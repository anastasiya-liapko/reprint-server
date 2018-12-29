<?php

/**
 * PostController.php
 * 
 * контроллер страницы товара
 */

// Подключаем модули
include_once 'models/CategoriesModel.php';
include_once 'models/ProductsModel.php';

/**
 * Формирование страницы поста
 * 
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty) {
    $itemId = isset($_GET['id']) ? $_GET['id'] : NULL;
    
    $rsCategories = getAllMainCats();

    $smarty->assign('pageTitle', 'Reprint');
    $smarty->assign('itemId', $itemId);
    $smarty->assign('rsCategories', $rsCategories);

    loadTemplate($smarty, 'header');
    loadTemplate($smarty, 'book-page');
    loadTemplate($smarty, 'footer');
}