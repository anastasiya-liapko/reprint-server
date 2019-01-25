<?php

defined('ABS_PATH') or die;

class CategoriesModule 
{
    private $smarty;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
    }

    public function index()
    {
        $categoriesModel = new CategoriesModel;
        $categories = $categoriesModel->getList();
        $this->smarty->assign('modCategoriesCat', $categories);
    }

}