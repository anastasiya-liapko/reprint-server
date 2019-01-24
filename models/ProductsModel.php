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
        if(!in_array($type, ['covers', 'formats', 'types'])) {
            return false;
        }

        $field = mb_substr($type, 0, (mb_strlen($type, 'UTF-8') - 1), 'UTF-8');

        $sql = 
        'SELECT f.`name`, f.id, bf.price, bf.is_default, f.default_price df 
        FROM '.$type.' f
        INNER JOIN book_'.$type.' bf ON f.id = bf.'.$field.'_id
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