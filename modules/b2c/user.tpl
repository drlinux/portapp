<div class="casContent">
	<h1 class="subHeader">{#LABEL_PersonalInformation#}</h1>

	<form autocomplete="off" method="post" action="{$SCRIPT_NAME}">
	<ul class="ulform">
		<li class="dn">
			<label>{#LABEL_Tckn#}</label>
			<input type="text" name="userTckn" value="{$data.model.userTckn}" maxlength="11" title="T.C. Kimlik Numarası" readonly="readonly" />
		</li>
		<li>
			<label>{#LABEL_Tckn#}</label>
			<input type="text" name="userTcknNew" value="{$data.model.userTcknNew}" maxlength="11" title="T.C. Kimlik Numarası" required="required" />
		</li>
		<li class="dn">
			<label>{#LABEL_EmailAddress#}</label>
			<input type="email" name="userEmail" value="{$data.model.userEmail}" title="E-posta Adresi" readonly="readonly" />
		</li>
		<li>
			<label>{#LABEL_EmailAddress#}</label>
			<input type="email" name="userEmailNew" value="{$data.model.userEmailNew}" title="E-posta Adresi" required="required" />
		</li>
		<li class="dn">
			<label>{#LABEL_Username#}</label>
			<input type="text" name="userName" value="{$data.model.userName}" title="Kullanıcı adı" readonly="readonly" />
		</li>
		<li>
			<label>{#LABEL_Username#}</label>
			<input type="text" name="userNameNew" value="{$data.model.userNameNew}" title="Kullanıcı adı" required="required" />
		</li>
		<li>
			<label>{#LABEL_Password#}</label>
			<input type="password" name="userPass" title="Varolan kullanıcıya ait parolayı değiştirmek için yeni parolayı buraya girin ya da boş bırakın." />
		</li>
		<li>
			<label>{#LABEL_Gender#}</label>
			<input type="radio" name="userGender" value="F" {if $data.model.userGender eq 'F'}checked="checked"{/if} required="required" />Bayan
			<input type="radio" name="userGender" value="M" {if $data.model.userGender eq 'M'}checked="checked"{/if} required="required" />Bay
		</li>
		<li>
			<label>{#LABEL_Firstname#}</label>
			<input type="text" name="userFirstname" value="{$data.model.userFirstname}" title="İsim" required="required" />
		</li>
		<li>
			<label>{#LABEL_Lastname#}</label>
			<input type="text" name="userLastname" value="{$data.model.userLastname}" title="Soyisim" required="required" />
		</li>
		<li>
			<label>{#LABEL_Birthdate#}</label>
			{html_select_date field_array=userBirthdate field_order=DMY month_format='%m' start_year='-90' end_year='-1' reverse_years='true' time=$data.model.userBirthdate day_extra='class="day_select"' month_extra='class="month_select"' year_extra='class="year_select"'}
			<!-- <input type="date" class="date" name="userBirthdate" value="{$data.model.userBirthdate}" title="Doğum Tarihi YYYY-AA-GG" required="required" /> -->
		</li>
		<li>
			<label>{#LABEL_Phone#}</label>
			<input type="tel" class="phone" name="userPhone" value="{$data.model.userPhone}" title="Telefon numarası" required="required" />
		</li>
		<li class="buttonset">
			<button type="submit" onclick="User.updateUser(this.form);">{#BUTTON_Update#}</button>
		</li>
	</ul>
	</form>
</div>