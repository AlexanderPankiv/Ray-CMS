<?
    global $config;
    
    $tpl = new Tpl();
    
    $variables = array(
        'login'=>array(
            'name'=>$config['lang_arr']['uname'],
            'required'=>1,
            'type'=>'text',
            'data'=>'alpha',
            'query'=>1,
            'state'=>''
        ),
        'pass'=>array(
            'name'=>$config['lang_arr']['upass'],
            'required'=>1,
            'type'=>'password',
            'data'=>'',
            'query'=>1,
            'state'=>''
        ),
        'rpass'=>array(
            'name'=>$config['lang_arr']['rupass'],
            'required'=>1,
            'type'=>'password',
            'data'=>'',
            'query'=>0,
            'state'=>''
        ),
        'name'=>array(
            'name'=>$config['lang_arr']['contact_name'],
            'required'=>1,
            'type'=>'text',
            'data'=>'alpha_space',
            'query'=>1,
            'state'=>''
        ),
        'email'=>array(
            'name'=>$config['lang_arr']['mail'],
            'required'=>1,
            'type'=>'text',
            'data'=>'email',
            'query'=>1,
            'state'=>''
        ),
        'adress'=>array(
            'name'=>$config['lang_arr']['adress'],
            'required'=>0,
            'type'=>'text',
            'data'=>'',
            'query'=>1,
            'state'=>''
        ),
        'phone'=>array(
            'name'=>$config['lang_arr']['phone'],
            'required'=>0,
            'type'=>'text',
            'data'=>'',
            'query'=>1,
            'state'=>''
        ),
        'icq'=>array(
            'name'=>$config['lang_arr']['icq'],
            'required'=>0,
            'type'=>'text',
            'data'=>'',
            'query'=>1,
            'state'=>''
        ),
        'skype'=>array(
            'name'=>$config['lang_arr']['skype'],
            'required'=>0,
            'type'=>'text',
            'data'=>'',
            'query'=>1,
            'state'=>''
        )
    );
    
    $submit = p('name');
    
    //////////////////////////////////
    //SHOW TABLE STATUS LIKE 'blogs'//
    //////////////////////////////////
    
    if($submit){
        global $errors_string;
        foreach($variables as $key => $value){
            if((!isset($_POST[$key])) && ($value['required']==1)){
                $errors_string .= "Поле ".$value['name'].$config['lang_arr']['not_set']."<br/>";
            }else{
                $variables[$key]['state'] = p($key);
            }
        }
        
        if($variables['pass']['state'] != $variables['rpass']['state']) $errors_string.=$config['lang_arr']['passw_not_m']."<br/>";
        
        foreach($variables as $key => $value){
            if($variables[$key]['data']!=''){
                if(!field_validator($variables[$key]['name'], $variables[$key]['state'], $variables[$key]['data'])){
                    $errors_string.=$config['lang_arr']['check_input'].$variables[$key]['name']."<br/>";
                }
            }
        }
        
        if($errors_string == ''){
            foreach($variables as $key => $value){
                if($variables[$key]['query'] == 1) $data[$key] = $variables[$key]['state'];
            }
            $data['register_date']=time();
            $data['pass']=md5($data['pass'].$data['register_date']);
            create_user($data);
            $q['result']="WIN!";
        }else{
            $q['result']=$config['lang_arr']['errors'].'<br/>'.$errors_string;
        }
        $q['submit']=1;
        echo parse_template($q, 'add_item');
    }else{        
        #echo gen_reg_form($variables);
        $tpl->data['form']=$variables;
    }
    $tpl->Show("register");
?>