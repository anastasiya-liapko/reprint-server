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
            $this->page404();
            exit;            
        } 

        $params = ['type' => 'Бумага:','cover' => 'Переплет:', 'format' => 'Формат:'];
        $adv_params = [];
        $json = [];
        foreach($params as $item => $label){
            $result = $productsModel->getAttributes($itemId, $item);   
            if($result) {
                $adv_params[$item] = [];
                $adv_params[$item]['values'] = $result;
                $adv_params[$item]['label'] = $label;    
                foreach($result as $value){
                    if(!isset($json[$item])) { 
                        $json[$item] = [];
                    }
                    $json[$item][$value['id']] = $value['price'];
                }
            }             
        }
        

        $whereImg = ['field' => 'book_id', 'value' => $itemId, 'type' => '='];

        $imagesModel = new ImagesModel;
        $images = $imagesModel->getList($whereImg, ['img', 'is_cover'], ['is_cover' => 'desc', 'orderby' => 'asc']);             
      
        /*
        $image = false; 
        if($images) {     
            $key = array_search(1, array_column($images, 'is_cover'));
            $image = $images[$key]['img'];
            unset($images[$key]); //Убрать это если нужно иметь в общем списке и главную картинку 
            $images = array_column($images, 'img');          
        } */
 
        $category = (new CategoriesModel)->getItem(['field' => 'id', 'value' => $product['section_id'], 'type' => '=']);

        $js = 
        'jQuery(document).ready(function($) {      
            $.startBookPage('.json_encode($json).', '.$product['price'].' );
        });';
        $this->addJsCode($js);


        $this->smarty->assign('pageTitle', $product['name']);
        $this->smarty->assign('itemId', $itemId);     
        $this->smarty->assign('product', $product);
        $this->smarty->assign('images', $images);
        //$this->smarty->assign('image', $image);
        $this->smarty->assign('adv_params', $adv_params);
        $this->smarty->assign('category', $category);          
 


        $this->loadTemplate('book-page');
 
    }

}