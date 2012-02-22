<form autocomplete="off" method="post" action="{$SCRIPT_NAME}">
<ul class="ulform">
	<li class="dn">
		<label>{#LABEL_Id#}</label>
		<input type="text" name="usergroupId" value="{$data.model.usergroupId}" readonly="readonly" />
	</li>
	<li>
		<label>{#LABEL_Title#}</label>
		<input type="text" name="usergroupTitle" value="{$data.model.usergroupTitle}" title="" required="required" />
	</li>
	<li>
		<label>Kullanıcılar</label>
		<select class="multiselect" name="userId[]" multiple="multiple" size="5">
		{html_options options=$data.user.options selected=$data.model.user.selected}
		</select>
	</li>
	<li class="buttonset">
		<button name="action" value="save">{#BUTTON_Save#}</button>
		{if $data.model.usergroupId neq null}
		<button name="action" value="delete">{#BUTTON_Delete#}</button>
		{/if}
	</li>
</ul>
</form>