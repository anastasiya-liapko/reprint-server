<?php

defined('ABS_PATH') or die;

class ModelComponent {

    protected $db;
    private $count = null;

    public function __construct()
    {        
        $this->db = DBComponent::getInstance();
    }
    
    private function validField($var)
    {
        if(preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $var)) {
            return '`'.$var.'`'; 
        } 
        return false; 
    }

    private function whereSearchFeld($field, &$i, &$params, &$arrWhere)
    {
        $type = ['in', 'not in', 'IN', 'NOT IN', '>', '<', '<>', '=', '<=', '>=', '<=>', 'LIKE', 'NOT LIKE'];

        if(is_array($field) && isset($field['field']) && ($fieldEsc = $this->validField($field['field'])) && isset($field['type']) && in_array($field['type'], $type) && isset($field['value']) ) { 
            
            
            $in_notIn = ['in', 'not in', 'IN', 'NOT IN'];

            if(in_array($field['type'], $in_notIn)) {
                $arrWhere2 = [];
                foreach((array)$field['value'] as $v) {
                    $arrWhere2[] = ':w'.$i;
                    $params['w'.$i] = $v;
                    $i++;
                }
                $arrWhere[] = $fieldEsc . ' '.$field['type'].' ('.implode(', ',$arrWhere2) .')'; 
            } else {
                $arrWhere[] = $fieldEsc . ' '.$field['type'].' :w'.$i; 
                $params['w'.$i] = $field['value'];
            }
            return true;                    
        }
        return false; 
    }

    private function whereParse($where, &$i, &$params, &$arrWhere)
    {
        $separator = 'AND'; 
        $arrSeparotors = ['AND', 'OR']; 

        foreach($where as $field) {
            if(is_string($field) && preg_grep('/'.$field.'/i', $arrSeparotors)) {
                $separator = $field;
                continue; 
            }
            $this->whereSearchFeld($field, $i, $params, $arrWhere);               
                   
            $i++;
        }
        return $separator;
    }

    private function normalizeSelect($select)
    {
        $s = '*';   
        if(is_array($select) || is_string($select)) {
            $select2 = [];
            foreach((array)$select as $item) {
                $res = $this->validField($item);
                if($res) {
                    $select2[] = $res;
                }                    
            }
            $s = implode(', ', $select2); 
        } 
        return $s;
    }

    private function getTableName()
    {
        $class = get_class($this);    
        $tableName = $class::tableName();    
        if(!$tableName) { 
            return false; 
        }
        return '`' . $tableName . '`';
    }
    

    public function getCount()
    {
        return $this->count; 
    }


    /**
    *    $where      array 
    *        ['field'=>'id', 'type'=> '=', 'value'=> 3 ] 
    *            или 
    *        [ 
    *            ['field'=>'id', 'type'=> 'IN', 'value'=> [1, 2, 4] ],
    *            ['field'=>'name', 'type'=> 'LIKE', 'value'=> '%Конт%' ],
    *            'OR'            
    *        ]
    *    $select    array|string
    *    $order     array   ['name' => 'desc', 'id' => 'asc']
    *    $limit     array|int   [0, 10]  или 5 
    *    $count     bool  выводить ли возможное количество элементов. После чего вызывайте getCount()
    */
    public function getList($where = false, $select = false, $order = false, $limit = false, $count = false)
    {
        $tableName = $this->getTableName();
        $s = $this->normalizeSelect($select); 
        $params = [];         

        $w = '';        
        if(is_array($where)) {  
            $arrWhere = [];
            
            $i = 0;
            $separator = 'AND'; 

            if(!$this->whereSearchFeld($where, $i, $params, $arrWhere) ) {
                $separator = $this->whereParse($where, $i, $params, $arrWhere);
            }
            
            if(!empty($arrWhere)) {
                $w = ' WHERE '. implode(' '.$separator.' ', $arrWhere); 
            }                              
        }

        $o = '';
        if(is_array($order)) { 
            $order2 = [];
            foreach($order as $field => $value) {
                if( (strcasecmp('asc', $value) === 0 || strcasecmp('desc', $value) === 0) && ( $field2 = $this->validField($field) )) {
                   $order2[] = $field2 . ' ' . $value;
                }
            } 
            if(!empty($order2)) {
                $o = ' ORDER BY ' . implode(', ', $order2) ;
            }
        }

        $l = '';        
        if(is_numeric($limit) || is_array($limit)) {
            $limit2 = array_slice((array)$limit, 0, 2);
            $limit3 = [];
            foreach($limit2 as $item) {
                $limit3[] = (int)$item;
            }
            $l = ' LIMIT ' . implode(', ', $limit3);                
        } 

        $c = (($count && $limit) ? ' SQL_CALC_FOUND_ROWS ' : '');

        //myLog($sql, 'sql');
        $stmt = $this->db->prepare('SELECT '. $c . $s .' FROM '. $tableName . $w . $o . $l); 
        $stmt->execute($params);
        $result = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;          
        }

        if($count && $limit) {
            $stmt2 = $this->db->query('SELECT FOUND_ROWS()');        
            $this->count = $stmt2->fetchColumn();
        }

        return $result; 
    }

    /**
    *    $where      array 
    *        ['field'=>'id', 'type'=> '=', 'value'=> 3 ] 
    *            или 
    *        [ 
    *            ['field'=>'id', 'type'=> 'IN', 'value'=> [1, 2, 4] ],
    *            ['field'=>'name', 'type'=> 'LIKE', 'value'=> '%Конт%' ],
    *            'OR'            
    *        ]
    *    $select    array|string        
    */
    public function getItem($where = false, $select = false)
    {
        $tableName = $this->getTableName(); 
        $s = $this->normalizeSelect($select); 
        $params = [];

        $w = '';        
        if(is_array($where)) {  
            $arrWhere = [];
            
            $i = 0;
            $separator = 'AND'; 

            if(!$this->whereSearchFeld($where, $i, $params, $arrWhere) ) {
                $separator = $this->whereParse($where, $i, $params, $arrWhere);
            }
            
            if(!empty($arrWhere)) {
                $w = ' WHERE '. implode(' '.$separator.' ', $arrWhere); 
            }                           
        }

        $stmt = $this->db->prepare('SELECT '. $s .' FROM '. $tableName . $w . ' LIMIT 1'); 
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @$values array  ['name' => 'Книга', 'order' => 1] 
     * не проверял этот метод
     */
    public function insert(array $values)
    {
        $tableName = $this->getTableName();
        
        $filds1 = $filds2 = []; 
        foreach($value as $field => $val) {
            $fieldEsc = $this->validField($field);
            if(!$fieldEsc) { continue; }
            $filds1[] = $fieldEsc;
            $filds2[] = ':'.$field;       
        }

        if(!empty($filds1)) {
            return false;
        }

        $stmt = $this->db->prepare('INSERT INTO '. $tableName .' ('.implode(',', $filds1).') VALUES ('.implode(',', $filds2).') ');
        $stmt->execute($value);
        return $this->db->lastInsertId();        
    }




    
    
 


   


}