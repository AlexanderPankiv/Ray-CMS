{if $submit == 1}
    {$result}
{else}
<script>
var lng = '{$page_lang}';
</script>
<form method="post">
<label>{$lang.subcat}: </label>{$cat_sel}<br />
<label>{$lang.region}: </label>{$reg_sel}<br />
<label>{$lang.city}: </label><div id="city_sel" style="display: inline;">{if isset($city_id)}{$city_id}{/if}</div><br />
<label>{$lang.title}: </label><input name="title"{if isset($title)}{$title}{/if}/><br />
<label>{$lang.descr}: </label><input name="descr"{if isset($descr)}{$descr}{/if}/><br />
<label>{$lang.phone}: </label><input name="phone"{if isset($phone)}{$phone}{/if}/><br />
<label>{$lang.mail}: </label><input name="email"{if isset($email)}{$email}{/if}/><br />
<label>{$lang.url}: </label><input name="url"{if isset($url)}{$url}{/if}/><br />
<label>{$lang.skype}: </label><input name="skype"{if isset($skype)}{$skype}{/if}/><br/>
<label>{$lang.price}: </label><input name="price"{if isset($price)}{$price}{/if}/><br />
<label>{$lang.contact_name}: </label><input name="contact_name"{if isset($contact_name)}{$contact_name}{/if}/><br />
<label>{$lang.expire_date}: </label><input name="expire_date"{if isset($expire_date)}{$expire_date}{/if}/><br />
<input name="submit" type="submit"/>
</form>
{/if}