<?
require_once 'libs/Smarty.class.php';

class Tpl extends Smarty
{
	var $data=array();
    var $cacheID;
	
	function Tpl()
	{			
		$this->template_dir = "templates/";
		$this->compile_dir = "smarty/templates_c/";
		$this->config_dir = "smarty/config/";
		$this->cache_dir = "smarty/cache/";			
	}
    
    function CacheCheck()
    {
        if(isset($this->cacheID)){
            return checkCache($this->cacheID);
        }else{
            return false;
        }
    }
	
	function Show($tpl_name)
	{
		global $config;
        foreach($this->data as $key=>$val){
            $this->assign($key,$val);
        }
        
        $this->assign('lang',$config['lang_arr']);
        $this->assign('url_conf',$config['url_conf']);
        $this->assign('url_conf_lang',$config['url_conf_lang']);

        $ret = $this->fetch($tpl_name.'.tpl');

        if(isset($this->cacheID)) writeCache($this->cacheID, $ret);
        
        echo $ret;
	}
}

?>