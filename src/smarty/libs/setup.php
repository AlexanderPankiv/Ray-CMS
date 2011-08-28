<?
require_once ("Smarty.class.php");
class Smarty_WebImg extends Smarty {
 function Smarty_WebImg() {
 $this->template_dir = "../smarty/templates/";
 $this->compile_dir = "../smarty/templates_c/";
 $this->config_dir = "../smarty/config/";
 $this->cache_dir = "../smarty/cache/";
 }
}
?>