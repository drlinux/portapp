<form action="{$SCRIPT_NAME}" method="post">
<ul class="ulform">
	<li>
		<label>{#LABEL_Server#}</label>
		<input type="text" name="setting[_EMAIL_SERVER]" value="{$_EMAIL_SERVER}" required="required" />
	</li>
	<li>
		<label>{#LABEL_Port#}</label>
		<input type="text" name="setting[_EMAIL_PORT]" value="{$_EMAIL_PORT}" required="required" />
	</li>
	<li>
		<label>{#LABEL_Username#}</label>
		<input type="text" name="setting[_EMAIL_USERNAME]" value="{$_EMAIL_USERNAME}" required="required" />
	</li>
	<li>
		<label>{#LABEL_Password#}</label>
		<input type="text" name="setting[_EMAIL_PASSWORD]" value="{$_EMAIL_PASSWORD}" required="required" />
	</li>
	<li>
		<label>{#LABEL_FromName#}</label>
		<input type="text" name="setting[_EMAIL_FROMNAME]" value="{$_EMAIL_FROMNAME}" required="required" />
	</li>
	<li>
		<label>{#LABEL_From#}</label>
		<input type="text" name="setting[_EMAIL_FROM]" value="{$_EMAIL_FROM}" required="required" />
	</li>
	<li>
		<label>{#LABEL_Bcc#}</label>
		<input type="text" name="setting[_EMAIL_BCC]" value="{$_EMAIL_BCC}" />
	</li>
	<li class="buttonset">
		<button name="action" value="save">{#BUTTON_Save#}</button>
	</li>
</ul>
</form>