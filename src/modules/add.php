<?
    global $config, $user;
    
    $tpl = new Tpl();
    
    $variables = array(
        "subcat_id"=>array(
            'name'=>$config['lang_arr']['subcat'],
            'required'=>1,
            'input'=>0
        ),
        "region_id"=>array(
            'name'=>$config['lang_arr']['region'],
            'required'=>1,
            'input'=>0
        ),
        "city_id"=>array(
            'name'=>$config['lang_arr']['city'],
            'required'=>0,
            'input'=>0
        ),
        "title"=>array(
            'name'=>$config['lang_arr']['title_ad'],
            'required'=>0,
            'input'=>1
        ),
        "descr"=>array(
            'name'=>$config['lang_arr']['descr'],
            'required'=>1,
            'input'=>1
        ),
        "phone"=>array(
            'name'=>$config['lang_arr']['phone'],
            'required'=>0,
            'input'=>1
        ),
        "email"=>array(
            'name'=>$config['lang_arr']['mail'],
            'required'=>1,
            'input'=>1
        ),
        "url"=>array(
            'name'=>$config['lang_arr']['url'],
            'required'=>0,
            'input'=>1
        ),
        "skype"=>array(
            'name'=>$config['lang_arr']['skype'],
            'required'=>0,
            'input'=>1
        ),
        "price"=>array(
            'name'=>$config['lang_arr']['price'],
            'required'=>0,
            'input'=>1
        ),
        "contact_name"=>array(
            'name'=>$config['lang_arr']['contact_name'],
            'required'=>1,
            'input'=>1
        ),
        "expire_date"=>array(
            'name'=>$config['lang_arr']['expires'],
            'required'=>1,
            'input'=>1
        )
    );

    $submit = p('submit');
    
    if($submit){
        $errors_string='';
        foreach($variables as $key => $value){
            if((empty($_POST[$key]) || ($_POST[$key]=='0')) && ($value['required']==1)){              
                $errors_string .= "Поле \"".$value['name']."\" ".$config['lang_arr']['not_set']."<br/>";
            }else{
                $q_data[$key] = p($key);
            }
        }
        $q_data['user_id']=$user['id'];
        if($errors_string == ''){
            if(p('action', 1) == 1) sql_insert('ad_items', $q_data);
            if(p('action', 1) == 2) sql_update('ad_items', $q_data, g('edit_id', 1));
            $q['result']=$config['lang_arr']['add_true'];
        }else{
            $q['result']=$config['lang_arr']['errors']."<br/>".$errors_string;
        }
        
        $q['submit']=1;
        $tpl->data['result']=$q['result'];
    }else{
        if(g('edit_id', 1)){
            $q['submit']=0;
            $q['action']=2;
            $id = g('edit_id', 1);
            $res = sql_do("SELECT * FROM ad_items WHERE id='$id'");
            
            $ar = mysql_fetch_array($res);
            
            foreach($variables as $key => $value){
                if($value['input']==1){
                    $q[$key]='value="'.$ar[$key].'"';
                }
            }
            
            $res = sql_do("SELECT subcat.name_{$config['lang']} AS subcat_name, subcat.id as subcat_id,
                           categories.name_{$config['lang']} AS cat_name FROM subcat LEFT JOIN categories ON 
                           categories.id=subcat.cat_id ORDER BY categories.name_{$config['lang']}");
            
            while($arr = mysql_fetch_array($res)){
                $cat_sel[$arr['subcat_id']][0]=$arr['cat_name'];
                $cat_sel[$arr['subcat_id']][1]=$arr['subcat_name'];
            }
            $q['cat_sel'] = select_group_tag('subcat_id', $cat_sel, $ar['subcat_id']);
            
            $res = sql_do("SELECT name_{$config['lang']} AS name, id FROM regions ORDER BY name_{$config['lang']}");
                while($arr = mysql_fetch_array($res)){
                    $reg_sel[$arr['id']] = $arr['name'];
                }
            $q['reg_sel'] = select_tag('region_id', $reg_sel, $ar['region_id'], 'onChange="change_region(this.value, lng)"');
            
            $res = sql_do("SELECT name_{$config['lang']} AS city_name, id FROM cities WHERE reg_id='{$ar['region_id']}' 
                           ORDER BY id");
                           
            while($arr = mysql_fetch_array($res)){
                $result[$arr['id']] = $arr['city_name'];
            }
            $q['city_id'] = select_tag('city_id', $result, $ar['city_id']);
        }else{
            $q['submit']=0;
            $q['action']=1;
            
            foreach($variables as $key => $var){
                if($var['input'] == 1) $q[$key] = (isset($user[$key])) ? 'value="'.$user[$key].'"' : '';
            }
            
            if(checkCache(md5("add_form_subcat_select"))){
                $q['cat_sel'] = checkCache(md5("add_form_subcat_select"));
            }else{
                $res = sql_do("SELECT subcat.name_{$config['lang']} AS subcat_name, subcat.id as subcat_id,
                           categories.name_{$config['lang']} AS cat_name FROM subcat LEFT JOIN categories ON 
                           categories.id=subcat.cat_id ORDER BY categories.name_{$config['lang']}");
            
                while($arr = mysql_fetch_array($res)){
                    $cat_sel[$arr['subcat_id']][0]=$arr['cat_name'];
                    $cat_sel[$arr['subcat_id']][1]=$arr['subcat_name'];
                }
                $q['cat_sel'] = select_group_tag('subcat_id', $cat_sel);
            
                writeCache(md5("add_form_subcat_select"), $q['cat_sel']);
            }
            
            $select_city_cache = checkCache(md5("add_form_city_select"));
            
            if($select_city_cache!=''){
                $q['reg_sel'] = $user['reg_id']!='' ? preg_replace('/value="'.$user['reg_id'].'"/', '$1 selected', $select_city_cache) : $select_city_cache;
            }else{
                $res = sql_do("SELECT name_{$config['lang']} AS name, id FROM regions ORDER BY name_{$config['lang']}");
            
                while($arr = mysql_fetch_array($res)){
                    $reg_sel[$arr['id']] = $arr['name'];
                }
                $q['reg_sel'] = select_tag('region_id', $reg_sel, '', 'onChange="change_region(this.value, lng)"');
            
                writeCache(md5("add_form_city_select"), $q['reg_sel']);
            }
            
            if($user['city_id']!=''){
                $res = sql_do("SELECT name_{$config['lang']} AS city_name, id FROM cities WHERE reg_id='{$user['reg_id']}' 
                           ORDER BY id");
                           
                while($arr = mysql_fetch_array($res)){
                    $result[$arr['id']] = $arr['city_name'];
                }
                $q['city_id'] = select_tag('city_id', $result, $user['city_id']);
            }            
        }
        $q['page_lang']=$config['lang'];
    }
    foreach($q as $key => $value){
        $tpl->data[$key]=$value;
    }
           
    $tpl->Show("add");
?>