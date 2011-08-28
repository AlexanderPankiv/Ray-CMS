<?if($tpl_data['submit']==1){
    echo $tpl_data['result'];
}else{?>
<script>
var lng = "<?=$config['lang']?>";
</script>
<form method="post">
<label><?=$config['lang_arr']['subcat']?>: </label><?=$tpl_data['cat_sel']?><br />
<label><?=$config['lang_arr']['region']?>: </label><?=$tpl_data['reg_sel']?><br />
<label><?=$config['lang_arr']['city']?>: </label><div id="city_sel" style="display: inline;"><?$tpl_data['city_id'] = (!isset($tpl_data['city_id'])) ? ('<select name="city_id"><option value="0">'.$config['lang_arr']['not_sel'].'</option></select>') : $tpl_data['city_id']; print($tpl_data['city_id']);?></div><br />
<label><?=$config['lang_arr']['title']?>: </label><input name="title" <?=$tpl_data['title']?>/><br />
<label><?=$config['lang_arr']['descr']?>: </label><input name="descr" <?=$tpl_data['descr']?>/><br />
<label><?=$config['lang_arr']['phone']?>: </label><input name="phone" <?=$tpl_data['phone']?>/><br />
<label><?=$config['lang_arr']['mail']?>: </label><input name="email" <?=$tpl_data['email']?>/><br />
<label><?=$config['lang_arr']['url']?>: </label><input name="url" <?=$tpl_data['url']?>/><br />
<label><?=$config['lang_arr']['skype']?>: </label><input name="skype" <?=$tpl_data['skype']?>/><br/>
<label><?=$config['lang_arr']['price']?>: </label><input name="price" <?=$tpl_data['price']?>/><br />
<label><?=$config['lang_arr']['contact_name']?>: </label><input name="contact_name" <?=$tpl_data['contact_name']?>/><br />
<label><?=$config['lang_arr']['expire_date']?>: </label><input name="expire_date" <?=$tpl_data['expire_date']?>/><br />
<input name="action" value="<?=$tpl_data['action']?>" style="display: none;"/>
<input name="submit" type="submit"/>
</form>
<?}?>