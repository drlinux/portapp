<form action="{$SCRIPT_NAME}" method="post">
<ul class="ulform fl">
	<li>
		<label>{#LABEL_CompanyName#}</label>
		<input type="text" name="setting[_COMPANY_NAME]" value="{$_COMPANY_NAME}" />
	</li>
	<li>
		<label>{#LABEL_DomainName#}</label>
		<input type="text" name="setting[_COMPANY_DOMAIN]" value="{$_COMPANY_DOMAIN}" />
	</li>
	<li>
		<label>{#LABEL_Address#}</label>
		<input type="text" name="setting[_COMPANY_ADDRESS]" value="{$_COMPANY_ADDRESS}" />
	</li>
	<li>
		<label>{#LABEL_Phone#}</label>
		<input type="text" name="setting[_COMPANY_PHONE]" value="{$_COMPANY_PHONE}" />
	</li>
	<li>
		<label>{#LABEL_Fax#}</label>
		<input type="text" name="setting[_COMPANY_FAX]" value="{$_COMPANY_FAX}" />
	</li>
	<li>
		<label>{#LABEL_EmailAddress#}</label>
		<input type="text" name="setting[_COMPANY_EMAIL]" value="{$_COMPANY_EMAIL}" />
	</li>
	<li class="dn2">
		<label>{#LABEL_Latitude#}</label>
		<input type="text" cas-map="latitude" name="setting[_COMPANY_LATITUDE]" value="{$_COMPANY_LATITUDE}" readonly="readonly" />
	</li>
	<li class="dn2">
		<label>{#LABEL_Longitude#}</label>
		<input type="text" cas-map="longitude" name="setting[_COMPANY_LONGITUDE]" value="{$_COMPANY_LONGITUDE}" readonly="readonly" />
	</li>
	<li class="buttonset">
		<button name="action" value="save">{#BUTTON_Save#}</button>
	</li>
</ul>
</form>

<div class="fr" cas-js="getMap" cas:width="600" cas:height="375" cas:lat="{$_COMPANY_LATITUDE}" cas:lng="{$_COMPANY_LONGITUDE}" cas:draggable="true">
	<small>
	<b>{$_COMPANY_NAME}</b><br/>
	{$_COMPANY_ADDRESS}<br/>
	T: {$_COMPANY_PHONE}<br/>
	F: {$_COMPANY_FAX}<br/>
	</small>
</div>