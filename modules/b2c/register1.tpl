<div class="fr padding_9px border_solid border_width_1px border_radius_4px">
	<h1 class="subHeader">ÜYE KAYDI</h1>

	<form autocomplete="off" action="{$SCRIPT_NAME}" method="post" style="width:100%; float:left;">
	<table class="jtable">
	{if $msg ne ""}
	<caption class="ui-state-error ui-corner-all">
		{if $msg eq "userGender_empty"} Lütfen cinsiyetinizi seçin
		{elseif $msg eq "userFirstname_empty"} Lütfen adınızı girin
		{elseif $msg eq "userLastname_empty"} Lütfen soyadınızı girin
		{elseif $msg eq "userBirthdate_empty"} Lütfen doğum tarihinizi girin
		{elseif $msg eq "userTckn_empty"} Lütfen TC Kimlik numaranızı girin
		{elseif $msg eq "userTckn_error"} Hatalı TC Kimlik numarası girdiniz
		{elseif $msg eq "userEmail_empty"} Lütfen e-posta adresinizi girin
		{elseif $msg eq "userEmail_error"} Hatalı e-posta adresi girdiniz
		{elseif $msg eq "userEmail_exist"} Kayıtlı bir e-posta adresi girdiniz
		{elseif $msg eq "userEmailRepeat_empty"} Lütfen e-posta adresinizi tekrar girin
		{elseif $msg eq "userEmail_notCompatible"} E-posta adresleri uyuşmuyor
		{elseif $msg eq "userPhone_empty"} Lütfen telefon numaranızı girin
		
		{elseif $msg eq "postaladdressContent_empty"} Lütfen adresinizi girin
		{elseif $msg eq "postaladdressCity_empty"} Lütfen ilinizi girin
		{elseif $msg eq "postaladdressCounty_empty"} Lütfen ilçenizi girin
		{elseif $msg eq "postaladdressPostalcode_empty"} Lütfen posta kodunuzu girin
		{elseif $msg eq "postaladdressCountry_empty"} Lütfen ülkenizi girin
		
		{elseif $msg eq "userAgreement_empty"} Üyelik için üyelik sözleşmesini okuyup kabul etmeniz gerekmektedir
		{elseif $msg eq "save_error"} Kaydınız tamamlanamadı
		{elseif $msg eq "mailer_error"} Hata oluştu
		{elseif $msg eq "success"} Kaydınız başarı ile tamamlandı. Giriş bilgileriniz "{$data.userEmail}" e-posta adresinize gönderildi.
		{/if}
	</caption>
	{/if}
	<tbody>
		<tr>
			<th>{#LABEL_Gender#}</th>
			<td>
				<input type="radio" name="userGender" value="F" {if $data.userGender eq 'F'}checked="checked"{/if}/>Bayan
				<input type="radio" name="userGender" value="M" {if $data.userGender eq 'M'}checked="checked"{/if}/>Bay
			</td>
		</tr>
		<tr>
			<th>{#LABEL_Firstname#}</th>
			<td>
				<input type="text" name="userFirstname" value="{$data.userFirstname}" title="Adınızı girin" />
			</td>
		</tr>
		<tr>
			<th>{#LABEL_Lastname#}</th>
			<td>
				<input type="text" name="userLastname" value="{$data.userLastname}" title="Soyadınızı girin" />
			</td>
		</tr>
		<tr>
			<th>{#LABEL_Birthdate#}</th>
			<td><input type="text" class="date" name="userBirthdate" value="{$data.userBirthdate}" title="Doğum Tarihinizi girin" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Tckn#}</th>
			<td><input type="text" name="userTckn" value="{$data.userTckn}" maxlength="11" title="T.C. Kimlik Numaranızı girin" /></td>
		</tr>
		<tr>
			<th>{#LABEL_EmailAddress#}</th>
			<td><input type="text" name="userEmail" value="{$data.userEmail}" title="E-posta adresinizi girin" /></td>
		</tr>
		<tr>
			<th>{#LABEL_EmailAddress#} ({#LABEL_Repeat#})</th>
			<td><input type="text" name="userEmailRepeat" value="{$data.userEmailRepeat}" title="E-posta adresinizi tekrar girin" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete="off" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Phone#}</th>
			<td><input type="text" class="phone" name="userPhone" value="{$data.userPhone}" title="Telefon numaranızı girin" /></td>
		</tr>
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<th>{#LABEL_Address#}</th>
			<td><input type="text" name="postaladdressContent" value="{$data.postaladdressContent}" title="Adresinizi girin" /></td>
		</tr>
		<tr>
			<th>{#LABEL_City#}</th>
			<td><input type="text" name="postaladdressCity" value="{$data.postaladdressCity}" title="İlinizi girin" /></td>
		</tr>
		<tr>
			<th>{#LABEL_County#}</th>
			<td><input type="text" name="postaladdressCounty" value="{$data.postaladdressCounty}" title="İlçenizi girin" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Postalcode#}</th>
			<td><input type="text" name="postaladdressPostalcode" value="{$data.postaladdressPostalcode}" title="Posta kodunuzu girin" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Country#}</th>
			<td><input type="text" name="postaladdressCountry" value="{$data.postaladdressCountry}" title="Ülkenizi girin" /></td>
		</tr>
		<tr>
			<th></th>
			<td></td>
		</tr>
		<tr>
			<th></th>
			<td>
				<input type="checkbox" name="userAgreement" title="Üyelik sözleşmesini okuyup işaretleyin" />
				<a href="{$SCRIPT_NAME}?action=getUserAgreement" title="Üyelik Sözleşmesi" onclick="CommonItems.fancyboxPopup(this); return false;">Üyelik sözleşmesi</a>ni okudum ve kabul ediyorum.
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>
				<span class="buttonset">
					<button name="action" value="register">{#BUTTON_Register#}</button>
				</span>
			</td>
		</tr>
	</tfoot>
	</table>
	</form>
</div>