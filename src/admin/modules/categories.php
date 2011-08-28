<?
	$db_table='categories';
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
    					'fld'=>'id'
    				)
    			),
    			'name'=>array(
                	'header'=>array(
    					'title'=>'Назва',
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
	    		'name'=>array(
	    			'title'=>'Назва','langs'=>1, 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'50')
	    		 ),
	    		'title'=>array(
	    			'title'=>'Заголовок','langs'=>1, 'required'=>0, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box','size_x'=>'60')
	    		),
                'break'=>array(
					'title'=>'Meta data, keywords and SEO', 'save'=>'no_save', 'type'=>'break'
				),
                'meta_desc'=>array(
                    'title'=>'Мета-опис', 'langs'=>1, 'required'=>0, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box', 'size_x'=>'60')
                ),
                'keywords'=>array(
                    'title'=>'Ключові слова', 'langs'=>1, 'required'=>0, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box', 'size_x'=>'60')
                ),
                'seotext'=>array(
                    'title'=>'SEO текст', 'langs'=>1, 'required'=>0, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box', 'size_x'=>'60')
                ),
                'alias'=>array(
                    'title'=>'Alias', 'langs'=>0, 'required'=>0, 'save'=>'mysql', 'form_fld'=>array('function'=>'text_box', 'size_x'=>'60')
                )
	    	),
    	)
 	);
?>
