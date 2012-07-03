<div class="casContent">
	<h1 class="subHeader">ÜYE KAYDI</h1>
	
	<form method="post" action="{$SCRIPT_NAME}">
	<ul class="ulform" style="width:35%; float:left;">
		<li>
			<h2>Kişisel Bilgiler</h2>
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
			<input type="email" name="userEmail" title="E-posta adresinizi girin" required="required" />
		</li>
		<li>
			<label>Firmadaki Göreviniz</label>
			<input type="text" name="userPosition" title="Firmadaki görevinizi girin" required="required" />
		</li>
	</ul>
	<ul class="ulform" style="width:45%; float:left;">
		<li>
			<h2>Firma Bilgileri</h2>
		</li>
		<li>
			<label>Firma Adı</label>
			<input type="text" name="companyTitle" title="Firma adını girin" required="required" />
		</li>
		<li>
			<label>Telefon</label>
			<input type="text" name="companyPhone" title="Firma telefonunu girin" required="required" />
		</li>
		<li>
			<label>Vergi Numarası</label>
			<input type="text" name="companyTax" title="Vergi numarasını girin" required="required" />
		</li>
		<li>
			<label>Adres</label>
			<textarea type="text" name="companyAddress" title="Adresi girin" required="required" ></textarea>
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