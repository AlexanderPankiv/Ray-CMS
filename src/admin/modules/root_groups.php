<?
	$admin_data['add_title']='Додати нову групу модулів';
	$admin_data['edit_title']='Редагування групи модулів';
	$admin_data['add_button']='Додати нову групу';
	$admin_data['submit_button']='Ok';
	$admin_data['edit_caption']='Edit';
	$admin_data['del_caption']='Del';
	$admin_data['view_caption']='Переглянути';
	$form_titles['name']='Назва групи';
	$form_titles['order_id']='Індекс сортування';

	$q_table='admin_mod_groups';
	$table_titles=array($form_titles['name'],'Дії');

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
		$res=sql_do("SELECT * FROM $q_table ORDER BY order_id,name");
		if(mysql_num_rows($res)>0){
        	$frm = new InputForm (array('action'=>$data['action'],'mode'=>$data['mod_mode']));
        	$frm->addrow(array(
            	array('data'=>$table_titles[0],'align'=>'center','class'=>'head'),
        		array('data'=>$table_titles[1],'align'=>'center','class'=>'head')
        	));
        	while($q=mysql_fetch_array($res)){
            	$frm->simple_data_row($q['name'],$frm->del_edit($q['id'],$admin_data['del_caption'],$admin_data['edit_caption'],$admin_data['view_caption']));
            }
        	$frm->show();
		}

		//if($id==0){
	    	$frm = new InputForm (array('action'=>$data['action'],'submit'=>$admin_data['add_button'],'mode'=>$data['mod_mode']));
	    	$frm->hidden('new', 1);
			$frm->show();
		//}
	}

	function show_form($data, $title, $act){
    	$frm = new InputForm (array('action'=>$GLOBALS['data']['action'],'mode'=>$GLOBALS['data']['mod_mode']));

    	$frm->addbreak($title);
	   	if(!empty($data['id'])){
	    	$frm->hidden('id', $data['id']);
	   	}
	   	$frm->hidden('act', $act);

     	$frm->simple_form_row($GLOBALS['form_titles']['name'],$frm->text_box('__name', !empty($data['name']) ? $data['name'] : '','50'));
	   	$frm->simple_form_row($GLOBALS['form_titles']['order_id'],$frm->text_box('__order_id', !empty($data['order_id']) ? $data['order_id'] : '','50'));

	   	$frm->show();
	}
?>