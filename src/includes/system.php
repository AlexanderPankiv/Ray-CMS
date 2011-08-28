<?php
	function mysqldo($str, $mode='html'){
		return ($mode=='html') ? mysql_escape_string($str) : mysql_escape_string($str);
	}

/////
// User management functions
/////

	function checkright($usr, $module){
		if((!empty($usr['admin'][$module]))&&($usr['admin'][$module]=='1')){
			return true;
		}else{
			return false;
		}
	}
    
    function create_user($data){
        global $errors, $logger;
        sql_insert('users', $data);
    }

    function field_validator($field_descr, $field_data, $field_type) {
        global $errors_string;
        if(!$field_data && !$field_required){ return; }
        $field_ok=false;
        $email_regexp="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
        $email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$";
        $data_types=array(
            "email"=>$email_regexp,
            "digit"=>"^[0-9]$",
            "number"=>"^[0-9]+$",
            "number_space"=>"^[0-9_- ]+$",
            "alpha"=>"^[a-zA-Z]+$",
            "alpha_space"=>"^[a-zA-Z]+$",
            "alphanumeric"=>"^[a-zA-Z0-9]+$",
            "alphanumeric_space"=>"^[a-zA-Z0-9 ]+$",
            "string"=>""
        );
        
        $field_ok = ereg($data_types[$field_type], $field_data);
        
        if (!$field_ok) {
            $errors_string.="Будь-ласка вкажіть правильне $field_descr.<br/>";
            return false;
        }else{
            return true;
        }
    }

	function check_user_login($uname, $pass, $remember, $src){
		global $errors, $logger;
		$serv_name = $_SERVER['SERVER_NAME'];
		$serv_name=preg_replace('/^www\./si','',$serv_name);

		$res=sql_do("SELECT users.*, user_groups.name AS group_name, user_groups.code AS group_code, user_groups.is_admin, user_groups.admin_rights,
					user_groups.order_id
					FROM users
					LEFT JOIN user_groups ON user_groups.id=users.group
					WHERE users.active=1 AND users.login='".mysql_escape_string($uname)."'");
		if($q=mysql_fetch_array($res,MYSQL_ASSOC)){
			$q['admin_rights']=unserialize($q['admin_rights']);

			//echo md5($pass.$q['register_date']);
			if(($src=='cook' && $pass==$q['pass']) || md5($pass.$q['register_date'])==$q['pass']){
				$user=$q;
				$user['logged_in']=true;
				$login_now=0;
				if(($remember=='true')&&($src=='post')){
					setcookie('login',$user['login'],time()+3600*24*365*5,'/',$serv_name);
					setcookie('pass',$user['pass'],time()+3600*24*365*5,'/',$serv_name);
					$logger['user_login_success']=date('D, d M Y H:i:s', time()).': Logged in from '.$_SERVER['REMOTE_ADDR'].' as '.$uname.';';
					$login_now=1;
				}elseif(($src=='post')){
					setcookie('login',$user['login'],0,'/',$serv_name);
					setcookie('pass',$user['pass'],0,'/',$serv_name);
					$logger['user_login_success']=date('D, d M Y H:i:s', time()).': Logged in from '.$_SERVER['REMOTE_ADDR'].' as '.$uname.';';
					$login_now=1;
				}
				$now=time();
				if($login_now==1){
					sql_do("UPDATE users SET last_login=$now, last_activity=$now WHERE id=".$user['id']);
				}
				else{
					sql_do("UPDATE users SET last_activity=$now WHERE id=".$user['id']);
				}
				return $user;

			}else{
				//p_r($GLOBALS);
				$errors['user_login']='User password incorrect!';
				$logger['user_login']=date('D, d M Y H:i:s', time()).': Attempt to log in from '.$_SERVER['REMOTE_ADDR'].' as '.$uname.';';
				setcookie('login','',time()-3600,'/',$serv_name);
				setcookie('pass','',time()-3600,'/',$serv_name);
			}
		}
		else{
            $errors['user_login']='User login incorrect!';
			$logger['user_login']=date('D, d M Y H:i:s', time()).': Attempt to log in from '.$_SERVER['REMOTE_ADDR'].' as '.$uname.';';
			setcookie('login','',time()-3600,'/',$serv_name);
			setcookie('pass','',time()-3600,'/',$serv_name);
		}
	}

	function check_fb_user_login($fb_id){
    	$res=sql_do("SELECT * FROM users WHERE fb_id=$fb_id");
    	if($q=mysql_fetch_array($res,MYSQL_ASSOC)){
        	$user=$q;
        	$user['logged_in']=1;
        	$now=time();
        	sql_do("UPDATE users SET last_activity=$now WHERE id=".$user['id']);
        	return $user;
    	}
	}

	function check_vk_user_login($vk_id){
    	$res=sql_do("SELECT * FROM users WHERE vk_id=$vk_id");
    	if($q=mysql_fetch_array($res,MYSQL_ASSOC)){
        	$user=$q;
        	$user['logged_in']=1;
        	$now=time();
        	sql_do("UPDATE users SET last_activity=$now WHERE id=".$user['id']);
        	return $user;
    	}
	}

	function user_logout(){
		global $errors, $logger, $user;

		$serv_name = $_SERVER['SERVER_NAME'];
		$serv_name=preg_replace('/^www\./si','',$serv_name);
		if(!empty($_COOKIE['fb_id'])){
			setcookie('fb_id','',time()-3600,'/',$serv_name);
		}
		elseif(!empty($_COOKIE['vk_id'])){
			setcookie('vk_id','',time()-3600,'/',$serv_name);
		}
		elseif(!empty($user['login'])){
			setcookie('login','',time()-3600,'/',$serv_name);
			setcookie('pass','',time()-3600,'/',$serv_name);
			$logger['user_logout']=date('D, d M Y H:i:s', time()).': User '.$user['login'].' logouted ;';
			$user['is_admin']=0;
			return $user;
		}
	}

/////
// Module management functions
/////
	function get_content($module_id = ''){
		global $errors,$module;
		$module_id = $module_id != '' ? $module_id : $module;
		
		if(file_exists('modules/'.$module_id.'.php')){
			$result='';			
			ob_start();
			require_once('modules/'.$module_id.'.php');			
			$result=ob_get_contents();
			ob_end_clean();
			return $result;
		}else{
			 $errors['get_content'.$module_id]='Module '.$module_id.' not found!';
		}
	}

	function parse_template($tpl_data, $tpl_name){
		global $errors, $skin_name, $config;
		$tpl_data['url_conf']=$config['url_conf'];
		$tpl_data['lang']=$config['lang'];
		$tpl_data['lang_arr']=$config['lang_arr'];
		$tpl_data['url_conf_lang']=!empty($config['url_conf_lang']) ? $config['url_conf_lang'] : $config['url_conf'];
		if(file_exists('skins/default/templates/'.$tpl_name.'.tpl.php')){
			ob_start();
			include('skins/default/templates/'.$tpl_name.'.tpl.php');

   		    $return = ob_get_contents();
    		ob_end_clean();
    		return $return;
		}
	}

	function parse_skin($name){
		global $errors;
		if(file_exists('skins/'.$name.'/skin.php')){			
			require_once('skins/'.$name.'/skin.php');
		}else{
			$errors['parse_skin']='Skin not found!';
		}
	}

/////
// Admin functions
/////

	function g($id, $num=0){
		if(!empty($_GET[$id])){
			if($num==1){
				if(is_numeric($_GET[$id])){
					return($_GET[$id]);
				}else{
					return 0;
				}
			}else{
				if($num==2)
				{
					return mysql_escape_string(htmlspecialchars($_GET[$id]));
				}
				return mysql_escape_string($_GET[$id]);
			}
		}else{
			if($num==1){
				return 0;
			}
			return '';
		}
	}

	function p($id, $num=0){
		if(!empty($_POST[$id])){
			if($num==1){
				if(is_numeric($_POST[$id])){
					return($_POST[$id]);
				}else{
					return 0;
				}
			}else{
				if($num==2)
				{
					return mysql_escape_string(htmlspecialchars($_POST[$id]));
				}
				return mysql_escape_string($_POST[$id]);
			}
		}else{
			if($num==1){
				return 0;
			}
			return '';
		}
	}

	function write_image($name, $path, $size=0,$max_width=0,$tmp_path=''){
		$size = $size*1024;
		$res=array();
		$res['err']=0;
		$res['status']=$res['file_name']='';

		if(isset($_FILES[$name]) && !empty($_FILES[$name]['tmp_name'])){
			$img_size = getimagesize($_FILES[$name]['tmp_name']);
			if($img_size){
				$pathinfo = pathinfo($_FILES[$name]['name']);
				$file_name = basename($_FILES[$name]['name'],'.'.$pathinfo['extension']);
				if($img_size['mime']=='image/gif' || $img_size['mime']=='image/jpeg' || $img_size['mime']=='image/png'){
					if($size==0 || $size!=0 && $_FILES[$name]['size']<=$size){
						$file_name=preg_replace('/[^a-zA-Z0-9\-_%]/si','_',$file_name);
						if(file_exists($path.$file_name.'.'.$pathinfo['extension'])){
							$file_name=rand_string(5).'_'.$file_name;
						}
						$file_name = $file_name.'.'.$pathinfo['extension'];
						if($max_width!=0 && $img_size[0]>$max_width && $tmp_path!=''){
							if(!move_uploaded_file($_FILES[$name]['tmp_name'], $tmp_path.$file_name)){
								$res['err']=1;
								$res['status']='Error! Can\'t upload the file!';
							}
							else{
								$res['file_name']=write_img_thumb($tmp_path, $file_name,$path,$max_width,$max_width);
								unlink($tmp_path.$file_name);
							}
						}
						else{
							if(!move_uploaded_file($_FILES[$name]['tmp_name'], $path.$file_name)){
								$res['err']=1;
								$res['status']='Error! Can\'t upload the file!';
							}
							else{
								$res['file_name']=$file_name;
							}
						}
					}
					else{
						$res['err']=1;
						$res['status']='Error! Uploaded file is very large!<br>Upload '.($size/1024).' Kbytes or less';
					}
				}
				else{
					$res['err']=1;
					$res['status']='Error! Mime-type <b>'.$img_size['mime'].'</b> is not supported.<br>You can upload only JPEG, GIF or PNG images.';
				}
			}
			else{
				$res['err']=1;
				$res['status']='Error! Uploaded file is not image';
			}
		}
		else{
			$res['err']=1;
		}

		return $res;
	}

	function write_img_thumb($path,$file_name,$dst,$width,$height){
		$res='';
		$new_file_name=$file_name;
		$img_size = getimagesize($path.$file_name);
		$width_orig=$img_size[0];
		$height_orig=$img_size[1];
		if($width_orig<$width && $height_orig<$height){
			while(file_exists($dst.$new_file_name)){
				$new_file_name=rand_string(5).'_'.$new_file_name;
			}
			$new_file_name=preg_replace('/[^a-zA-Z0-9\-_%\.]/si','_',$new_file_name);
			copy($path.$file_name,$dst.$new_file_name);
			return $new_file_name;
		}
		else{
			$ratio_orig = $width_orig/$height_orig;
			if ($width/$height > $ratio_orig) {
				$width = $height*$ratio_orig;
			} else {
			   $height = $width/$ratio_orig;
			}
			$image_p=imagecreatetruecolor($width, $height);

			while(file_exists($dst.$new_file_name)){
				$new_file_name=rand_string(5).'_'.$new_file_name;
			}
			$new_file_name=preg_replace('/[^a-zA-Z0-9\-_%\.]/si','_',$new_file_name);

			if($img_size['mime']=='image/gif'){
				$image = imagecreatefromgif($path.$file_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
				imagegif($image_p, $dst.$new_file_name);

			}
			elseif($img_size['mime']=='image/jpeg'){
				$image = imagecreatefromjpeg($path.$file_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
				imagejpeg($image_p, $dst.$new_file_name);
			}
			elseif($img_size['mime']=='image/png'){
				$image = imagecreatefrompng($path.$file_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
				imagepng($image_p, $dst.$new_file_name);
			}
			imagedestroy($image);
			imagedestroy($image_p);
			return $new_file_name;
		}
		return '';
	}

	function crop_img($path,$file_name,$dst,$width,$height,$pos='left_top',$resize=0){
		$info = GetImageSize($path.$file_name);
		$width_orig = $info[0];
		$height_orig = $info[1];
		$mime = $info['mime'];
		$type = substr(strrchr($mime, '/'), 1);

		$new_file_name=$file_name;
		while(file_exists($dst.$new_file_name)){
			$new_file_name=rand_string(5).'_'.$new_file_name;
		}
		$new_file_name=preg_replace('/[^a-zA-Z0-9\-_%\.]/si','_',$new_file_name);

		$new_height=$height_orig;
		$new_width=$width_orig;
		$w_h=$width/$height;
		if($w_h>$width_orig/$height_orig) {
			//$new_width=$width_orig
			$new_height=($width_orig*$height)/$width;
		}
		elseif($w_h<$width_orig/$height_orig){
			$new_width=($width*$height_orig)/$height;
		}

		switch($pos){
		case 'left_top':
			$x_pos = 0;
			$y_pos = 0;
			break;

		case 'center_top':
			$x_pos = ceil($width_orig/2)-$new_width/2;
			$y_pos = 0;
			break;

		case 'right_top':
			$x_pos = $width_orig-$new_width;
			$y_pos = 0;
			break;

		case 'left_center':
			$x_pos = 0;
			$y_pos = ceil($height_orig/2)-$new_height/2;
			break;

		case 'left_bottom':
			$x_pos = 0;
			$y_pos = $height_orig-$new_height;
			break;

		case 'center_center':
			$x_pos = ceil($width_orig/2)-$new_width/2;
			$y_pos = ceil($height_orig/2)-$new_height/2;
			break;

		default:
			$x_pos = ceil($width_orig/2)-$new_width/2;
			$y_pos = 0;
		}



		switch ($type)
		{
			case 'jpeg':
				$image_create_func = 'ImageCreateFromJPEG';
				$image_save_func = 'ImageJPEG';
				$new_image_ext = 'jpg';
				break;

			case 'png':
				$image_create_func = 'ImageCreateFromPNG';
				$image_save_func = 'ImagePNG';
				$new_image_ext = 'png';
				break;

			case 'bmp':
				$image_create_func = 'ImageCreateFromBMP';
				$image_save_func = 'ImageBMP';
				$new_image_ext = 'bmp';
				break;

			case 'gif':
				$image_create_func = 'ImageCreateFromGIF';
				$image_save_func = 'ImageGIF';
				$new_image_ext = 'gif';
				break;

			case 'vnd.wap.wbmp':
				$image_create_func = 'ImageCreateFromWBMP';
				$image_save_func = 'ImageWBMP';
				$new_image_ext = 'bmp';
				break;

			case 'xbm':
				$image_create_func = 'ImageCreateFromXBM';
				$image_save_func = 'ImageXBM';
				$new_image_ext = 'xbm';
				break;

			default:
				$image_create_func = 'ImageCreateFromJPEG';
				$image_save_func = 'ImageJPEG';
				$new_image_ext = 'jpg';
		}
		$image = $image_create_func($path.$file_name);

		$new_image = ImageCreateTrueColor($new_width, $new_height);
		$white = imagecolorallocate($new_image, 255, 255, 255);
		imagefilledrectangle($new_image, 0, 0, 150, 250, $white);


		ImageCopy($new_image, $image, 0, 0, $x_pos, $y_pos, $new_width, $new_height);
		if($resize==1){
			$resized_img=ImageCreateTrueColor($width, $height);
			imagecopyresampled($resized_img,$new_image,0,0,0,0,$width,$height,$new_width,$new_height);
			$image_save_func($resized_img, $dst.$new_file_name);
		}
		else{
			$image_save_func($new_image, $dst.$new_file_name);
		}

		return $new_file_name;

	}

	function wr_file($name, $path){
		global $user;
		if(isset($_FILES[$name]) && !empty($_FILES[$name]['tmp_name'])){
			$file_name=basename($_FILES[$name]['name']);
			preg_match("/\.[\w\d_]{1,3}$/",$file_name,$matches);
			$file_ext=$matches[0];
			if(!preg_match('/^[a-zA-Z0-9\-]+\.[a-zA-Z]{1,3}/', $file_name)){
				$file_name=random_string(5).$file_ext;
			}
			if(file_exists($path.$file_name)){
				$file_name=random_string(5).$file_name;
			}
			if(!move_uploaded_file($_FILES[$name]['tmp_name'], $path.$file_name)){
				$errors['file_upload']='Can\'t upload the file!';
				return 'error';
			}else{
				return $file_name;
			}
		}else{
				return 'error';
		}
	}

	function sql_insert($table,$data){
		$fields=$values='';
		foreach($data as $key=>$val)
		{
			$fields.="`$key`,";
			$values.=$val!='NOW()' ? "'$val'," : "NOW(),";
		}
		$fields=substr($fields,0,-1);
		$values=substr($values,0,-1);
		$query="INSERT INTO `$table` ($fields) VALUES ($values);";
		echo $query;
		sql_do($query);
	}

	function sql_update($table,$data,$where_data='',$fld='id'){
		$updates=$where='';
		foreach($data as $key=>$val)
		{		
			$updates.="`$key`=".($val!='NOW()' ? "'$val'" : 'NOW()').",";
		}
		$updates=substr($updates,0,-1);
		if(is_numeric($where_data)){
			$where="WHERE `$fld`='$where_data'";
		}
		elseif(is_array($where_data)){
			$values='';
			foreach($where_data as $val){
				$values.="'$val',";
			}
			$values=substr($values,0,-1);
			$where = "WHERE `$fld` IN ($values)";
		}
		elseif(is_string($where_data)){
			$where=$where_data;
		}
		$query="UPDATE `$table` SET $updates $where;";
		sql_do($query);
	}

	function sql_del($table,$data='',$fld=''){
		$where='';
		$fld=$fld!='' ? $fld : 'id';
		if(is_numeric($data)){
			$where = "WHERE `$fld`='$data'";
		}
		elseif(is_array($data)){
			$values='';
			foreach($data as $val){
				$values.="'$val',";
			}
			$values=substr($values,0,-1);
			$where = "WHERE `$fld` IN ($values)";
		}
		elseif(is_string($data)){
			$where=$data;
		}
		$query="DELETE FROM `$table` $where;";
		sql_do($query);
	}


	function sql_do($query){
		global $errors,$queries;
		$start=microtime_float();
		$res=mysql_query($query);
		$end=microtime_float();
		if(!$res){
			//$queries[round($end-$start,4).' sec.']=$query;
			$errors[$query]='<font color="blue" size="2"><b>'.mysql_error().'</b></font>';
		}
		else{
			$queries[round($end-$start,4).' sec.']=$query;
		}
		return $res;
	}

	function rand_string($num_chars) {
		$chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');

		list($usec, $sec) = explode(' ', microtime());
		mt_srand($sec * $usec);

		$max_chars = sizeof($chars) - 1;
		$rand_str = '';
		for ($i = 0; $i < $num_chars; $i++)	{
			$rand_str .= $chars[mt_rand(0, $max_chars)];
		}

		return $rand_str;
	}

	function microtime_float() {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	function p_r($val) {
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}

	function send_mail($from,$to,$subject,$body,$from_title=''){
		$from1=$from;
		if($from_title!=''){
			$from1=$from_title.' <'.$from.'>';
		}
		mail($to, $subject, $body, "From: $from1\r\nReply-To: $from\r\nX-Mailer: PHP\r\n"."Content-type: text/html; charset=windows-1251; format=flowed\r\n");
	}

///////////////////
//caching functions
///////////////////

	function checkCache($name,$time=3600,$mode='file'){
		if ((time()-@filemtime ("cache/$name"))<$time){ 
			return file_get_contents("cache/$name");        
		}else{
			return false;
		}
	}

	function writeCache($name, $cache,$mode='file'){
		$fp = @fopen ("cache/$name", "w");
		@fwrite ($fp, $cache);
		@fclose ($fp);
	}
?>
