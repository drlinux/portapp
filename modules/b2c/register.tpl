<div class="casContent">
	<h1 class="subHeader">ÜYE KAYDI</h1>
	
	<form method="post" action="{$SCRIPT_NAME}">
	<ul class="ulform">
		<li class="dn">
			<label>friendId</label>
			<input type="text" name="friendId" value="{$data.friendId}" />
		</li>
		<li>
			<label>Adınız</label>
			<input type="text" name="userFirstname" title="Adınızı girin" required="required" />
		</li>
		<li>
			<label>Soyadınız</label>
			<input type="text" name="userLastname" title="Soyadınızı girin" required="required" />
		</li>
		<li>
			<label>E-mail Adresiniz</label>
			<input type="email" name="userEmail" title="E-posta adresinizi girin" required="required" value="{$data.userEmail}" />
		</li>
		<li>
			<label>&nbsp;</label>
			<input type="checkbox" name="userAgreement" title="Üyelik sözleşmesini okuyup işaretleyin" required="required" />
			<a href="{$SCRIPT_NAME}?action=getUserAgreement" title="Üyelik Sözleşmesi" onclick="CommonItems.fancyboxPopup(this); return false;">Üyelik sözleşmesi</a>ni okudum ve kabul ediyorum.
		</li>
		<li class="buttonset">
			<button type="submit" onclick="User.saveUser(this.form);">{#BUTTON_Register#}</button>
		</li>
	</ul>
	</form>
</div>