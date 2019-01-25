<?php

defined('ABS_PATH') or die;

class ImagesModel extends ModelComponent
{

    public static function tableName()
    {
        return 'images';
    }


    public function addListImage(&$list)
    {
        $ids = array_column($list, 'id');  
        if(empty($ids)) {
            return false; 
        }

        $where = [
            'AND',
            ['field' => 'book_id', 'type' => 'IN', 'value' => $ids],
            ['field' => 'is_cover', 'type' => '=', 'value' => 1],
        ];
        $images = $this->getList($where, ['book_id', 'img']);  
        if(!$images || empty($images)) {
            return false;
        }
              
        $newImg = array_column($images, 'img', 'book_id');

        foreach($list as &$item) { 
            if(isset($newImg[$item['id']])) {
                $item['image'] = $newImg[$item['id']];
            } 
        }
        
    }


}