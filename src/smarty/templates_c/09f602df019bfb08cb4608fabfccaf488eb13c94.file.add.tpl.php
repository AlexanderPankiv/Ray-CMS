<?php /* Smarty version Smarty-3.0.8, created on 2011-07-14 10:31:27
         compiled from "templates/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:316034e1e9b4fd0e475-08517405%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09f602df019bfb08cb4608fabfccaf488eb13c94' => 
    array (
      0 => 'templates/add.tpl',
      1 => 1310628565,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '316034e1e9b4fd0e475-08517405',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('submit')->value==1){?>
    <?php echo $_smarty_tpl->getVariable('result')->value;?>

<?php }else{ ?>
<script>
var lng = '<?php echo $_smarty_tpl->getVariable('page_lang')->value;?>
';
</script>
<form method="post">
<label><?php echo $_smarty_tpl->getVariable('lang')->value['subcat'];?>
: </label><?php echo $_smarty_tpl->getVariable('cat_sel')->value;?>
<br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['region'];?>
: </label><?php echo $_smarty_tpl->getVariable('reg_sel')->value;?>
<br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['city'];?>
: </label><div id="city_sel" style="display: inline;"><?php if (isset($_smarty_tpl->getVariable('city_id',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('city_id')->value;?>
<?php }?></div><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['title'];?>
: </label><input name="title"<?php if (isset($_smarty_tpl->getVariable('title',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('title')->value;?>
<?php }?>/><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['descr'];?>
: </label><input name="descr"<?php if (isset($_smarty_tpl->getVariable('descr',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('descr')->value;?>
<?php }?>/><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['phone'];?>
: </label><input name="phone"<?php if (isset($_smarty_tpl->getVariable('phone',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('phone')->value;?>
<?php }?>/><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['mail'];?>
: </label><input name="email"<?php if (isset($_smarty_tpl->getVariable('email',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('email')->value;?>
<?php }?>/><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['url'];?>
: </label><input name="url"<?php if (isset($_smarty_tpl->getVariable('url',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('url')->value;?>
<?php }?>/><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['skype'];?>
: </label><input name="skype"<?php if (isset($_smarty_tpl->getVariable('skype',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('skype')->value;?>
<?php }?>/><br/>
<label><?php echo $_smarty_tpl->getVariable('lang')->value['price'];?>
: </label><input name="price"<?php if (isset($_smarty_tpl->getVariable('price',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('price')->value;?>
<?php }?>/><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['contact_name'];?>
: </label><input name="contact_name"<?php if (isset($_smarty_tpl->getVariable('contact_name',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('contact_name')->value;?>
<?php }?>/><br />
<label><?php echo $_smarty_tpl->getVariable('lang')->value['expire_date'];?>
: </label><input name="expire_date"<?php if (isset($_smarty_tpl->getVariable('expire_date',null,true,false)->value)){?><?php echo $_smarty_tpl->getVariable('expire_date')->value;?>
<?php }?>/><br />
<input name="submit" type="submit"/>
</form>
<?php }?>