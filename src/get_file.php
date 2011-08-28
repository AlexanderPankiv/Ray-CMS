<?
	require_once('definitions.php');
	$type=g('type');
	$id=g('id');
	$res=sql_do("SELECT file FROM $type WHERE id=$id");	
	if($q=mysql_fetch_array($res)){
		header("Content-Type: application/x-download\n");
		header("Content-Disposition: attachment; filename={$q['file']}");
		$file=readfile("uploads/type/{$q['file']}");
		echo $file;
	}
?>