<?
	$db_table='content_pages';
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
    		'order_by'=>'id',
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
    			'p_id'=>array(
    				'header'=>array(
    					'title'=>'Ідентифікатор сторінки',
    					'order_by'=>'p_id',
    					'params'=>array(
    						'width'=>'20'
    					)
    				),
    				'data'=>array(
    					'fld'=>'p_id',
    				)
    			),
    			'name'=>array(
                	'header'=>array(
    					'title'=>'Назва сторінки',
    					'order_by'=>'name_ukr'
    				),
    				'data'=>array(
    					'fld'=>'name_ukr'
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
        		'p_id'=>array(
	    			'title'=>'Ідентифікатор сторінки','langs'=>0, 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'50')
	    		),
	    		'name'=>array(
	    			'title'=>'Назва сторінки','langs'=>1, 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'50')
	    		),
	    		'text'=>array(
	    			'title'=>'Текст сторінки','langs'=>1, 'rich_editor'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'textarea','size_x'=>'60','size_y'=>'20')
	    		),
				'image'=>array(
	    			'title'=>'Картинка', 'add_title'=>'Додати картинку', 'edit_title'=>'Замінити картинку', 'del_title'=>'Видалити картинку', 'save'=>'image', 'form_fld'=>array(
	    				'function'=>'file','path'=>'img/static/','thumbnails'=>array(
	    					array('path'=>'img/static/thumb/', 'width'=>'165', 'height'=>'205')
	    				)
	    			)
	    		),
	    		'break'=>array(
					'title'=>'Meta data', 'save'=>'no_save', 'type'=>'break'
				),
				'title'=>array(
					'title'=>'Meta Title', 'save'=>'mysql', 'langs'=>1, 'form_fld'=>array('function'=>'text_box','size_x'=>'50')
				),
				'descr'=>array(
					'title'=>'Meta Description', 'save'=>'mysql', 'langs'=>1, 'form_fld'=>array('function'=>'textarea','size_x'=>'35')
				),
				'keywords'=>array(
					'title'=>'Meta Keywords', 'save'=>'mysql', 'langs'=>1, 'form_fld'=>array('function'=>'textarea','size_x'=>'35')
				),
			),
    	)
 	);
?>