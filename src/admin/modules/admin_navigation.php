<?
	$db_table='navigation';
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
    		'order_by'=>'order_id',
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
    					'fld'=>'id',
    					'fld_compil'=>''//format {fld1_key}<separator>{fld2_key} , e.g. '{id}+{name}=xz :)'
    				)
    			),
    			'name_ukr'=>array(
                	'header'=>array(
    					'title'=>'Назва пункта меню',
    					'order_by'=>'name_ukr'
    				),
    				'data'=>array(
    					'fld'=>'name_ukr'
    				)
    			),
    			'url'=>array(
                	'header'=>array(
    					'title'=>'URL',
    					'order_by'=>'url'
    				),
    				'data'=>array(
    					'fld'=>'url'
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
	    			'title'=>'Назва пункта меню','langs'=>1, 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'50')
	    		),
	    		'url'=>array(
	    			'title'=>'URL','langs'=>0, 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'50')
	    		),
	    		'order_id'=>array(
	    			'title'=>'Індекс сортування','langs'=>0, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'10')
	    		)
	    	),
    	)
 	);
?>