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

        $this->smarty->assign('modCartTotal', HtmlComponent::priceFormat($itogo));
        $this->smarty->assign('modCartQuantity', $quantity);
        $this->smarty->assign('positionModHeader', 'modCart'. TemplatePostfix);
    }

}