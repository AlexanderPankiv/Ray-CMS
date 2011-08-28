<?
	//p_r($user);
	$admin_data=array(
		'add_title'=>'Додати нового користувача',
		'edit_title'=>'Редагування користувача',
		'add_button'=>'Додати нового користувача',
		'submit_button'=>'Ok',
		'edit_caption'=>'Edit',
		'del_caption'=>'Del'
	);
	$form_titles=array(
    	'group'=>'Група користувачів',
    	'login'=>'Логін',
    	'pass'=>'Пароль',
    	're_pass'=>'Повторіть пароль',
    	'first_name'=>'Ім\'я, По батькові',
    	'last_name'=>'Прізвище',
    	'email'=>'E-mail',
    	'icq'=>'ICQ',
    	'skype'=>'Skype',
    	'country'=>'Країна',
    	'region'=>'Регіон',
    	'city'=>'Місто',
    	'address'=>'Адреса',
    	'phone'=>'Телефон',
    	'active'=>'Активний',
    	'photo'=>'Фото',
    	'add_photo'=>'Додати фото',
    	'replace_photo'=>'Завантажити інше фото',
    	'del_photo'=>'Видалити фото',
    	'affiliate'=>'Філія'
	);

	$q_table='users';

	$new=p('new',1);
	$edit=g('edit',1);
    $act=p('act');
    $id=p('id',1);
    $del=(!empty($_POST['delete'])) ? $_POST['delete'] : 0;
    $show_users=p('show_users')!='' ? p('show_users') : 'all';

    $q_data=array();
	foreach($_POST as $key=>$val){
		if(preg_match('/^__/i',$key)){
			$tmp=preg_replace('/^__/i','',$key);
			$q_data[$tmp]=p($key);
		}
	}
    $q_data['register_date']=p('register_date')!='' ? p('register_date') : time();
    if(p('pass')!=''){
    	$q_data['pass']=md5(p('pass').$q_data['register_date']);
    }
    $q_data['active']=p('active',1);

    $order_by=g('order_by');
    $order=g('order');
    $page=g('page',1)!=0 ? g('page',1) : 1;
    $asc='style="padding-left: 10px; background: url(\'/img/icons/up.png\') left 50% no-repeat;"';
    $desc='style="padding-left: 10px; background: url(\'/img/icons/down.png\') left 50% no-repeat;"';
    $head_id = $order_by=='id' ? ($order=='DESC' ? '<b><a '.$desc.' href="'.$data['action'].'&order_by=id&page='.$page.'">ID</a></b>' : '<b><a '.$asc.' href="'.$data['action'].'&order_by=id&order=DESC&page='.$page.'">ID</a></b>') : '<a href="'.$data['action'].'&order_by=id&page='.$page.'">ID</a>';
    $head_login = $order_by=='login' ? ($order=='DESC' ? '<b><a '.$desc.' href="'.$data['action'].'&order_by=login&page='.$page.'">Логін</a></b>' : '<b><a '.$asc.' href="'.$data['action'].'&order_by=login&order=DESC&page='.$page.'">Логін</a></b>') : '<a href="'.$data['action'].'&order_by=login&page='.$page.'">Логін</a>';
    $head_group = $order_by=='group' ? ($order=='DESC' ? '<b><a '.$desc.' href="'.$data['action'].'&order_by=group&page='.$page.'">Група</a></b>' : '<b><a '.$asc.' href="'.$data['action'].'&order_by=group&order=DESC&page='.$page.'">Група</a></b>') : '<a href="'.$data['action'].'&order_by=group&page='.$page.'">Група</a>';
    $head_name = $order_by=='name' ? ($order=='DESC' ? '<b><a '.$desc.' href="'.$data['action'].'&order_by=name&page='.$page.'">Ім\'я</a></b>' : '<b><a '.$asc.' href="'.$data['action'].'&order_by=name&order=DESC&page='.$page.'">Ім\'я</a></b>') : '<a href="'.$data['action'].'&order_by=name&page='.$page.'">Ім\'я</a>';
    $head_email = $order_by=='email' ? ($order=='DESC' ? '<b><a '.$desc.' href="'.$data['action'].'&order_by=email&page='.$page.'">E-mail</a></b>' : '<b><a '.$asc.' href="'.$data['action'].'&order_by=email&order=DESC&page='.$page.'">E-mail</a></b>') : '<a href="'.$data['action'].'&order_by=email&page='.$page.'">E-mail</a>';
    $head_last_activity = $order_by=='l_act' ? ($order=='DESC' ? '<b><a '.$desc.' href="'.$data['action'].'&order_by=l_act&page='.$page.'">Остання активність</a></b>' : '<b><a '.$asc.' href="'.$data['action'].'&order_by=l_act&order=DESC&page='.$page.'">Остання активність</a></b>') : '<a href="'.$data['action'].'&order_by=l_act&page='.$page.'">Остання активність</a>';

    $q_sort='ORDER BY ';
    switch($order_by){
    	case 'id': $q_sort.='users.id'; break;
    	case 'login': $q_sort.='users.login'; break;
    	case 'group': $q_sort.='user_groups.name'; break;
    	case 'name': $q_sort.='users.last_name,users.first_name'; break;
    	case 'email': $q_sort.='users.email'; break;
    	case 'l_act': $q_sort.='users.last_activity'; break;
    	default: $q_sort.='users.id';
    }
   	if($order=='DESC'){
    	$q_sort=preg_replace('/,/si',' DESC,',$q_sort);
    	$q_sort.=' DESC';
    }

    if($del!=0){
		$arr=array();
		foreach($del as $id=>$chk){
			if(($chk)&&(is_numeric($id))){
				array_push($arr,$id);
			}
		}
		if(count($arr)>0){
			sql_del($q_table,$arr);
		}
	}

	if($act=='add'){
        if($q_data['login']!=''){
        	if(!empty($_FILES['photo'])){
	  			$res = write_image('photo','img/temp/');
	  			if(!$res['err']){
	               	$image = $res['file_name'];
	               	$q_data['photo']=write_img_thumb('img/temp/', $image,'img/user_pics/',250,250);
	               	unlink('img/temp/'.$image);
	  			}
	        }
           	sql_insert($q_table,$q_data);
        }
	}

	if($act=='edit' && $id!=0){
        if($q_data['login']!=''){
        	if(!empty($_FILES['photo'])){
	  			$res = write_image('photo','img/temp/');
	  			if(!$res['err']){
	               	$image = $res['file_name'];
	               	$q_data['photo']=write_img_thumb('img/temp/', $image,'img/user_pics/',250,250);
	               	unlink('img/temp/'.$image);
	  			}
	        }
           	sql_update($q_table,$q_data,$id);
        }
	}

	if($new!=0){
  		show_form(array(), $admin_data['add_title'], 'add');
	}

	if($edit!=0){
		$res=sql_do("SELECT users.*, user_groups.name AS group_name
		 			FROM users
		 			LEFT JOIN user_groups ON user_groups.id=users.group
		 			WHERE users.id='$edit' AND user_groups.order_id>".$user['order_id']."   $query_conf
		 			$q_sort");
		while($q=mysql_fetch_array($res)){
			show_form($q, $admin_data['edit_title'], 'edit');
		}
	}

	if(($new==0)&&($edit==0)){
		if($show_users=='admin'){
			$query_conf='AND user_groups.is_admin=1';
		}
		elseif($show_users=='def_users'){
			$query_conf='AND user_groups.is_admin=0';
		}
		$res=sql_do("SELECT users.*, user_groups.name AS group_name
		 			FROM users
		 			LEFT JOIN user_groups ON user_groups.id=users.group
		 			WHERE user_groups.order_id>".$user['order_id']."   $query_conf
		 			$q_sort
		 			");
		$frm = new InputForm (array('mode'=>$GLOBALS['data']['mod_mode'],'cols'=>1,'disable_submit_button'=>true,'id'=>'show_users_form'));
	    $frm->addrow(array(
	      	array('data'=>'Показати:&nbsp;'.$frm->select_tag('show_users',array('all'=>'Всіх','admin'=>'Лише адмінів','def_users'=>'Лише користувачів сайту'),$show_users,'onchange="document.getElementById(\'show_users_form\').submit();"'),'align'=>'center','class'=>'head')
	    ));
		$frm->show();
		if(mysql_num_rows($res)>0){
        	$frm = new InputForm (array('action'=>$data['action'],'mode'=>$data['mod_mode'],'cols'=>7));
        	$frm->addrow(array(
        		array('data'=>$head_id,'align'=>'center','class'=>'head','width'=>'20'),
        		array('data'=>$head_login,'align'=>'center','class'=>'head'),
        		array('data'=>$head_group,'align'=>'center','class'=>'head'),
        		array('data'=>$head_name,'align'=>'center','class'=>'head'),
        		array('data'=>$head_email,'align'=>'center','class'=>'head'),
        		array('data'=>$head_last_activity,'align'=>'center','class'=>'head'),
        		array('data'=>'Дії','align'=>'center','class'=>'head'),
        	));
        	while($q=mysql_fetch_array($res)){
        		$frm->addrow(array(
	        		array('data'=>$q['id'],'align'=>'center'),
	        		array('data'=>$q['login'].($q['active']==0 ? ' <small style="color:red">Заблокований</small>' : '')),
	        		array('data'=>$q['group_name']),
	        		array('data'=>$q['first_name'].' '.$q['last_name']),
	        		array('data'=>$q['email']),
	        		array('data'=>date('d-m-Y H:i:s',$q['last_activity']),'width'=>'120'),
	        		array('data'=>$frm->del_edit($q['id'],$admin_data['del_caption'],$admin_data['edit_caption']),'width'=>'125','class'=>'col_right')
	        	));
        	}
        	$frm->show();
		}

	    $frm = new InputForm (array('action'=>$data['action'],'submit'=>$admin_data['add_button'],'mode'=>$data['mod_mode']));
	    $frm->hidden('new', 1);
		$frm->show();
	}

	function show_form($data, $title, $act){
    	$frm = new InputForm (array('action'=>$GLOBALS['data']['action'],'mode'=>$GLOBALS['data']['mod_mode'],'enctype'=>'multipart/form-data'));

    	$frm->addbreak($title);
	   	if(!empty($data['id'])){
	    	$frm->hidden('id', $data['id']);
	   	}
	   	if(!empty($data['register_date'])){
	    	$frm->hidden('register_date', $data['register_date']);
	   	}
	   	$frm->hidden('act', $act);

	   	$frm->simple_form_row($GLOBALS['form_titles']['group'],$frm->select_tag('__group',simple_select_arr('user_groups','Не вибрано','','','WHERE order_id>'.$GLOBALS['user']['order_id']), !empty($data['group']) ? $data['group'] : ''));

        $frm->addbreak();
	   	$frm->simple_form_row($GLOBALS['form_titles']['login'],$frm->text_box('__login', !empty($data['login']) ? $data['login'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['pass'],$frm->text_box('pass','','50',0,true));
	   	$frm->simple_form_row($GLOBALS['form_titles']['re_pass'],$frm->text_box('re_pass','','50',0,true));
        $frm->addbreak();
	   	$frm->simple_form_row($GLOBALS['form_titles']['first_name'],$frm->text_box('__first_name', !empty($data['first_name']) ? $data['first_name'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['last_name'],$frm->text_box('__last_name', !empty($data['last_name']) ? $data['last_name'] : '','50'));
		$frm->addbreak();
	   	$frm->simple_form_row($GLOBALS['form_titles']['phone'],$frm->text_box('__phone', !empty($data['phone']) ? $data['phone'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['email'],$frm->text_box('__email', !empty($data['email']) ? $data['email'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['icq'],$frm->text_box('__icq', !empty($data['icq']) ? $data['icq'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['skype'],$frm->text_box('__skype', !empty($data['skype']) ? $data['skype'] : '','50'));
        $frm->addbreak();
        if(!empty($data['photo'])){
        	$frm->simple_form_row($GLOBALS['form_titles']['photo'],'<img src="/img/user_pics/'.$data['photo'].'" /> &nbsp; '.$frm->checkbox('del_photo', '1', $GLOBALS['form_titles']['del_photo']));
			$frm->simple_form_row($GLOBALS['form_titles']['replace_photo'],$frm->file('photo'));
		}
		else{
			$frm->simple_form_row($GLOBALS['form_titles']['add_photo'],$frm->file('photo'));
		}
		$frm->simple_form_row($GLOBALS['form_titles']['active'], $frm->checkbox('active', '1', '', ((!empty($data['active']) && $data['active']!=0) ? $data['active'] : 0)));
	   	$frm->show();
	}
?>