<?
    global $config, $content;
    
    $content['title']=$config['lang_arr']['main'];
    
    //$tpl = new Tpl();
    //$tpl->cacheID=md5('main');
    
	//if($tpl->CacheCheck()){
	//   echo $tpl->CacheCheck();
    //}else{        
        $res = sql_do("
					SELECT subcat.name_{$config['lang']} AS subcat_name, subcat.id as subcat_id,subcat.alias AS sub_alias, 
					categories.name_{$config['lang']} AS cat_name, categories.alias 
					FROM subcat 
					LEFT JOIN categories ON categories.id=subcat.cat_id 
					ORDER BY categories.name_{$config['lang']}
					");
		if (mysql_num_rows($res)>0){
			while($arr = mysql_fetch_array($res)){
				$cat_sel[$arr['subcat_id']][0]=$arr['cat_name'];
				$cat_sel[$arr['subcat_id']][1]=$arr['subcat_name'];
				$cat_sel[$arr['subcat_id']][2]=$arr['alias'];
				$cat_sel[$arr['subcat_id']][3]=$arr['sub_alias'];
			}  
			$cache = list_cat_subcat($cat_sel);
            
            $tpl->data['key']=$cache;
            $tpl->data['mms']="main.tpl";
		}
		//$tpl->Show("main");
    //}
    
   
?>
