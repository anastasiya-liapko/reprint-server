<?php


defined('ABS_PATH') or die;

class ControllerComponent
{
    public $smarty;
    private $body; 


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
            $url = '/index.php?'. http_build_query($params);
        }

        return $url; 
    }

    protected function page404()
    {
        header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found');
        $this->loadTemplate('error'); 
    }

    /**
     * $page - текущая страница
     * $total - общее число элементов
     * $limit - число элементов на странице
     * $link_params - параметры для формирования ссылок 
     * $othersParams - настройки визуализации
     */
    public static function pagination($page, $total, $limit, $link_params, $othersParams = [])
    {
        $num_pages = ceil($total / $limit); 
        if($num_pages < 2) { 
            return '';
        }

        $defaultParams = [
            'text_first' => '&lt;&lt;',
            'text_last' => '&gt;&gt;',
            'text_next' => '&gt;',
            'text_prev' => '&lt;',
            'num_links' => 8,   //максимальное число отображаемых страниц
            'cssLink' => '',
            'cssArrowLink' => '',
            'cssActive' => 'active',
            'cssBlock' => 'pagination',
        ];

        $params = array_merge($defaultParams, $othersParams);

        $output = '<ul class="'.$params['cssBlock'].'">';

        if ($page > 1) {
            if($params['text_first']) {             
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' .  self::link($link_params, ['page' => 1]) . '">' . $params['text_first'] . '</a></li>';
            }            			
            
            if($params['text_prev']) {                
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' . self::link($link_params, ['page' => $page - 1]) . '">' . $params['text_prev'] . '</a></li>';
            }			
		}

        if ($num_pages <= $params['num_links']) {
            $start = 1;
            $end = $num_pages;
        } else {
            $start = $page - floor($params['num_links'] / 2);
            $end = $page + floor($params['num_links'] / 2);

            if ($start < 1) {
                $end += abs($start) + 1;
                $start = 1;
            }

            if ($end > $num_pages) {
                $start -= ($end - $num_pages);
                $end = $num_pages;
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($page == $i) {
                $output .= '<li><span class="'.$params['cssActive'].'">' . $i . '</span></li>';
            } else {
                $output .= '<li><a class="'.$params['cssLink'].'" href="' . self::link($link_params, ['page' => $i]) . '">' . $i . '</a></li>';                
            }
        }

        if ($page < $num_pages) {
            if($params['text_next']) {
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' . self::link($link_params, ['page' => $page + 1]) . '">' . $params['text_next'] . '</a></li>';
            }
            
            if($params['text_last']) {         
                $output .= '<li><a class="'.$params['cssArrowLink'].'" href="' . self::link($link_params, ['page' => $num_pages]) . '">' . $params['text_last'] . '</a></li>';
            }
		}

        $output .= '</ul>';

        return $output;

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
  
        $this->smarty->assign('header', $header);  
        $this->smarty->assign('body', $templateName . TemplatePostfix);
        $this->smarty->assign('footer', 'footer' . TemplatePostfix);
       

        $this->smarty->display('template' . TemplatePostfix);
    }

    

   

    

}

