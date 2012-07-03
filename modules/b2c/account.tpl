<div class="casContent">
	<h1 class="subHeader">Hesap Bilgilerim</h1>

	<form autocomplete="off" method="post" action="{$SCRIPT_NAME}">
		<ul class="ulform" style="width:30%; float:left;">
			<li class="dn">
				<label>{#LABEL_EmailAddress#}</label>
				<input type="email" name="userEmail" value="{$data.model.userEmail}" title="E-posta Adresi" readonly="readonly" />
			</li>
			<li>
				<label>{#LABEL_EmailAddress#}</label>
				<input type="email" name="userEmailNew" value="{$data.model.userEmailNew}" title="E-posta Adresi" required="required" />
			</li>
			<li>
				<label>{#LABEL_EmailAddress#} ({#LABEL_Repeat#})</label>
				<input type="email" name="userEmailNew_Repeat" value="{$data.model.userEmailNew}" title="E-posta Adresi" required="required" />
			</li>
			<li>
				<label>{#LABEL_Password#}</label>
				<input type="password" name="userPass" title="Varolan kullanıcıya ait parolayı değiştirmek için yeni parolayı buraya girin ya da boş bırakın." />
			</li>
			<li>
				<label>{#LABEL_Password#} ({#LABEL_Repeat#})</label>
				<input type="password" name="userPass_Repeat" title="Parolanızı tekrar girin." />
			</li>
			<li class="buttonset">
				<button type="submit" onclick="return User.updateAccountInfo(this.form);">{#BUTTON_Update#}</button>
			</li>
		</ul>
	</form>
</div>