<?
	$query_conf='';
	$admin_data['add_title']='Додати нову групу користувачів';
	$admin_data['edit_title']='Редагування групи користувачів';
	$admin_data['add_button']='Додату нову групу';
	$admin_data['submit_button']='Ok';
	$admin_data['edit_caption']='Edit';
	$admin_data['del_caption']='Del';
	$form_titles['name']='Назва групи';
	$form_titles['code']='Код групи';
	$form_titles['order_id']='Рівень доступу';
	$form_titles['is_admin']='Адміністратор';
	$form_titles['admin_rights']='Дозволи';

	$table_titles=array($form_titles['name'],'Дії');

	$q_table='user_groups';

	$new=p('new',1);
	$edit=g('edit',1);
    $act=p('act');
    $id=p('id',1);
    $del=(!empty($_POST['delete'])) ? $_POST['delete'] : 0;

    $q_data=array();
	foreach($_POST as $key=>$val){
		if(preg_match('/^__/i',$key)){
			$tmp=preg_replace('/^__/i','',$key);
			$q_data[$tmp]=p($key);
		}
	}
    $q_data['admin_rights']='';
	$q_data['site_rights']='';

    $q_data['admin_rights']=(!empty($_POST['admin_rights'])) ? serialize($_POST['admin_rights']) : '';

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
        if($q_data['name']!=''){
           	sql_insert($q_table,$q_data);
        }
	}

	if($act=='edit' && $id!=0){
        if($q_data['name']!=''){
           	sql_update($q_table,$q_data,$id);
        }
	}

	if($new!=0){
  		show_form(array(), $admin_data['add_title'], 'add');
	}

	if($edit!=0){
		$res=sql_do("SELECT * FROM $q_table WHERE id='$edit'");
		while($q=mysql_fetch_array($res)){
			show_form($q, $admin_data['edit_title'], 'edit');
		}
	}

	if(($new==0)&&($edit==0)){

		$res=sql_do("SELECT * FROM $q_table WHERE order_id>=".$user['order_id']." ORDER BY order_id");
		if(mysql_num_rows($res)>0){
        	$frm = new InputForm (array('action'=>$data['action'],'mode'=>$data['mod_mode']));
        	$frm->addrow(array(
            	array('data'=>$table_titles[0],'align'=>'center','class'=>'head'),
        		array('data'=>$table_titles[1],'align'=>'center','class'=>'head')
        	));
        	while($q=mysql_fetch_array($res)){
            	$frm->simple_data_row($q['name'],$frm->del_edit($q['id'],$admin_data['del_caption'],$admin_data['edit_caption']));
        	}
        	$frm->show();
		}

		$frm = new InputForm (array('action'=>$data['action'],'submit'=>$admin_data['add_button'],'mode'=>$data['mod_mode']));
	    $frm->hidden('new', 1);
		$frm->show();
	}

	function show_form($data, $title, $act){
		$user=$GLOBALS['user'];
    	$frm = new InputForm (array('action'=>$GLOBALS['data']['action'],'mode'=>$GLOBALS['data']['mod_mode']));

    	$frm->addbreak($title);
	   	if(!empty($data['id'])){
	    	$frm->hidden('id', $data['id']);
	   	}
	   	$rights=array();
	   	if(!empty($data['admin_rights'])){
			$rights=unserialize($data['admin_rights']);
	   	}
	   	$order_arr=array();
	   	for($i=1;$i<=5;$i++){
	   		if($user['order_id']<$i){
	   			$order_arr[$i]=$i;
	   		}
	   	}
	   	$frm->hidden('act', $act);
	   	$frm->simple_form_row($GLOBALS['form_titles']['name'],$frm->text_box('__name', !empty($data['name']) ? $data['name'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['code'],$frm->text_box('__code', !empty($data['code']) ? $data['code'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['is_admin'],$frm->checkbox('__is_admin', '1', '', !empty($data['is_admin']) ? $data['is_admin'] : 0));
	   	$frm->simple_form_row($GLOBALS['form_titles']['order_id'],$frm->select_tag('__order_id',$order_arr, !empty($data['order_id']) ? $data['order_id'] : ''));
	   	$res=sql_do("SELECT admin_modules.*, admin_mod_groups.name AS group_name
		 			FROM admin_modules
		 			LEFT JOIN admin_mod_groups ON admin_mod_groups.id=admin_modules.group
		 			ORDER BY admin_mod_groups.order_id,admin_mod_groups.name,admin_modules.order_id");

		$frm->addbreak('&nbsp;');
		$frm->addrow(array(
        	array('data'=>'<b>Дозволи</b>','align'=>'center','colspan'=>2,'class'=>'head')
		));
		$tmp='';$title=' ';

		while($q=mysql_fetch_array($res)){
        	if($user['group_code']=='root' || !empty($user['admin_rights'][$q['id']])){
				if($tmp!=$q['group_name']){
					$tmp=$q['group_name'];
					$frm->addbreak($tmp);
				}
				$frm->simple_form_row($q['name'],$frm->checkbox('admin_rights[edit]['.$q['id'].']', '1', 'Редагування', !empty($rights['edit'][$q['id']]) ? 1 : 0).' &nbsp; '.$frm->checkbox('admin_rights[view]['.$q['id'].']', '1', 'Перегляд', !empty($rights['view'][$q['id']]) ? 1 : 0));
				$title=' ';
        	}
		}
	   	$frm->show();
	}
?>