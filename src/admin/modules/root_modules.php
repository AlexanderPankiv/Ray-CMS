<?
	$admin_data['add_title']='Додати новий модуль';
	$admin_data['edit_title']='Редагування модуля';
	$admin_data['add_button']='Додати новий модуль';
	$admin_data['submit_button']='Добре';
	$admin_data['edit_caption']='Ред.';
	$admin_data['del_caption']='Видалити';
	$form_titles['group']='Група';
	$form_titles['module_id']='Ідентифікатор модуля';
	$form_titles['name']='Назва модуля';
	$form_titles['order_id']='Індекс сортування';
	$form_titles['extra']='Універсальний';

	$table_titles=array($form_titles['name'],'Дії');

	$q_table='admin_modules';

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

	$q_data['extra']=p('extra',1);

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

		$res=sql_do("SELECT admin_modules.*, admin_mod_groups.name AS group_name
		 			FROM admin_modules
		 			LEFT JOIN admin_mod_groups ON admin_mod_groups.id=admin_modules.group
		 			ORDER BY admin_mod_groups.order_id,admin_mod_groups.name,admin_modules.order_id");
		if(mysql_num_rows($res)>0){
        	$frm = new InputForm (array('action'=>$data['action'],'mode'=>$data['mod_mode']));
        	$frm->addrow(array(
            	array('data'=>$table_titles[0],'align'=>'center','class'=>'head'),
        		array('data'=>$table_titles[1],'align'=>'center','class'=>'head')
        	));
        	$tmp='';
        	while($q=mysql_fetch_array($res)){
        		if($tmp!=$q['group_name']){
        			$tmp=$q['group_name'];
        			$frm->addbreak($tmp);
        		}
        		$frm->simple_data_row($q['name'],$frm->del_edit($q['id'],$admin_data['del_caption'],$admin_data['edit_caption']));
        	}
        	$frm->show();
		}

	   	$frm = new InputForm (array('action'=>$data['action'],'submit'=>$admin_data['add_button'],'mode'=>$data['mod_mode']));
	    $frm->hidden('new', 1);
		$frm->show();
	}

	function show_form($data, $title, $act){
    	$frm = new InputForm (array('action'=>$GLOBALS['data']['action'],'mode'=>$GLOBALS['data']['mod_mode']));

    	$frm->addbreak($title);
	   	if(!empty($data['id'])){
	    	$frm->hidden('id', $data['id']);
	   	}
	   	$frm->hidden('act', $act);

	   	$frm->simple_form_row($GLOBALS['form_titles']['group'],$frm->select_tag('__group',simple_select_arr('admin_mod_groups','Не вибрано'), !empty($data['group']) ? $data['group'] : ''));
	   	$frm->simple_form_row($GLOBALS['form_titles']['module_id'],$frm->text_box('__module_id', !empty($data['module_id']) ? $data['module_id'] : '','50'));
     	$frm->simple_form_row($GLOBALS['form_titles']['name'],$frm->text_box('__name', !empty($data['name']) ? $data['name'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['order_id'],$frm->text_box('__order_id', !empty($data['order_id']) ? $data['order_id'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['extra'],$frm->checkbox('extra', '1', '', !empty($data['extra']) ? $data['extra'] : 0));

	   	$frm->show();
	}
?>
