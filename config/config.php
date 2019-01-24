<?php

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
// <

//> Инициализация шаблонизатора Smarty
// put full path to Smarty.class.php
/*
require('./library/Smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir(TemplatePrefix);
$smarty->setCompileDir('../tmp/templates_c');
$smarty->setCacheDir('../tmp/cache');
$smarty->setConfigDir('../library/Smarty/configs');
*/
// $smarty->error_reporting = E_ALL & ~E_NOTICE;
//<