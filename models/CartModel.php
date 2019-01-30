<?php

defined('ABS_PATH') or die;

class CartModel extends ModelComponent
{

    public static function tableName()
    {
        return 'orders';
    }

    public function addToCart($add)
    {
        $result = ['status' => false, 'mess' => 'Не удалось добавить товар в корзину!'];

        $where = [
            'AND',
            ['field' => 'is_showed', 'value' => 1, 'type' => '='],
            ['field' => 'id', 'value' => $add['product_id'], 'type' => '='],
        ];

        $productsModel = new ProductsModel;
        $product = $productsModel->getItem($where, ['id', 'name', 'author', 'section_id', 'price', 'dsc']);
        if(!$product) {
            $result['mess'] = 'Такой товар не найден!';
            return $result; 
        }

        $product['price_adv'] = $product['price'];    
        $product['quantity'] = $add['quantity']; 
        $product['adv_params'] = [];
        $keyArr = ['product' => $add['product_id']]; 

        $params = ['type','cover', 'format'];
        foreach($params as $item){
            $param = $this->advancedParams($add['product_id'], $item, $add[$item]);
            if($param[$item.'_id']) {
                $product['price_adv'] += $param['price'];
                $product['adv_params'][$item] = $param[$item.'_id'];
            }                 
        }

        $keyArr['adv_params'] = $product['adv_params'];

        $product['sum_item'] = $add['quantity'] * $product['price_adv']; 

        $key = md5(json_encode($keyArr));  

        $cartProduct = ControllerComponent::getSession('products', []);  
        if(isset($cartProduct[$key])) {
            $cartProduct[$key]['quantity'] += $product['quantity'];
            $cartProduct[$key]['sum_item'] = $cartProduct[$key]['quantity'] * $product['price_adv'];
        } else {
            $cartProduct[$key] = $product;
            uasort($cartProduct, function($a, $b) {
                if($a['id'] < $b['id']) { 
                    return -1; 
                } elseif ($a['id'] > $b['id']) {
                    return 1;
                } else {
                    return 0;
                }
            }); 
        } 
        ControllerComponent::setSession('products', $cartProduct);

        $total = ControllerComponent::getSession('total', 0);
        $total += $product['sum_item'];
        ControllerComponent::setSession('total', $total);
        if($total > 0){
            $itogo = self::calcDelivery() + $total;
        } else {
            $itogo = 0;
        }
        ControllerComponent::setSession('itogo', $itogo);
        $quantity = ControllerComponent::getSession('quantity', 0);
        $quantity += $product['quantity'];
        ControllerComponent::setSession('quantity', $quantity);        
        
        return ['status' => true, 'mess' => 'Товар успешно добавлен в корзину!'];
    }

    public function addOrder($itemsOrder, $requisites)
    {
        $requisites['dt'] = (new DateTime())->format('Y-m-d H:i:s');
        $requisites['status'] = 'new';
        $id = $this->insert($requisites);
        if($id){
            foreach($itemsOrder as &$item){
                $item['order_id'] = $id;
            }
            $orderItemModel = new OrderItemModel;
            $orderItemModel->insertMultiple($itemsOrder);
        }
    }



    public function addItemOrder($add)
    {
        $where = [
            'AND',
            ['field' => 'is_showed', 'value' => 1, 'type' => '='],
            ['field' => 'id', 'value' => $add['product_id'], 'type' => '='],
        ];

        $new = [];

        $productsModel = new ProductsModel;
        $product = $productsModel->getItem($where, ['id']);
        if(!$product) {
            return false; 
        }

        $new['book_id'] = $product['id'];
        $new['item_count'] = $add['quantity'];

        $params = ['type', 'cover', 'format', ];
        foreach($params as $item){
            $param = $this->advancedParams($add['product_id'], $item, $add[$item]);
            if($param[$item.'_id']) {
                $new['book_'.$item.'_id'] = $param[$item.'_id'];                
            } else {
                $new['book_'.$item.'_id'] = null;
            }              
        }

        return $new; 
    }

    


    private function advancedParams($product_id, $type, $id)
    {
        $type_id = $type.'_id';

        if(!$id){
            return ['price' => 0, $type_id => false];
        }        

        $where = [
            'AND',
            ['field' => 'book_id', 'value' => $product_id, 'type' => '='],
            ['field' => $type_id, 'value' => $id, 'type' => '='],
        ];

        $modelName = 'Book'.ucfirst($type).'sModel'; 
        $model = new $modelName;
        $param = $model->getItem($where, ['price', $type_id]);
        if(!$param){
            $where = [
                'AND',
                ['field' => 'book_id', 'value' => $product_id, 'type' => '='],
                ['field' => 'is_default', 'value' => 1, 'type' => '='],
            ];
            $param = $model->getItem($where, ['price', $type_id]);
            if(!$param){
                return ['price' => 0, $type_id => false];
            }
        }
        return $param;
    }


    public static function calcDelivery()
    {
        $total = ControllerComponent::getSession('total', 0);
        $delivery0 = ControllerComponent::getSession('requisites', ['delivery_type' => '']);
        $delivery = $delivery0['delivery_type'];

        if(empty($delivery) || $total > 15000 || (strcasecmp($delivery,'pickup') == 0)) {
            return 0;
        } else {
            return 500;
        }        
    }



  

  

}