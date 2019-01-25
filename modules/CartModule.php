<?php

defined('ABS_PATH') or die;

class CartModule 
{
    private $smarty;

    public function __construct($smarty)
    {
        $this->smarty = $smarty;
    }

    public function index()
    {
        $itogo = ControllerComponent::getSession('itogo', 0);
        $quantity = ControllerComponent::getSession('quantity', 0);

        $itogo = number_format($itogo, 0, ',', ' ')  . ' руб.';

        $this->smarty->assign('modCartTotal', $itogo);
        $this->smarty->assign('modCartQuantity', $quantity . ' экз');
        $this->smarty->assign('positionModHeader', 'modCart'. TemplatePostfix);
    }

}