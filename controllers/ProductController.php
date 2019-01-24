<?php

/**
 * ProductController.php
 * 
 * контроллер страницы товара
*/

class ProductController extends ControllerComponent
{

    /**
     * Формирование страницы поста
    */
    public function indexAction() 
    {       
        $itemId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range'=> 1 ]]);
        
        $where = [
            'AND',
            ['field' => 'is_showed', 'value' => 1, 'type' => '='],
            ['field' => 'id', 'value' => $itemId, 'type' => '='],
          ];

        $productsModel = new ProductsModel;
        $product = $productsModel->getItem($where);
        
        if(!$product) {
            parent::redirect();
        }

        $formats = $productsModel->getAttributes($itemId, 'formats');
        $types = $productsModel->getAttributes($itemId, 'types');
        $covers = $productsModel->getAttributes($itemId, 'covers');
        

        $whereImg = ['field' => 'book_id', 'value' => $itemId, 'type' => '='];

        $imagesModel = new ImagesModel;
        $images = $imagesModel->getList($whereImg, ['img', 'is_cover'], ['orderby' => 'asc']);
        $image = false;       
        
        if($images) {     
            $key = array_search(1, array_column($images, 'is_cover'));
            $image = $images[$key]['img'];
            unset($images[$key]); //Убрать это если нужно иметь в общем списке и главную картинку 
            $images = array_column($images, 'img');          
        } 
 
        $category = (new CategoriesModel)->getItem(['field' => 'id', 'value' => $product['section_id'], 'type' => '=']);


        $this->smarty->assign('pageTitle', 'Reprint');
        $this->smarty->assign('itemId', $itemId);     
        $this->smarty->assign('product', $product);
        $this->smarty->assign('images', $images);
        $this->smarty->assign('image', $image);
        $this->smarty->assign('formats', $formats);
        $this->smarty->assign('types', $types);
        $this->smarty->assign('covers', $covers);
        $this->smarty->assign('category', $category);

        $this->loadTemplate('header');
        $this->loadTemplate('book-page');
        $this->loadTemplate('footer');
    }

}