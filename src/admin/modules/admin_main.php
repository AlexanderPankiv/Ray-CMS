<?
	 $q_conf='';
	?><div style="margin: 10px;">Ласкаво просимо, <b><a href="admin.php?mod=user_profile"><?=$user['first_name']?></a></b>. Ви ввійшли в систему як <b><?=$user['group_name']?></b>.</div><?
	#$res=sql_do("SELECT COUNT(id) AS cnt FROM requests WHERE processed=0");
	#if($q=mysql_fetch_array($res)){
	#	if($q['cnt']>0){
	#		echo 'Кількість неопрацьованих запитів: <a href="admin.php?mod=admin_requests&show=2">'.$q['cnt'].'</a>';
	#	}
	#}
 ?>
