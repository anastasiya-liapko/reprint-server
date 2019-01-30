<?php

defined('ABS_PATH') or die;

class RoutedComponent 
{    
    private static $controller;
    private static $action;

    public function __construct()
    {        
        $controller = filter_input(INPUT_GET, 'controller', FILTER_VALIDATE_REGEXP, ['options' => ['default' => 'index', 'regexp' => '/^[a-zA-Z_][a-zA-Z0-9_]+$/']]);
        $controller = strtolower($controller);
        $class = ucfirst($controller). 'Controller';

        if(!class_exists($class, true)) {
            $class = 'IndexController'; 
        }

        $action = filter_input(INPUT_GET, 'action', FILTER_VALIDATE_REGEXP, ['options' => ['default' => 'index', 'regexp' => '/^[a-zA-Z_][a-zA-Z0-9_]+$/']]);
        $action = strtolower($action);
        $method = $action.'Action'; 
        if(!method_exists($class, $method)) {
            $method = 'indexAction';
        }
        
        $this->setParams($controller, $action);

        (new $class)->$method();  
    } 
    
    private function setParams($controller, $action)
    {
        self::$controller = $controller;
        self::$action = $action; 
    }

    public static function getController()
    {
        return self::$controller;
    }

    public static function getAction()
    {
        return self::$action;
    } 


    public function __destruct()
    {
        DBComponent::close();
    }

}