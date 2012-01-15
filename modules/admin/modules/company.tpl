<form action="{$SCRIPT_NAME}" method="post">
<ul class="ulform">
	<li>
		<!--<label>{#LABEL_CompanyName#}</label>-->
		<label>Firma Adı:</label>
		<input type="text" name="_COMPANY_NAME" value="{$_COMPANY_NAME}" />
	</li>
	<li>
		<!--<label>{#LABEL_CompanyDomain#}</label>-->
		<label>Firma Domain Adresi:</label>
		<input type="text" name="_COMPANY_DOMAIN" value="{$_COMPANY_DOMAIN}" />
	</li>
	<li>
		<!--<label>{#LABEL_CompanyAddress#}</label>-->
		<label>Firma Adresi:</label>
		<input type="text" name="_COMPANY_ADDRESS" value="{$_COMPANY_ADDRESS}" />
	</li>
	<li>
		<label>{#LABEL_CompanyPhone#}</label>
		<input type="text" name="_COMPANY_PHONE" value="{$_COMPANY_PHONE}" />
	</li>
	<li>
		<label>{#LABEL_CompanyFax#}</label>
		<input type="text" name="_COMPANY_FAX" value="{$_COMPANY_FAX}" />
	</li>
	<li>
		<label>{#LABEL_CompanyEmail#}</label>
		<input type="text" name="_COMPANY_EMAIL" value="{$_COMPANY_EMAIL}" />
	</li>
	<li>
		<label>{#LABEL_CompanyLatitude#}</label>
		<input type="text" name="_COMPANY_LATITUDE" value="{$_COMPANY_LATITUDE}" />
	</li>
	<li>
		<label>{#LABEL_CompanyLongitude#}</label>
		<input type="text" name="_COMPANY_LONGITUDE" value="{$_COMPANY_LONGITUDE}" />
	</li>
	<li>
		<label>{#LABEL_CompanyCoordinate#}</label>
		<input type="text" name="_COMPANY_COORDINATE" value="{$_COMPANY_COORDINATE}" />
	</li>
	<li>
		<div cas-class="GMAPHelper" cas-method="showMap({$_COMPANY_LATITUDE}, {$_COMPANY_LONGITUDE})"></div>
	</li>
	<li>
		<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
		</span>
	</li>
</ul>
</form>