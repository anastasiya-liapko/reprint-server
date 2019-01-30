<?php


defined('ABS_PATH') or die;

class ControllerComponent
{
    public $smarty;
    private $body; 
    private $jsCode = [];


    public function __construct()
    {
        
        define('SMARTY_DIR', str_replace("\\", "/", ABS_PATH) .'/library/Smarty/libs/');       
   
        require_once (SMARTY_DIR . 'Autoloader.php'); 
        Smarty_Autoloader::register(true);
        require_once (SMARTY_DIR . 'Smarty.class.php'); 
        $this->smarty = new Smarty();        

        $this->smarty->setTemplateDir(TemplatePrefix);
        $this->smarty->setCompileDir('../tmp/templates_c');
        $this->smarty->setCacheDir('../tmp/cache');
        $this->smarty->setConfigDir('../library/Smarty/configs'); 
        $this->smarty->assign('pageTitle', 'Reprint');              

    }
/*
    protected function loadTemplate($templateName)
    {
        $this->body = $templateName . TemplatePostfix;
    }*/  

    public static function redirect($arr = [])    
    {        
        $url = '/';
        if(is_array($arr) && !empty($arr)) {
            $url = '/index.php?'. http_build_query($arr);
        }

        header($_SERVER["SERVER_PROTOCOL"].' 200 OK');
        header('Location: http://'.$_SERVER['HTTP_HOST'] . $url);
        exit();
    }

    public static function link($params = [], $replaceParams = false)
    {
        $url = '/';
        if(is_array($params) && !empty($params)) {
            if(is_array($replaceParams)) {
                $params = array_merge($params, $replaceParams);
            }
            $url = '/index.php?'. http_build_query($params, false, '&amp;');
        }

        return $url; 
    }

    protected function page404()
    {
        header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
        $this->loadTemplate('error'); 
    }    


    public static function getSession($key, $default = false)
    {
        if(isset($_SESSION) && isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public static function setSession($key, $val)
    {      
        if(isset($_SESSION)) {             
            $_SESSION[$key] = $val;                       
        }     
    }

    public static function clearSession()
    {
        session_destroy();
    }

    public function addJsCode($js = '')
    {
        $this->jsCode[] = $js;
    }
 
    protected function loadTemplate($templateName)
    {
        //Сделать универсальный механизм работы с модулями
        (new CartModule($this->smarty))->index();
        (new CategoriesModule($this->smarty))->index();      

        $controller = RoutedComponent::getController();
        $action = RoutedComponent::getAction();      

        if($controller == 'index' && $action == 'index'){
            $header =  'headerFirst'. TemplatePostfix;;
        } else {
            $header =  'headerSecond'. TemplatePostfix;
        }     

        $this->smarty->assign('jsCode', $this->jsCode); 
  
        $this->smarty->assign('header', $header);  
        $this->smarty->assign('body', $templateName . TemplatePostfix);
        $this->smarty->assign('footer', 'footer' . TemplatePostfix);
       

        $this->smarty->display('template' . TemplatePostfix);
    }

    

   

    

}

