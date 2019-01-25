<?php

/**
 * Модель для таблицы постов
*/

defined('ABS_PATH') or die;

class ProductsModel extends ModelComponent
{

    public static function tableName()
    {
        return 'books';
    }


    public function getAttributes($id, $type)
    {
        if(!in_array($type, ['cover', 'format', 'type'])) {
            return false;
        }

        $fields = $type.'s';
        //$field = mb_substr($type, 0, (mb_strlen($type, 'UTF-8') - 1), 'UTF-8') .'_id';

        $sql = 
        'SELECT f.`name`, f.id, bf.price, bf.is_default, f.default_price df 
        FROM '.$fields.' f
        INNER JOIN book_'.$fields.' bf ON f.id = bf.'.$type.'_id
        WHERE bf.book_id = :id
        ORDER BY f.orderby';  

        $stmt = $this->db->prepare($sql); 
        $stmt->execute(['id' => (int)$id]);
        $result = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;          
        }

        return $result; 
    }


}