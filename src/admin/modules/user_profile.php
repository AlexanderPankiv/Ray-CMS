<?
	$admin_data['submit_button']='Ok';
	$user_id=$user['id'];

	$q_table='users';

	$new=p('new',1);
    $act=p('act');


	$q_data=array();
	foreach($_POST as $key=>$val){
		if(preg_match('/^__/i',$key)){
			$tmp=preg_replace('/^__/i','',$key);
			$q_data[$tmp]=p($key);
		}
	}

	if($act=='edit'){
    	if($q_data['login']!=''){
    		if((p('new_pass')!='' && p('new_pass')==p('copy_pass')) || p('new_pass')=='')	{
    			$del_photo=p('del_photo',1);
    			if($del_photo!=0){
					if(file_exists('img/user_pics/'.$user['photo'])){
						unlink('img/user_pics/'.$user['photo']);
					}
					$q_data['photo']='';
	           	}

    			if(p('new_pass')!=''){
					$q_data['pass']=md5(p('new_pass').$user['register_date']);
				}
				if(!empty($_FILES['photo'])){
		  			$res = write_image('photo','img/temp/');
		  			if(!$res['err']){
		               	$image = $res['file_name'];
		               	$q_data['photo']=write_img_thumb('img/temp/', $image,'img/user_pics/',250,250);
		               	unlink('img/temp/'.$image);
		  			}
		        }
	           	sql_update($q_table,$q_data,$user_id);
	    	}
    		else{
    			echo '<font color="red"><b>Введені паролі не співпадають</b></font>';
    		}
    	}
    	else{
    		echo '<font color="red"><b>Ви не ввели Логін</b></font>';
    	}
	}

	$res=sql_do("SELECT * FROM users WHERE id=$user_id");
	$frm = new InputForm (array('action'=>$GLOBALS['data']['action'],'mode'=>$GLOBALS['data']['mod_mode'],'enctype'=>'multipart/form-data'));
	$frm->hidden('act', 'edit');
	while($q=mysql_fetch_array($res)){
		$frm->simple_form_row('Логін',$frm->text_box('__login', !empty($q['login']) ? $q['login'] : '','50'));
		$frm->simple_form_row('Новий пароль',$frm->text_box('new_pass','','50',0,true));
		$frm->simple_form_row('Підтвердити парль',$frm->text_box('copy_pass','','50',0,true));
		$frm->simple_form_row('Прізвище',$frm->text_box('__last_name', !empty($q['last_name']) ? $q['last_name'] : '','50'));
		$frm->simple_form_row('Ім\'я, по батькові',$frm->text_box('__first_name', !empty($q['first_name']) ? $q['first_name'] : '','50'));
		$frm->simple_form_row('Телефони	',$frm->text_box('__phone', !empty($q['phone']) ? $q['phone'] : '','50'));
		$frm->simple_form_row('E-mail',$frm->text_box('__email', !empty($q['email']) ? $q['email'] : '','50'));
		$frm->simple_form_row('ICQ',$frm->text_box('__icq', !empty($q['icq']) ? $q['icq'] : '','50'));
		$frm->simple_form_row('Skype',$frm->text_box('__skype', !empty($q['skype']) ? $q['skype'] : '','50'));

		$frm->addbreak();
        if(!empty($q['photo'])){
        	$frm->simple_form_row('Фото','<img src="/img/user_pics/'.$q['photo'].'" /> &nbsp; '.$frm->checkbox('del_photo', '1', 'Видалити'));
			$frm->simple_form_row('Замінити фото',$frm->file('photo'));
		}
		else{
			$frm->simple_form_row('Додати фото',$frm->file('photo'));
		}
	}
    $frm->show();

?>