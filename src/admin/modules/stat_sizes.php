<?
	$db_table='bl_stat_sizes';
	$db_rel_table='bl_statues';
 	$mod_data=array(
 		'captions'=>array(
        	'add_title'=>'Додавання',
        	'edit_title'=>'Редагування',
        	'del_title'=>'Видалити',
        	'add_button'=>'Додати',
        	'submit_button'=>'OK',
        	'edit_caption'=>'Edit',
        	'del_caption'=>'Del'
 		),

    	'view'=>array(
    		'query'=>"SELECT $db_table.*,$db_rel_table.code AS prod_code FROM $db_table lEFT JOIN $db_rel_table ON $db_rel_table.id=$db_table.prod_id",
    		'order_by'=>'prod_code,'.$db_table.'.id',
    		'order_desc'=>false,
    		'per_page'=>20,
    		'fields'=>array(
    			'width1'=>array(
    				'header'=>array(
    					'title'=>'Ширина 1',
    					'order_by'=>'width1'
    				),
    				'data'=>array(
    					'fld'=>'width1'
    				)
    			),
    			'width2'=>array(
    				'header'=>array(
    					'title'=>'Ширина 2',
    					'order_by'=>'width2'
    				),
    				'data'=>array(
    					'fld'=>'width2'
    				)
    			),
    			'height'=>array(
    				'header'=>array(
    					'title'=>'Висота',
    					'order_by'=>'height'
    				),
    				'data'=>array(
    					'fld'=>'height'
    				)
    			),
    			'weight'=>array(
    				'header'=>array(
    					'title'=>'Маса',
    					'order_by'=>'weight'
    				),
    				'data'=>array(
    					'fld'=>'weight'
    				)
    			),
    			'price'=>array(
                	'header'=>array(
    					'title'=>'Ціна',
    					'order_by'=>'price'
    				),
    				'data'=>array(
    					'fld_compil'=>'\'&euro;\'.{price};'
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
	    		'prod_id'=>array(
		        	'title'=>'Артикул продукції', 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'select_tag', 'sel_query'=>"SElECT * FROM $db_rel_table ORDER BY code",'sel_key'=>'id','sel_val'=>'code')
				),
				'width1'=>array(
	    			'title'=>'Ширина 1, см','save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'20')
	    		),
	    		'width2'=>array(
	    			'title'=>'Ширина 2, см','save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'20')
	    		),
	    		'height'=>array(
	    			'title'=>'Висота, см','save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'20')
	    		),
	    		'weight'=>array(
	    			'title'=>'Маса, кг','save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'20')
	    		),
	    		'price'=>array(
	    			'title'=>'Ціна, &euro;','save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'20')
	    		),
	    	),
    	)
 	);
?>