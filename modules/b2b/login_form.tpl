<div class="casContent">
	<h1 class="subHeader">Sisteme Giriş</h1>

	<form autocomplete="off" action="modules/b2b/index.php" method="post">
	<ul class="ulform">
		<li>
			<label>{#LABEL_Username#}</label>
			<input type="email" id="username" name="username" value="{$data.username}" title="Lütfen kullanıcı adınızı girin" autofocus="autofocus" required="required" />
		</li>
		<li>
			<label>{#LABEL_Password#}</label>
			<input type="password" id="password" name="password" title="Lütfen parolanızı girin" required="required" />
		</li>
		<li class="dn">
			<label>uri</label>
			<input type="text" name="uri" value="{$data.uri}" readonly="readonly" />
		</li>
		<li>
			<span class="buttonset">
				<button type="submit" onclick="User.loginUser(this.form);">{#BUTTON_Login#}</button>
			</span>
		</li>
		<li>
			<a href="modules/b2b/reminder.php">Şifremi Unuttum</a> |
			<a href="modules/b2b/register.php">Üye olmak istiyorum</a>
		</li>
	</ul>
	</form>
</div>