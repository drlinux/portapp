<div id="content">
	<h1>{#LABEL_PersonalInformation#}</h1>
	<form autocomplete="off" action="{$SCRIPT_NAME}" method="post">
	<table class="jtable2">
	{if $msg ne ""}
	<caption class="ui-state-error ui-corner-all">
		{if $msg eq "userTcknNew_empty"} Lütfen T.C. Kimlik numarasını girin
		{elseif $msg eq "userTcknNew_error"} Hatalı bir T.C. Kimlik numarası girdiniz
		{elseif $msg eq "userTcknNew_exist"} Kayıtlı bir T.C. Kimlik numarası girdiniz
		{elseif $msg eq "userEmailNew_empty"} Lütfen e-posta adresini girin
		{elseif $msg eq "userEmailNew_error"} Hatalı bir e-posta adresi girdiniz
		{elseif $msg eq "userEmailNew_exist"} Kayıtlı bir e-posta adresi girdiniz
		{elseif $msg eq "userNameNew_empty"} Lütfen kullanıcı adını girin
		{elseif $msg eq "userNameNew_exist"} Kayıtlı bir kullanıcı adı girdiniz
		{elseif $msg eq "userGender_empty"} Lütfen cinsiyeti seçin
		{elseif $msg eq "userFirstname_empty"} Lütfen adı girin
		{elseif $msg eq "userLastname_empty"} Lütfen soyadı girin
		{elseif $msg eq "userBirthdate_empty"} Lütfen doğum tarihi girin
		{elseif $msg eq "userPhone_empty"} Lütfen telefon numarası girin
		{elseif $msg eq "postaladdressContent_empty"} Lütfen adresi girin
		{elseif $msg eq "save_error"} Kaydınız tamamlanamadı
		{elseif $msg eq "success"} Kaydınız başarı ile tamamlandı
		{/if}
	</caption>
	{/if}
	<tbody>
		<tr class="dn">
			<th>{#LABEL_Tckn#}</th>
			<td><input type="text" name="userTckn" value="{$data.model.userTckn}" maxlength="11" title="T.C. Kimlik Numarası" readonly="readonly" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Tckn#}</th>
			<td><input type="text" name="userTcknNew" value="{$data.model.userTcknNew}" maxlength="11" title="T.C. Kimlik Numarası" /></td>
		</tr>
		<tr class="dn">
			<th>{#LABEL_EmailAddress#}</th>
			<td><input type="text" name="userEmail" value="{$data.model.userEmail}" title="E-posta Adresi" readonly="readonly" /></td>
		</tr>
		<tr>
			<th>{#LABEL_EmailAddress#}</th>
			<td><input type="text" name="userEmailNew" value="{$data.model.userEmailNew}" title="E-posta Adresi" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr class="dn">
			<th>{#LABEL_Username#}</th>
			<td><input type="text" name="userName" value="{$data.model.userName}" title="Kullanıcı adı" readonly="readonly" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Username#}</th>
			<td><input type="text" name="userNameNew" value="{$data.model.userNameNew}" title="Kullanıcı adı" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Password#}</th>
			<td><input type="password" name="userPass" title="Varolan kullanıcıya ait parolayı değiştirmek için yeni parolayı buraya girin ya da boş bırakın." /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<th>{#LABEL_Gender#}</th>
			<td>
				<input type="radio" name="userGender" value="F" {if $data.model.userGender eq 'F'}checked="checked"{/if} />Bayan
				<input type="radio" name="userGender" value="M" {if $data.model.userGender eq 'M'}checked="checked"{/if} />Bay
			</td>
		</tr>
		<tr>
			<th>{#LABEL_Firstname#}</th>
			<td><input type="text" name="userFirstname" value="{$data.model.userFirstname}" title="İsim" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Lastname#}</th>
			<td><input type="text" name="userLastname" value="{$data.model.userLastname}" title="Soyisim" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Birthdate#}</th>
			<td><input type="text" name="userBirthdate" value="{$data.model.userBirthdate}" title="Doğum Tarihi" /></td>
		</tr>
		<tr>
			<th>{#LABEL_Phone#}</th>
			<td><input type="text" name="userPhone" value="{$data.model.userPhone}" title="Telefon numarası" /></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>
				<span class="buttonset">
					<button name="action" value="save">{#BUTTON_Save#}</button>
				</span>
			</td>
		</tr>
	</tfoot>
	</table>
	</form>
</div>