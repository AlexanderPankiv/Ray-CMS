<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; windows-1251" />
	<title><?=$data['title']?></title>
	<meta name="title" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="<?=$config['url_conf']?>admin/style.css" type="text/css" media="screen, projection" />
	<script language="javascript" type="text/javascript" src="<?=$config['url_conf']?>js/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="<?=$config['url_conf']?>js/admin.js"></script>
	<script type="text/javascript" src="<?=$config['url_conf']?>js/ckeditor/ckeditor.js"></script>


</head>

<body>
<table width="100%">
<tr><td>
<div id="wrapper">

	<div id="header">
		<a href="<?=$config['url_conf']?>admin.php?act=logout"><?=$data['logout']?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=$config['url_conf']?>"><?=$data['to_home']?></a>
	</div><!-- #header-->

	<div id="middle">

		<div id="container">
			<div id="content">
				<?=$data['main']?>
				&nbsp;
			</div><!-- #content-->
		</div><!-- #container-->

		<div class="sidebar" id="sideLeft">
			<?=$data['left']?>
		</div><!-- .sidebar#sideLeft -->

	</div><!-- #middle-->

</div><!-- #wrapper -->
</td></tr>
</table>


</body>
</html>
