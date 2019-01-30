<?php

/**
 * CategoryController.php
 * 
 * контроллер страницы категории
*/

class CategoryController extends ControllerComponent
{


  /**
   * Формирование страницы категории
  */
  public function indexAction()
  {
    $catIdDefault = 1; //категория по умолчанию
    $itemInPage = 12; //книг на странице

    $catId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range'=> 1, 'default' => $catIdDefault ]]);
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, ['options' => ['min_range'=> 1, 'default' => 1 ]]);
    $asc = filter_input(INPUT_GET, 'asc', FILTER_VALIDATE_REGEXP, ['options' => ['default' => 'asc', 'regexp' => '/^(asc|desc)$/i']]);
    $order = filter_input(INPUT_GET, 'order', FILTER_VALIDATE_REGEXP, ['options' => ['default' => 'id', 'regexp' => '/^(id|name|author|flags|price)$/i']]);
    $search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING, ['flags' => FILTER_FLAG_STRIP_LOW]);   
    
    $link = ['controller' => 'category', 'asc' => $asc, 'order' => $order];

    $where = [
      'AND',
      ['field' => 'is_showed', 'value' => 1, 'type' => '='],      
    ];
         
    if($search) {
      $search = str_replace(['%','_'], ' ', $search);
      $search = trim(preg_replace('|\s+|', ' ', $search));
      if(mb_strlen($search, 'UTF-8') > 2) {
        $search2 = '%'. str_replace(' ', '%', $search) . '%';
        $where[] = ['field' => 'name', 'value' => $search2, 'type' => 'LIKE'];
        $link['search'] = $search;
      } else {
        $search = false;
      }
    }

    if(!$search) {
      $where[] = ['field' => 'section_id', 'value' => $catId, 'type' => '='];
    }

    $orderBy = [$order => $asc];
    $limit = [(($page - 1) * $itemInPage), $itemInPage];
    $select = ['id', 'name', 'author', 'section_id', 'price', 'dsc', 'flags'];

    $productModel = new ProductsModel;
    $rsProducts = $productModel->getList($where, $select, $orderBy, $limit, true);
    $count = $productModel->getCount();    

    $imagesModel = new ImagesModel;
    $imagesModel->addListImage($rsProducts);
    
    if($page > 1) {
      $link['page'] = $page;
    }
 
    $categoryName = (new CategoriesModel)->getItem(['field' => 'id', 'value' => $catId, 'type' => '=']);

    $cartProducts = parent::getSession('products', []);
    $cartProductId = array_column($cartProducts,'id'); 

    $this->smarty->assign('pageTitle', $categoryName['name']);
    $this->smarty->assign('catId', $catId);
    $this->smarty->assign('rsProducts', $rsProducts);
    $this->smarty->assign('page', $page);
    $this->smarty->assign('asc', $asc);
    $this->smarty->assign('asc2', (($asc == 'asc') ? 'desc' : 'asc'));
    $this->smarty->assign('order', $order);
    $this->smarty->assign('count', $count);
    $this->smarty->assign('link', $link);
    $this->smarty->assign('itemInPage', $itemInPage);
    $this->smarty->assign('search', $search);
    $this->smarty->assign('categoryName', $categoryName);
    $this->smarty->assign('cartProductId', $cartProductId);

    $this->loadTemplate('razdel');
  }

}

