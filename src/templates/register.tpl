{foreach $form as $key}
    <label>{$key.name}: </label><input type="{$key.type}" name="{$key}"/><br />
{/foreach}