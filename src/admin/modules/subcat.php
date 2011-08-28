<?
	$db_table='subcat';
	$db_rel_table='categories';
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
    		'query'=>"SELECT $db_table.*,$db_rel_table.name_ukr AS cat_name_ukr FROM $db_table lEFT JOIN $db_rel_table ON $db_rel_table.id=$db_table.cat_id",
    		'order_by'=>'id',
    		'order_desc'=>false,
    		'per_page'=>20,
    		'group_by'=>'cat_name_ukr',
    		'fields'=>array(
    			'id'=>array(
    				'header'=>array(
    					'title'=>'ID',
    					'order_by'=>'id',
    					'params'=>array(
    						'width'=>'40'
    					)
    				),
    				'data'=>array(
    					'fld'=>'id'
    				)
    			),
    			'desc'=>array(
                	'header'=>array(
    					'title'=>'Опис',
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
	    		'cat_id'=>array(
		        	'title'=>'Категорія', 'required'=>1, 'save'=>'mysql', 'form_fld'=>array('function'=>'select_tag', 'sel_query'=>"SElECT * FROM $db_rel_table ORDER BY name_ukr",'sel_key'=>'id','sel_val'=>'name_ukr')
                ),
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
