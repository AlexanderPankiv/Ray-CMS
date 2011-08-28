<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{$title}</title>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
     
    <link rel="stylesheet" href="<?=$config['url_conf']?>css/style.css" type="text/css" />
	
	<script type="text/javascript" src="<?=$config['url_conf']?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$config['url_conf']?>js/functions.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header">
			
			<div id="lang_panel">
				<a href=""><img src="images/flag_ukr.png"/></a>
				<a href="rus"><img src="images/flag_rus.png"/></a>
			</div>
		   	<div id="top_nav">
        	</div>
		</div>
		<div id="content">
			<div class="side_col">
			</div>
			<div class="center_col">
				{include file="navigation.tpl"}
			</div>
			<div class="side_col">
			</div>
			<br clear="all"/>			
		</div>
		<div id="footer">
			<div id="footer_inner">
				<div id="f_left"></div>
				<div id="f_right"></div>
				<div id="bottom_nav"></div>
			</div>
		</div>
	</div>	
</body>

</html>
