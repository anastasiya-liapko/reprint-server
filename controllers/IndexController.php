<?php

/**
 * Контроллер главной страницы
*/

class IndexController extends ControllerComponent
{
    /**
     * Формирование главной страницы сайта 
    */

    public function indexAction() 
    {        
        $this->smarty->assign('pageTitle', 'Reprint');
        $this->loadTemplate('index'); 
    }


    public function orderAction() 
    {        
        $this->smarty->assign('pageTitle', 'Reprint');
        $this->loadTemplate('order');        
    }



    public function servicesAction() 
    {        
        $this->smarty->assign('pageTitle', 'Услуги');
        $this->loadTemplate('services');        
    }



    public function contactsAction() 
    {        
        $this->smarty->assign('pageTitle', 'Контакты');   
        $this->loadTemplate('contacts');
    }


}
