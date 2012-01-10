<form action="{$SCRIPT_NAME}" method="post">
<ul class="ulform">
	<li class="dn">
		<label>{#LABEL_Parameter#}</label>
		<input type="text" name="settingParameter" value="_THEME_B2C_NAME" readonly="readonly"/>
	</li>
	<li>
		<label>Şablon</label>
		{html_options name=settingValue options=$data.templates selected=$data.template}
	</li>
	<li>
		<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
		</span>
	</li>
</ul>
</form>

{foreach from=$data.templates item=entry}
<div class="fl mr30">
	<a class="fancybox" href="{$smarty.const._THEMES_DIR_}admin/{$entry}/capture.jpg" title="{$entry}">
		<img src="{$smarty.const._THEMES_DIR_}b2c/{$entry}/capture.jpg" width="300" />
	</a>
</div>
{/foreach}
