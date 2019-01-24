<?php


/**
 * контроллер работы с корзиной
*/

class CartController extends ControllerComponent
{

    /**
     * Формирование страницы корзины
     * 
    */

    public function indexAction() 
    {  

        $this->smarty->assign('pageTitle', 'Reprint');
        $this->smarty->assign("currentUrl", 'cart');

        $this->loadTemplate('header');
        $this->loadTemplate('order');
        $this->loadTemplate('footer');
    }

}
