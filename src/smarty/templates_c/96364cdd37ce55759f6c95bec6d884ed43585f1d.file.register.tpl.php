<?php /* Smarty version Smarty-3.0.8, created on 2011-07-14 17:12:15
         compiled from "templates/register.tpl" */ ?>
<?php /*%%SmartyHeaderCode:126644e1ef93fc39555-25428191%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96364cdd37ce55759f6c95bec6d884ed43585f1d' => 
    array (
      0 => 'templates/register.tpl',
      1 => 1310652734,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126644e1ef93fc39555-25428191',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php  $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('form')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['key']->key => $_smarty_tpl->tpl_vars['key']->value){
?>
    <label><?php echo $_smarty_tpl->tpl_vars['key']->value['name'];?>
: </label><input type="<?php echo $_smarty_tpl->tpl_vars['key']->value['type'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"/><br />
<?php }} ?>