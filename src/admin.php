<?
header('Last-Modified: ' . gmdate('r'));
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
require_once('definitions.php');
require_once('includes/formsgen.php');
global $config, $skin_name;
$skin_name='admin';
$time_start=microtime_float();


global $user, $admin_modules, $errors, $logger, $queries;

if($user['is_admin']==0){
	$user=user_logout();
}
if(($user['is_admin']==1)){
	$user_group=$user['group'];
	if(!empty($_POST['config'])){
		write_config($_POST['config']);
	}
	$query_conf='';
	$res=sql_do("SELECT admin_modules.*,a_g.name AS group_name
				FROM admin_modules
				LEFT JOIN admin_mod_groups AS a_g ON a_g.id=admin_modules.group
				WHERE admin_modules.id>0 $query_conf
				ORDER BY a_g.order_id,a_g.name,admin_modules.order_id");
	$tmp=''; $i=0;$j=0;
	ob_start();
	while($q=mysql_fetch_array($res)){
		if($user['group_code']=='root' || !empty($user['admin_rights']['edit'][$q['id']]) || !empty($user['admin_rights']['view'][$q['id']])){
			if($tmp!=$q['group_name']){
				$tmp=$q['group_name'];
				if($i!=0 && $j!=0){
					?></div></fieldset><?
				}
				?><fieldset class="modules_block">
	            <div class="modules_block_legend opened_group" id="legend_<?=$q['group']?>" onclick="slide_block('group_',<?=$q['group']?>)"><?=$q['group_name']?></div>
				<div class="admin_group_block" id="group_<?=$q['group']?>"><?
				$j++;
			}
			?><a href="<?=$config['url_conf']?>admin.php?mod=<?=$q['module_id']?>" class="admin_modules_list"><?=$q['name']?></a><?
		$i++;
		}
	}
	if($j!=0){
		?></div></fieldset><?
	}
	$left_frame=ob_get_contents();
	ob_end_clean();
	$data['title']='Administration';
	$data['logout']='Logout';
	$data['to_home']='Home';
	$data['left']=$left_frame;
	$data['main']='';

	if(!empty($_GET['mod']) && (!preg_match('/\.|\//',$_GET['mod']))){
		$res=sql_do("SELECT * FROM admin_modules WHERE module_id='".mysql_escape_string($_GET['mod'])."'");
		if($q=mysql_fetch_array($res)){
    		if($user['group_code']=='root' || !empty($user['admin_rights']['edit'][$q['id']]) || !empty($user['admin_rights']['view'][$q['id']])){
    			$data['mod_mode']=($user['group_code']=='root' || !empty($user['admin_rights']['edit'][$q['id']])) ? 'edit' : 'view';
    			$data['module']=$q['module_id'];
    			$data['action']='admin.php?mod='.$q['module_id'];
				if(file_exists('admin/modules/'.$_GET['mod'].'.php')){
					$data['title'].=' :: '.$q['name'];
					$data['main'].='<fieldset class="main_box"><legend>'.$q['name'].'</legend>';
					ob_start();
			    	include('admin/modules/'.$_GET['mod'].'.php');
			    	if($q['extra']==1){
			    		include('admin/modules/universal.php');
			    	}
			    	$data['main'].=ob_get_contents();
			    	ob_end_clean();
			    	$data['main'].='</fieldset>';
				}
				else{
					$data['main']='<span class="error">Ошибка! Файл модуля не найден!</span>';
				}
    		}
    		else{
    			$data['main']='<span class="error">Ошибка! Вам запрещен доступ к этому модулю!</span>';
    		}
    	}
    	else{
    		$data['main']='<span class="error">Ошибка! Модуль не существует!</span>';
    	}
	}
	else{
		$data['main'].='<fieldset class="main_box"><legend>Administration home</legend>';
		$data['action']='admin.php?mod=admin_main';
		$data['mod_mode']='edit';
    	ob_start();
    	include('admin/modules/admin_main.php');
    	$data['main'].=ob_get_contents();
    	ob_end_clean();
    	$data['main'].='</fieldset>';
	}
	include('admin/skin.php');
}else{
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="uk" lang="uk">
<head>
	<title>Адміністрування</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" href="admin/style.css" type="text/css" />
</head>
<body>
		<table width="100%"><tr><td>
	<table width="300"><tr><td><?
	$frm =new InputForm ('', 'post', 'OK :)',2,'', '', '', 'login');
	$frm->addbreak('Доступ заборонено. Авторизируйтесь:');
	$frm->simple_form_row('Логін:', $frm->text_box('user_username', ''));
	$frm->simple_form_row('Пароль:', $frm->text_box('user_pass', '',0,0,true,''));
	$frm->simple_form_row('Не варто:', $frm->checkbox('user_remember', 'true','Запам’ятати мене'));
	$frm->show();
	?></td></tr></table></td><td></td><td width="300" id="help">

		</td></tr></table>
</body>
</html>
<?
}


/////
// Process errors and logz
/////
$log_string='';
if (!empty($logger)){
	foreach($logger as $log_id => $log_data){
		$log_string.=$log_id.' -> '.$log_data.'<br>';
	}
	$query='INSERT INTO `logs` (`time_added`, `log_data`) VALUES (\''.time().'\', \''.$log_string.'\');';
	$res=mysql_query($query);
}
$error_string='';
if (!empty($errors)){
	foreach($errors as $err_id => $err_data){
		$error_string.=$err_id.' -> '.$err_data.'<br>';
	}
}
$queries_string='';
if (!empty($queries)){
	foreach($queries as $q_id => $q_data){
		$queries_string.=$q_id.' -> '.$q_data.'<br>';
	}
}
echo '<small><b>Errors:</b><br>'.$error_string.'</small>';
echo '<small><b>Queries:</b><br>'.$queries_string.'</small>';
echo '<small><b>Logz writed:</b><br>'.$log_string.'</small>';
echo '<small><b>Generation time: </b>'.round(microtime_float() - $time_start, 3).'sec</small>';

?>
