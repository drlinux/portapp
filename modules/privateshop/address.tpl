<div id="content">
	<div id="divDeliveryaddresses"></div>
	<div id="divInvoiceaddresses"></div>
</div>

<div class="dn">
<form id="formPostaladdress">
<table>
<caption id="errorPostaladdress" class="dn">Lütfen tüm alanları doldurun</caption>
<tbody>
	<tr class="dn">
		<th>{#LABEL_Id#}</th>
		<td>
			<input type="text" name="postaladdressId" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<th>{#LABEL_Address#}</th>
		<td>
			<input type="text" name="postaladdressContent" />
		</td>
	</tr>
	<tr>
		<th>{#LABEL_City#}</th>
		<td>
			<input type="text" name="postaladdressCity" />
		</td>
	</tr>
	<tr>
		<th>{#LABEL_County#}</th>
		<td>
			<input type="text" name="postaladdressCounty" />
		</td>
	</tr>
	<tr>
		<th>{#LABEL_Postalcode#}</th>
		<td>
			<input type="text" name="postaladdressPostalcode" />
		</td>
	</tr>
	<tr>
		<th>{#LABEL_Country#}</th>
		<td>
			<input type="text" name="postaladdressCountry" />
		</td>
	</tr>
</tbody>
<tfoot>
	<tr class="dn">
		<th></th>
		<td>
			<input type="text" name="postaladdressType" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<th></th>
		<td>
			<span class="buttonset">
				<button id="buttonSavePostaladdress">Kaydet</button>
				<button id="buttonDeletePostaladdress">Sil</button>
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>
</div>