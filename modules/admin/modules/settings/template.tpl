{foreach from=$data.templates item=item1 key=key1}
<div class="mb20" style="border-bottom: 1px solid #e4e4de;">
<strong>{$key1}</strong>
<form method="post" action="{$SCRIPT_NAME}">
<input type="hidden" name="action" value="save" />
<input type="hidden" name="module" value="{$key1}" />
{foreach from=$item1 item=item2 key=key2}
<div class="mb10">
<input type="radio" name="{$key1}" value="{$item2}" {if $data.template.{$key1} eq $key2}checked="checked"{/if} onclick="this.form.submit();" />
<a class="fancybox" href="{$smarty.const._THEMES_DIR_}{$key1}/{$item2}/capture.jpg" title="{$item2}">
	<img src="{$smarty.const._THEMES_DIR_}{$key1}/{$item2}/capture.jpg" width="50" style="border: 1px solid #e4e4de;" />
</a>
{$item2}
</div>
{/foreach}
</form>
</div>
{/foreach}
