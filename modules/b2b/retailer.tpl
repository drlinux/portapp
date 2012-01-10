<div class="casContent">
	<h1 class="subHeader">{#LABEL_CompanyInformation#}</h1>

	<form autocomplete="off" method="post" action="{$SCRIPT_NAME}">
	<ul class="ulform">
		<li>
			<label>{#LABEL_Tax#}</label>
			<input type="text" name="companyTax" value="{$data.model.companyTax}" maxlength="11" title="Vergi numarası" readonly="readonly" />
		</li>
		<li>
			<label>{#LABEL_Title#}</label>
			<input type="text" name="companyTitle" value="{$data.model.companyTitle}" maxlength="11" title="Firma adı" />
		</li>
		<li>
			<label>{#LABEL_Code#}</label>
			<input type="text" name="retailerCode" value="{$data.model.retailerCode}" title="Firma kodu" />
		</li>
		<li>
			<label>{#LABEL_Phone#}</label>
			<input type="text" name="companyPhone" value="{$data.model.companyPhone}" title="Telefon numarası" />
		</li>
		<li>
			<label>{#LABEL_Fax#}</label>
			<input type="text" name="companyFax" value="{$data.model.companyFax}" title="Faks numarası" />
		</li>
		<li class="buttonset">
			<button type="submit" onclick="Company.saveCompany(this.form);">{#BUTTON_Update#}</button>
		</li>
	</ul>
	</form>
</div>