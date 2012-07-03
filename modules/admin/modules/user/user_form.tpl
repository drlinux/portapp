<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Kullanıcı Bilgileri</a></li>
		{if $data.model.userId neq null}
		<li><a href="#tabs-2">Hesap Bilgileri</a></li>
		{/if}
		{if $data.isB2B eq true}
			<li><a href="#tabs-3">Firma Bilgileri</a></li>
		{/if}
	</ul>
	<div id="tabs-1">
		<form autocomplete="off" method="post" action="{$SCRIPT_NAME}">
		<ul class="ulform">
			<li class="dn">
				<label>{#LABEL_Id#}</label>
				<input type="text" name="userId" value="{$data.model.userId}" readonly="readonly" />
			</li>
			<li>
				<label>{#LABEL_Gender#}</label>
				<input type="radio" name="userGender" value="F" {if $data.model.userGender eq 'F'}checked="checked"{/if} />Bayan
				<input type="radio" name="userGender" value="M" {if $data.model.userGender eq 'M'}checked="checked"{/if} />Bay
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
				{html_select_date field_array=userBirthdate field_order=DMY month_format='%m' start_year='-90' end_year='-1' reverse_years='true' time=$data.model.userBirthdate }
			</li>
			<li class="dn">
				<label>{#LABEL_Tckn#}</label>
				<input type="text" name="userTckn" value="{$data.model.userTckn}" maxlength="11" title="T.C. Kimlik Numarası" />
			</li>
			<li>
				<label>{#LABEL_Tckn#}</label>
				<input type="text" name="userTcknNew" value="{$data.model.userTcknNew}" maxlength="11" title="T.C. Kimlik Numarası" />
			</li>
			<li>
				<label>{#LABEL_Phone#}</label>
				<input type="tel" class="phone" name="userPhone" value="{$data.model.userPhone}" title="Telefon numarası" />
			</li>
			{if $data.model.userPosition neq ""}
				<li>
					<label>{#LABEL_PositionInCompany#}</label>
					<input type="text" name="userPosition" value="{$data.model.userPosition}" title="Firmadaki pozisyonunuz" required="required" />
				</li>
			{/if}
			<li class="buttonset">
				<button type="submit" onclick="User.updatePersonalInfo(this.form);">{#BUTTON_Save#}</button>
				{if $data.model.userId neq null}
				<button type="submit" onclick="User.deleteUser({$data.model.userId});">{#BUTTON_Delete#}</button>
				{/if}
			</li>
		</ul>
		</form>
	</div>
	{if $data.model.userId neq null}
	<div id="tabs-2">
		<form action="{$SCRIPT_NAME}" method="post">
			<ul class="ulform">
				<li>
					<label>{#LABEL_Status#}</label>
					<input type="radio" name="userStatus" value="1" {if $data.model.userStatus eq 1}checked="checked"{/if} required="required" />Etkin
					<input type="radio" name="userStatus" value="0" {if $data.model.userStatus eq 0}checked="checked"{/if} required="required" />Etkin değil
				</li>
				<li class="dn">
					<label>{#LABEL_Id#}</label>
					<input type="text" name="userId" value="{$data.model.userId}" readonly="readonly" />
				</li>
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
				<li>
					<table class="ui-widget-content ui-corner-all">
						<tbody>
							<tr class="dn">
								<td>{#LABEL_Id#}</td>
								<td>
									<input type="text" name="userId" value="{$data.model.userId}" readonly="readonly" />
								</td>
							</tr>
							<tr>
								<td>Roller</td>
								<td>
									<select name="roleId[]" multiple="multiple" title="Birden fazla seçim için Ctrl tuşuna basıp seçimlerinizi yapabilirsiniz">
									{html_options options=$data.role.options selected=$data.model.role.selected}
									</select>
								</td>
							</tr>
						</tbody>
						<!--<tfoot>
							<tr>
								<td></td>
								<td>
									<span class="buttonset">
										<button name="action" value="saveRole">{#BUTTON_Save#}</button>
									</span>
								</td>
							</tr>
						</tfoot>-->
					</table>
				</li>
				<li class="buttonset">
					<button type="submit" onclick="User.updateAccountInfo(this.form);">{#BUTTON_Save#}</button>
				</li>
			</ul>
		</form>
	</div>
	{/if}
	{if $data.isB2B eq true}
		<div id="tabs-3">
			<form method="post">
				<input type="hidden" name="companyId" value="{$data.company.companyId}" />
				<ul class="ulform">
					<li>
						<label>Firma Adı:</label>
						<input type="text" name="companyTitle" value="{$data.company.companyTitle}" />
					</li>
					<li>
						<label>Vergi Numarası:</label>
						<input type="text" name="companyTax" value="{$data.company.companyTax}" />
					</li>
					<li>
						<label>Telefon:</label>
						<input type="text" name="companyPhone" value="{$data.company.companyPhone}" />
					</li>
					<li>
						<label>Firma Adresi:</label>
						<textarea name="companyAddress">{$data.company.companyAddress}</textarea>
					</li>
					<li class="buttonset">
						<button type="submit" onclick="Company.saveCompany(this.form);">{#BUTTON_Save#}</button>
					</li>
				</ul>
			</form>
		</div>
	{/if}
	
</div>