<?php

defined('ABS_PATH') or die;

/**
 * Файл настроек
 */

//> Константы для обращения к контроллерам
define('PathPrefix', 'controllers/');
define ('PathPostfix', 'Controller.php');
//<

// > Используемый шаблон
$template = 'default';

// Пути к файлам шаблонов (*.tpl)
define ('TemplatePrefix', "views/{$template}/");
define ('TemplatePostfix', '.tpl');

// ваш секретный ключ
define ('RECAPTCHA', '6Le-w4QUAAAAANbK-mlGEJVBIjVyjhk3pImByPFp');


