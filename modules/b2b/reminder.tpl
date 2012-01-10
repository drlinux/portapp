<div class="casContent">
	<h1 class="subHeader">Şifremi Unuttum</h1>
	
	<p style="font-style:italic">
		&nbsp; * Şifrenizi yenilememiz için lütfen mail adresinizi girin!
	</p>

	<form id="resetPasswordForm" autocomplete="off" action="{$SCRIPT_NAME}" method="post">
		<ul class="ulform">
			<li>
				<label>{#LABEL_EmailAddress#}</label>
				<input type="email" name="userEmail" value="{$data.userEmail}" title="E-posta adresinizi girin" required="required" />
			</li>
			<li>
				<span class="buttonset">
					<button type="submit" onclick="User.resetUserPass(this.form);">Şifremi Gönder</button>
				</span>
			</li>
		</ul>
	</form>
</div>