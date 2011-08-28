<?
    global $config;
    
    $id = g('id', 1);
    $cat_alias = g('cat_alias');
    $subcat_alias = g('subcat_alias');
    
    if($id!=0){
        $res = sql_do("SELECT title_{$config['lang']} AS name, title_{$config['lang']} AS title, 
                       descr_{$config['lang']} AS descr, phone, email, url, skype, price, contact_name, added_at, expire_date 
                       FROM ad_items 
                       WHERE id='$id'");
        $q = mysql_fetch_array($res);
        echo parse_template($q, 'ad_item');        
    }
    
    if(g('cat_alias')!=''){
        if(g('subcat_alias')){
            $alias=g('subcat_alias');
            $res = sql_do("SELECT ad_items.title AS item_name, ad_items.subcat_id AS id 
                            FROM ad_items 
                            LEFT JOIN subcat ON subcat.id=ad_items.subcat_id 
                            WHERE subcat.alias='$alias'");
            while($arr = mysql_fetch_array($res)) p_r($arr);
        }elseif(g('reg_id', 1)){
            $reg_id=g('reg_id', 1);
            $res = sql_do("SELECT ad_items.title AS item_name, ad_items.subcat_id AS id 
                            FROM categories 
                            LEFT JOIN ad_items ON ad_items.subcat_id=subcat.id 
                            WHERE categories.alias='$alias'");
            while($arr = mysql_fetch_array($res)) p_r($arr);
        }else{
            $alias = g('cat_alias');
            $res = sql_do("SELECT ad_items.title 
                            FROM categories 
                            LEFT JOIN subcat ON subcat.cat_id=categories.id 
                            LEFT JOIN ad_items ON ad_items.subcat_id=subcat.id 
                            WHERE categories.alias='$alias'");
            while($arr = mysql_fetch_array($res)) p_r($arr);
        }
    }
?>