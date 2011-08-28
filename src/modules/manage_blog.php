<?php

    global $content, $config, $user;
    
    $edit_id = g('id', 1);
    $mode = g('mode');
    $update_id = p('id', 1);
    $update_title = p('title');
    $update_text = p('text');
    
    $addForm = array(
        'title'=>array(
            'name'=>$config['lang_arr']['blog_entry_name'],
            'input'=>'input',
            'type'=>'text'   
        ),
        'text'=>array(
            'name'=>$config['lang_arr']['blog_entry_text'],
            'input'=>'textarea'
        ),    
    );
    
    function addForm($addForm){
        foreach($addForm as $key => $value){
            
        }
    }
    
    if(isset($mode)){
        if($mode == 'add'){
            if(isset($update_title)){
                
            }else{
                addForm($add_form);
            }
        }
        
        if($mode == 'edit'){
            if(isset($edit_id)){
                
            }else{
                
            }
        }
    }else{
        
    }

?>