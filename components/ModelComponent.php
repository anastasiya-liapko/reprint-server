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
     * $values array  ['name' => 'Книга', 'order' => 1] 
     */
    public function insert(array $values)
    {
        $tableName = $this->getTableName();
        
        $fields1 = $fields2 = $fields3 = []; 
        foreach($values as $field => $val) {
            $fieldEsc = $this->validField($field);
            if(!$fieldEsc) { continue; }
            $fields1[] = $fieldEsc;
            $fields2[':'.$field] = $val;
            $fields3[] = ':'.$field;
        }

        if(empty($fields1)) {
            return false;
        }

        $stmt = $this->db->prepare('INSERT INTO '. $tableName .' ('.implode(', ', $fields1).') VALUES ('.implode(', ', $fields3).')');
        foreach($fields2 as $f => $v){
            if(is_null($v)) {
                $stmt->bindValue($f, $v, PDO::PARAM_NULL); 
            } else {
                $stmt->bindValue($f, $v);
            }            
        }
        $stmt->execute();
        return $this->db->lastInsertId();        
    }



    /**
     * @$values array  
     *  [
     *      ['name' => 'Колобок', 'order' => 1],
     *      ['name' => 'Три поросёнка', 'order' => 3],
     *  ] 
     */
    public function insertMultiple(array $values)
    {
        $tableName = $this->getTableName(); 
        
        $firstArr = $values[key($values)];
        if(!is_array($firstArr)) {
            return false;
        }

        $allVal = $fieldsEsc = $rows = $filds = [];

        foreach($firstArr as $field => $val){
            $fieldEsc0 = $this->validField($field);
            if(!$fieldEsc0) { continue; }
            $fields[] = $field;
            $fieldsEsc[] = $fieldEsc0;
        } 
        
        if(empty($fields)) {
            return false;
        }        
        
        $i = 0;
        foreach($values as $arr) {
            if(!is_array($arr)) {
                continue;
            }
            $item = [];
            foreach($fields as $field) {
                $item[] = ':i'.$i; 
                if(!array_key_exists($field, $arr)) { return false; }
                $allVal[':i'.$i] = $arr[$field];
                $i++;      
            }
            $rows[] = '('. implode(', ', $item) .')';     
        }
        
        if(empty($allVal)) {
            return false;
        }

        $sql = 'INSERT INTO '. $tableName .' ('.implode(',', $fieldsEsc).') VALUES '.implode(', ', $rows);

        $stmt = $this->db->prepare($sql);
        foreach($allVal as $f => $v){
            if(is_null($v)) {
                $stmt->bindValue($f, $v, PDO::PARAM_NULL); 
            } else {
                $stmt->bindValue($f, $v);
            }            
        }        
        $stmt->execute();
        $lastInsertId =  $this->db->lastInsertId();
        return $lastInsertId;   
    }




    
    
 


   


}