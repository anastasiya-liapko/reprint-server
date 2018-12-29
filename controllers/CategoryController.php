<?php

/**
 * CategoryController.php
 * 
 * контроллер страницы категории
 */

// Подключаем модули
include_once 'models/CategoriesModel.php';
include_once 'models/ProductsModel.php';

/**
 * Формирование страницы категории
 * 
 * @param object $smarty шаблонизатор
 */
function indexAction($smarty) {
    $catId = isset($_GET['id']) ? $_GET['id'] : NULL;
    
    $rsProducts = NULL;

    $rsCategories = getAllMainCats();
    $rsProducts = getProductsByCat($catId);

    $smarty->assign('pageTitle', 'Reprint');
    $smarty->assign('catId', $catId);
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty, 'header');
    if ($catId == 1) {
      loadTemplate($smarty, 'razdel');
    } else if ($catId == 3) {
      loadTemplate($smarty, 'services');
    } else if ($catId == 4) {
      loadTemplate($smarty, 'contacts');
    } else if ($catId == 5) {
      loadTemplate($smarty, 'search');
    }
    loadTemplate($smarty, 'footer');
}

