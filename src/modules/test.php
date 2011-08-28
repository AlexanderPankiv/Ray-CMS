<?
    global $config, $content;
    
    $tpl = new Tpl();
    
    $tpl->cacheID=md5(1);
    $data = '123';
    
    if($tpl->CacheCheck()!=false){
        echo $tpl->CacheCheck();
        echo 'cache';
    }else{
        $tpl->data['data']=$data;
        $tpl->Show("test");
    }
    

?>