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

        $currentUrl = 'index'; 
        
        $this->smarty->assign('pageTitle', 'Reprint');
        $this->smarty->assign("currentUrl", $currentUrl); //мне кажется это лишние, то для чего получают этот параметр надо реализовывать по другому 

        $this->loadTemplate('header');
        $this->loadTemplate('index');
        $this->loadTemplate('footer'); 
        
    }


    public function orderAction() 
    {
        
        $this->smarty->assign('pageTitle', 'Reprint');
        $this->smarty->assign("currentUrl", 'order'); //мне кажется это лишние, то для чего получают этот параметр надо реализовывать по другому 

        $this->loadTemplate('header');
        $this->loadTemplate('order');
        $this->loadTemplate('footer'); 
        
    }



    public function servicesAction() 
    {
        
        $this->smarty->assign('pageTitle', 'Reprint');
        $this->smarty->assign("currentUrl", 'services'); //мне кажется это лишние, то для чего получают этот параметр надо реализовывать по другому 

        $this->loadTemplate('header');
        $this->loadTemplate('services');
        $this->loadTemplate('footer'); 
        
    }



    public function contactsAction() 
    {
        $currentUrl = 'index'; 
        
        $this->smarty->assign('pageTitle', 'Reprint');
        $this->smarty->assign("currentUrl", 'contacts'); //мне кажется это лишние, то для чего получают этот параметр надо реализовывать по другому 

        $this->loadTemplate('header');
        $this->loadTemplate('contacts');
        $this->loadTemplate('footer'); 
        
    }


}
