<?php
header('Last-Modified: ' . gmdate('r'));
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
require_once('definitions.php');
require_once('includes/smarty/tpl.php');

$time_start=microtime_float();

global $module;
$module=(!empty($_GET['mod'])) ? $_GET['mod'] : 'main';

$tpl = new Tpl();
$tpl->data['module'] = $module;
$tpl->data['r_uri']=preg_replace('/^\/(?:rus|eng)/si','',$_SERVER['REQUEST_URI']);

require_once('modules/navigation.php'); //if needed
require_once('modules/'.$module.'.php');

/////
// Output the result
/////
$tpl->Show('skin');
//not! parse_skin($skin_name);
/////
// Process errors and logz
/////


$config['show_runtime']=1;
if(!empty($config) && $config['show_runtime']=='1'){
	global $errors, $queries;	
	$error_string='';
	if (!empty($errors)){
		foreach($errors as $err_id => $err_data){
			$error_string.=$err_id.' -> '.$err_data.'<br>';
		}
		echo '<small><b>Errors:</b><br>'.$error_string.'</small>';
	}
	$queries_string='';
	if (!empty($queries)){
		foreach($queries as $q_id => $q_data){
			$q_data=preg_replace('/\r\n/si','<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$q_data);
			$queries_string.=$q_id.' -> '.$q_data.'<br>';
		}
		echo '<small><b>Queries:</b><br>'.$queries_string.'</small>';	
	}	
	echo '<small><b>Generation time: </b>'.round(microtime_float() - $time_start, 6).'sec</small>';
}
?>
