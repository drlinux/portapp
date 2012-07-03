<div class="casContent">
	<h1 class="subHeader">{#LABEL_CompanyInformation#}</h1>

	<form autocomplete="off" method="post" action="{$SCRIPT_NAME}">
	<input type="hidden" name="userId" value="{$data.retailer.userId}" />
	<input type="hidden" name="companyId" value="{$data.retailer.companyId}" />
	<ul class="ulform">
		<li>
			<label>{#LABEL_CompanyName#}</label>
			<input type="text" name="companyTitle" value="{$data.retailer.companyTitle}" maxlength="250" title="Firma adı" required="required" />
		</li>
		<li>
			<label>{#LABEL_Tax#}</label>
			<input type="text" name="companyTax" value="{$data.retailer.companyTax}" maxlength="20" title="Vergi numarası" required="required" />
		</li>
		<li>
			<label>{#LABEL_Phone#}</label>
			<input type="text" name="companyPhone" value="{$data.retailer.companyPhone}" title="Telefon numarası" required="required" />
		</li>
		<!--<li>
			<label>{#LABEL_Fax#}</label>
			<input type="text" name="companyFax" value="{$data.retailer.companyFax}" title="Faks numarası" required="required" />
		</li>-->
		<li>
			<label>{#LABEL_Address#}</label>
			<input type="text" name="companyAddress" value="{$data.retailer.companyAddress}" title="Firma adresi" required="required" />
		</li>
		<li class="buttonset">
			<button type="submit" onclick="Company.saveCompany(this.form);">{#BUTTON_Update#}</button>
		</li>
	</ul>
	</form>
</div>