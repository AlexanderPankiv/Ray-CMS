<?php
error_reporting(E_ALL);

require_once('includes/config.php');
require_once('includes/system.php');
require_once('includes/lib.php');


/////
// Connect to DB
/////

$db=mysql_connect($g_config['db_host'],$g_config['db_user'], $g_config['db_pass']);
mysql_select_db($g_config['db_name'], $db);
mysql_query("SET NAMES 'utf8'");

$serv_name = $_SERVER['SERVER_NAME'];;
$serv_name=preg_replace('/^www\./si','',$serv_name);
$config['serv_name']=$serv_name;
global $skin_name;
$skin_name='default';

global $lang,$url_lang,$url_lang_conf,$content;
$lang=!empty($_GET['lang']) ? $_GET['lang'] : $g_config['def_lang'];

require_once('includes/lang/'.$lang.'.php');

$config['lang']=$lang;
$config['langs']=$g_config['langs'];
$config['lang_arr']=$lang_arr;

$config['url_conf']=$g_config['root_path'];
$config['url_conf_lang']=$lang==$g_config['def_lang'] ? $config['url_conf'] : $config['url_conf'].$lang.'/';

/////
// User log in/out check
/////
global $user, $errors, $content, $logger;

$_POST['user_remember']=(empty($_POST['user_remember'])) ? 'false' : $_POST['user_remember'];



if(!empty($_COOKIE['login'])&&!empty($_COOKIE['pass'])){
	$user=check_user_login($_COOKIE['login'],$_COOKIE['pass'],'true','cook');
}
elseif(!empty($_COOKIE['fb_id'])){
	$user=check_fb_user_login($_COOKIE['fb_id']);
}
elseif(!empty($_COOKIE['vk_id'])){
	$user=check_vk_user_login($_COOKIE['vk_id']);
}
elseif(!empty($_POST['user_username'])&&!empty($_POST['user_pass'])&&!$user['logged_in']){
	$user=check_user_login($_POST['user_username'],$_POST['user_pass'],$_POST['user_remember'],'post');	
}
if((!empty($_POST['user_logout']) && ($_POST['user_logout']=='true'))||((!empty($_GET['act']))&&($_GET['act']=='logout')&&(empty($_POST['user_username'])))){
	$user=user_logout();
    header("location: {$config['url_conf_lang']}");
}
?>