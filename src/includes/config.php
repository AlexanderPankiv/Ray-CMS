<?
	global $g_config, $cache_time;
	$g_config['db_host']='localhost';
	$g_config['db_user']='root';
	$g_config['db_pass']='';
	$g_config['db_name']='bizcar';
	$g_config['root_path']='/';
	$g_config['per_page']='10';
	$g_config['langs']=array('ukr','rus');
	$g_config['def_lang']='ukr';
    
    $cache_time=array(
        'main'=>3600,
        'pages'=>86400,
        'view'=>1800
    );    
?>
