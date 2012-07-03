<form autocomplete="off" method="post" action="{$SCRIPT_NAME}">
<ul class="ulform">
	<li>
		<label>{#LABEL_Username#}</label>
		<input type="email" id="username" name="userEmail" title="Lütfen kullanıcı adınızı girin" autofocus="autofocus" required="required" />
	</li>
	<li>
		<label>{#LABEL_Password#}</label>
		<input type="password" id="password" name="password" required="required" />
	</li>
	<li class="dn">
		<label>uri</label>
		<input type="text" name="uri" value="{$data.uri}" readonly="readonly" />
	</li>
	<li class="buttonset">
		<button type="submit" onclick="User.loginUser(this.form);">{#BUTTON_Login#}</button>
	</li>
</ul>
</form>