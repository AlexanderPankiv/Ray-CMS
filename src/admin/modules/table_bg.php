<?
	$db_table='table_bg';
 	$mod_data=array(
 		'captions'=>array(
        	'add_title'=>'Додавання',
        	'edit_title'=>'Редагування',
        	'add_button'=>'Додати',
        	'submit_button'=>'OK',
        	'edit_caption'=>'Edit',
        	'del_caption'=>'Del'
 		),

    	'view'=>array(
    		'query'=>"SELECT * FROM `$db_table`",
    		'order_by'=>'name_ukr',
    		'order_desc'=>false,
    		'per_page'=>20,
    		'group_by'=>'',
    		'fields'=>array(
    			'id'=>array(
    				'header'=>array(
    					'title'=>'ID',
    					'order_by'=>'id',
    					'params'=>array(
    						'width'=>'20'
    					)
    				),
    				'data'=>array(
    					'fld'=>'id'
    				)
    			),
    			'name'=>array(
                	'header'=>array(
    					'title'=>'Назва фонового зображення',
    					'order_by'=>'name_ukr'
    				),
    				'data'=>array(
    					'fld'=>'name_ukr'
    				)
    			),
    			'image'=>array(
                	'header'=>array(
    					'title'=>'Зображення'
    				),
    				'data'=>array(
    					'fld_compil'=>"'<img src=\"img/products/thumb/'.{image}.'\" />';"
    				)
    			),
    			'actions'=>array(
    				'header'=>array(
    					'title'=>'Дії',
    					'params'=>array(
    						'width'=>'125'
    					)
    				)
    			),
    		)
    	),

    	'add_new'=>true,

    	'form'=>array(
    		'edit_query'=>"SELECT * FROM `$db_table` WHERE `id`='{edit}'",
        	'fields'=>array(
	    		'name'=>array(
	    			'title'=>'Назва таблички','langs'=>1, 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'50')
	    		),
	    		'image'=>array(
	    			'title'=>'Зображення', 'add_title'=>'Додати зображення', 'edit_title'=>'Замінити зображення', 'del_title'=>'Видалити зображення', 'save'=>'image', 'form_fld'=>array(
	    				'function'=>'file','path'=>'img/products/','thumbnails'=>array(
	    					array('path'=>'img/products/thumb/','width'=>'232','height'=>'145','crop'=>'center_center')
	    				)
	    			)
	    		)
	    	),
    	)
 	);
?>