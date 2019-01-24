<?php

defined('ABS_PATH') or die;

class RoutedComponent 
{    
    public function __construct()
    {
        $params = $_GET;

        $class = 'IndexController';
        $method = 'indexAction';  

        if(isset($params['controller']) ) {
            $class0 = $this->correctName($params['controller'], 'Index') . 'Controller'; 

            if(class_exists($class0, true)) {
                $class = $class0; 
            }          

            if(isset($params['action']) ) {
                $method0 = $this->correctName($params['action'], 'index') . 'Action';  
                if(method_exists($class, $method0)) {
                    $method = $method0;
                }                
            } 

        }

        (new $class)->$method();  
    }  

    private function correctName($name, $default)
    {
        $name = (string)$name;
        $name = preg_replace('|[^a-zA-Z0-9_]|', '', $name);
        if(empty($name)) {
            return $default;
        }
        return ucfirst( strtolower($name) );
    }


    public function __destruct()
    {
        DBcomponent::close();
    }

}