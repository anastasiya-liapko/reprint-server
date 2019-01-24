<?php

include "visual.php";

include "sql.php";

session_start();
header('Content-type: text/html; charset=utf-8');

function isset2($var)
{
		return isset($var) && $var!="";
}

foreach ($_REQUEST as $k=>$v)
{
	if($v=="NULL")
	{
		$_REQUEST[$k] = null;
	}
}


if(isset($_SESSION['user']))
{
	require_once __DIR__."/../menu.php";
	if($mysql_user_table!="")
	{
		$users = q("SELECT * FROM `{$mysql_user_table}` WHERE id=?", [$_SESSION['user']['id']]);
		if(count($users)<1)
		{
			session_destroy();
		}
		else
		{
			$_SESSION['user'] = $users[0];
		}
	}

}

if(isset($_REQUEST['authorize']) && $_REQUEST['authorize']==1) // Если пользователь пытается залогиниться
{
    $mail = $_REQUEST['mail'];
    $pass = $_REQUEST['pass'];

    $user = engineLoginAttempt($mail, $pass); // возвращает либо FALSE либо все данные пользователя, взятые из БД
    if($user !== FALSE) // Если пользователь ввел правильные логин и пароль
    {
        $_SESSION['user'] = $user; // сохраняем все его данные в сессию — потом пригодятся
        header("Location: index.php");
    }
}


if(!isset($_SESSION['user']))  // Обрубаем незалогиненых чуваков
{
    die(renderAuth());
}



function select_mapping($json, $value)
{
	$list = json_decode($json, true);
	foreach($list as $item)
	{
		if($item['value']=="NULL")
		{
			$item['value'] = null;
		}

		if($item['value']==$value)
		{
			return $item['text'];
		}
	}
}

function pagination($rows)
{
	include "engine/classes/Pagination/Pagination.class.php";


	$page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
	$start = ($page-1)*$RPP;

	$pagination = (new Pagination($page, $rows));
	$pagination->setRPP(RPP);
	return $pagination->parse(); // Генерируем пагинацию


}



// Попытка залогиниться
// возвращает либо FALSE либо все данные пользователя, взятые из БД
function engineLoginAttempt($mail, $pass)
{
	require_once __DIR__."/../menu.php";
	if($mysql_user_table!="")
	{
		$users = q("SELECT * FROM `{$mysql_user_table}` WHERE `{$mysql_user_login}` = :mail AND `{$mysql_user_pass}`=MD5(:pass)", array('mail'=>$mail, 'pass'=>$pass));
		if(count($users)!=0)
		{
			return $users[0];
		}
		else
		{
			return FALSE;
		}
	}else
	{
		if($mysql_user_login==$mail && $mysql_user_pass==$pass)
		{
			return ["login"=>$mysql_user_login, "admin"=>1];
		}
		else
		{
			return FALSE;
		}
	}

}

// Создание сообщение вывода
function buildMsg($msg, $class = "success"){
    $_SESSION['messages'][] = array('text' => $msg, 'class' => $class);
}

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function youtubeCode($url)
{

	preg_match("/^((https?:\/\/)?(w{0,3}\.)?youtu(\.be|(be|be-nocookie)\.\w{2,3}\/))((watch\?v=|v|embed)?[\/]?(?P<video>[a-zA-Z0-9-_]{11}))/si", $url, $matches);

if (strlen($matches['video']) == 11)
  {
    return '<iframe width="360" height="203" src="//www.youtube.com/embed/' . $matches['video'] . '" frameborder="0" allowfullscreen></iframe>';
  } else
  {
    return '<span style="color:red;">Видео не найдено</span>';
  }
}

function fixColor($color)
{
	if(preg_match('/^#[a-f0-9]{6}$/i', $color))
	{
		$color = substr($color, 1);
	}
	else if(preg_match('/^[a-f0-9]{6}$/i', $color))
	{

	}
	else
	{
		$color = '777777';
	}
	return $color;
}
