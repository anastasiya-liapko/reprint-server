<?php


/**
 * контроллер работы с корзиной
*/

class CartController extends ControllerComponent
{

    private $filterProduct = [        
        'product_id' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range'=> 1 ]
        ], 
        'quantity' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range'=> 1, 'default' => 1]
        ],
        'type' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range'=> 1 ]
        ],
        'cover' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range'=> 1 ]
        ],   
        'format' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => ['min_range'=> 1 ]
        ],
    ];


    //Удалить этот метод!!!!
    public function clearAction()
    {
        parent::clearSession();
        parent::redirect(['controller' => 'cart']);
    }


    public function indexAction() 
    {
        $result = $this->addProduct();
        $this->displayCart();        
    }


    public function addAction()
    {
        $result = $this->addProduct();
    }

    public function new_orderAction()
    {
        $this->smarty->assign('pageTitle', 'Новый заказ');
        $this->loadTemplate('new_order'); 
    }
    

    public function updateAction()
    {
        if(filter_has_var(INPUT_POST, 'delete')) {

            $delete = filter_input(INPUT_POST, 'delete', FILTER_DEFAULT);
            $cartProduct = parent::getSession('products', []);
            if($delete && isset($cartProduct[$delete])) {
                $newTotal = parent::getSession('total', 0) - $cartProduct[$delete]['sum_item'];
                $newQuantity = parent::getSession('quantity', 0) - $cartProduct[$delete]['quantity'];
                if($newTotal < 0){ $newTotal = 0; }
                if($newQuantity < 0){ $newQuantity = 0; }
                if($newTotal > 0) {
                    $itogo = $newTotal + CartModel::calcDelivery();
                } else { 
                    $itogo = 0;
                }
                parent::setSession('total', $newTotal);
                parent::setSession('quantity', $newQuantity);
                parent::setSession('itogo', $itogo);
                unset($cartProduct[$delete]);
                parent::setSession('products', $cartProduct);
            }       

        } elseif (filter_has_var(INPUT_POST, 'send') && filter_has_var(INPUT_POST, 'products')) {

            $requisites = $this->getRequisites();
            $field = ['name', 'address', 'phone', 'email', 'delivery_type'];
            $errorRequisites = [];
            foreach($field as $f){
                if(empty($requisites[$f])) {
                    $errorRequisites[$f] = true;
                }
            }

            if(!empty($errorRequisites)){
                $this->updateProduct();
                $this->displayCart(['errorRequisites' => $errorRequisites, 'errorMess' => 'Не заполнены все обязателные поля!!!']);
                return;
            }

            $captcha = false;
            myLog($requisites['g-recaptcha-response'], 'g-recaptcha-response');
            if($requisites['g-recaptcha-response']) {
                include_once ABS_PATH .'/library/recaptchalib.php';
                $reCaptcha = new ReCaptcha(RECAPTCHA);
                $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $requisites['g-recaptcha-response']);
                if(!is_null($response) && $response->success) {
                    $captcha = true;
                }
            }

            if(!$captcha){
                $this->updateProduct();
                $this->displayCart(['errorMess' => 'Вы не прошли проверку ReCaptcha!']);
                return;
            }
            


            $cartModel = new CartModel;
            $itemsOrder = [];
            foreach($_POST['products'] as $product){
                $addProduct = filter_var_array($product, $this->filterProduct);
                if($addProduct['product_id']) {
                    $itemsOrder[] = $cartModel->addItemOrder($addProduct);
                }
            }        
            
            parent::setSession('products', []);
            parent::setSession('total', 0);
            parent::setSession('itogo', 0);
            parent::setSession('quantity', 0);

            if(!empty($itemsOrder)) {                
                $cartModel->addOrder($itemsOrder, $requisites);
                parent::redirect(['controller'=>'cart', 'action' => 'new_order']);                
            } else {
                $this->displayCart(['errorMess' => 'Добавьте товар в корзину!']); 
            } 
            return;

        } elseif(filter_has_var(INPUT_POST, 'products')) { 

            $this->updateProduct(); 
        }

        $this->displayCart();
    }

    private function updateProduct()
    {
        parent::setSession('products', []);
        parent::setSession('total', 0);
        parent::setSession('itogo', 0);
        parent::setSession('quantity', 0);
        $cartModel = new CartModel;
        foreach($_POST['products'] as $product){
            $addProduct = filter_var_array($product, $this->filterProduct);
            if($addProduct['product_id']) {
                $cartModel->addToCart($addProduct);
            }
        }
        parent::setSession('requisites', $this->getRequisites());
    }

    private function getRequisites()
    {
        $filterRequisites = [        
            'name' => [
                'filter' => FILTER_SANITIZE_STRING,
                'options' => ['flags' => FILTER_FLAG_STRIP_LOW, 'default' => '']
            ],
            'address' => [
                'filter' => FILTER_SANITIZE_STRING,
                'options' => ['flags' => FILTER_FLAG_STRIP_LOW, 'default' => '']
            ],  
            'phone' => [
                'filter' => FILTER_SANITIZE_STRING,
                'options' => ['flags' => FILTER_FLAG_STRIP_LOW, 'default' => '']
            ],
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL,
                'options' => ['default' => '']
            ],
            'comment' => [
                'filter' => FILTER_SANITIZE_STRING,
                'options' => ['flags' => FILTER_FLAG_STRIP_LOW, 'default' => '']
            ],
            'delivery_type' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['default' => '', 'regexp' => '/^(courier|post|pickup)$/i']
            ],
            'g-recaptcha-response' => FILTER_DEFAULT
        ];

        $requisites = filter_input_array(INPUT_POST, $filterRequisites);

        $length = [
            'name' => 100,
            'address' => 1000,
            'phone' => 100,
            'email' => 100,
            'comment' => 1000,      
        ];
        
        foreach($length as $name => $len) {      
            $requisites[$name] = mb_substr(trim($requisites[$name]), 0, $len, 'UTF-8');            
        }

        return $requisites;        
    }

    private function addProduct()
    {
        $result = ['status' => false, 'mess' => ''];
        if(filter_has_var(INPUT_POST, 'product_id')) {
            $result = ['status' => false, 'mess' => 'Не удалось добавить товар в корзину!'];
            $addProduct = filter_input_array(INPUT_POST, $this->filterProduct);
            if($addProduct['product_id']) { 
                $cartModel = new CartModel;
                $result = $cartModel->addToCart($addProduct);
            }

        }

        return $result;
    }    

    private function displayCart(array $vars = [])
    {
        $productsModel = new ProductsModel;
        $products = parent::getSession('products', []);
        foreach($products as &$item){
            foreach($item['adv_params'] as $field => $value){
                $param = $productsModel->getAttributes($item['id'], $field);
                foreach($param as &$v){
                    if($v['id'] == $value) {
                        $v['is_default'] = 1;
                    } else {
                        $v['is_default'] = 0; 
                    }
                }
                $item['adv_params'][$field] = $param; 
            }
        }

        $total = parent::getSession('total', 0);        

        $default = [
            'name' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'comment' => '',
            'delivery_type' => '',
        ];
        $requisites = parent::getSession('requisites', $default);
        $sumDelivery = CartModel::calcDelivery();

        if($total > 0) {
            $itogo = $total + $sumDelivery;
        } else { 
            $itogo = 0;
        }

        $this->smarty->assign('pageTitle', 'Корзина товаров');
        $this->smarty->assign('currentUrl', 'cart');
        $this->smarty->assign('products', $products);
        $this->smarty->assign('requisites', $requisites);
        $this->smarty->assign('total', $total);
        $this->smarty->assign('itogo', $itogo);
        $this->smarty->assign('sumDelivery', $sumDelivery);
        $this->smarty->assign('errorRequisites', []);
        foreach($vars as $name => $var){
            $this->smarty->assign($name, $var); 
        }


        $this->loadTemplate('cart');
     
    }


    






    


    

}
