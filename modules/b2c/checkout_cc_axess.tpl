<div class="casContent">
	<h1 class="subHeader">Sipariş Ayrıntıları</h1>

	<p><b>Ödeme Şekli:</b> {$data.payment.paymentgroup.paymentgroupTitle}</p>
	<p><b>Taşıma:</b> {$data.transportation.transportationTitle}</p>
	<p><b>Teslimat Adresi:</b> {$data.deliveryaddress.postaladdressContent}, {$data.deliveryaddress.postaladdressCity}, {$data.deliveryaddress.postaladdressCounty}, {$data.deliveryaddress.postaladdressPostalcode}, {$data.deliveryaddress.postaladdressCountry}</p>
	<p><b>Fatura Adresi:</b> {$data.invoiceaddress.postaladdressContent}, {$data.invoiceaddress.postaladdressCity}, {$data.invoiceaddress.postaladdressCounty}, {$data.invoiceaddress.postaladdressPostalcode}, {$data.invoiceaddress.postaladdressCountry}</p>
	<p><b>Tutar:</b> {$data.amountRealWC}</p>
	<p><b>Taksit Sayısı:</b> {$data.payment.paymentTitle}</p>
</div>	
<div class="casContent">
	<h2>Ödeme</h2>
	<p class="mb10" style="font-style: italic;">{$data.payment.paymentgroup.paymentgroupContent}</p>
	
	<form autocomplete="off" action="{$data.payment.paymentgroup.paymentgroupGate1}" method="post">
	<table class="jtable2 fl">
	<tbody>
		<tr>
			<th>Kredi Kartı Numarası:</th>
			<td>
				<input type="text" name="pan" maxlength="20" title="Kredi Kartı Numarası" onkeyup="Payment.checkBincode(this, '{$data.payment.paymentgroup.bankCode}')" />
			</td>
		</tr>
		<tr>
			<th>Son Kullanma Tarihi (AA-YY):</th>
			<td>
				<input type="text" name="Ecom_Payment_Card_ExpDate_Month" size="2" maxlength="2" title="Kredi Kartı Son Kullanma Tarihi (AA)" />
				-
				<input type="text" name="Ecom_Payment_Card_ExpDate_Year" size="2" maxlength="2" title="Kredi Kartı Son Kullanma Tarihi (YY)" />
			</td>
		</tr>
		<tr>
			<th>Güvenlik kodu (CVV2):</th>
			<td>
				<input type="text" name="cv2" size="3" maxlength="4" title="Kredi Kartı CVV2 Numarası" />
			</td>
		</tr>
		<tr>
			<th>Tutar:</th>
			<td>{$data.amountRealWC}</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2" align="center">
				<span class="buttonset">
					<button name="action" value="order">{#BUTTON_Checkout#}</button>
				</span>
			</td>
		</tr>
	</tfoot>
	</table>
	<div class="dn">
		<fieldset>
			<legend>Zorunlu alanlar</legend>
			<!-- Zorunlu alanlar -->
			clientid:<input type="text" name="clientid" value="{$data.clientid}" /><br/>
			oid:<input type="text" name="oid" value="{$data.oid}" /><br/>
			amount:<input type="text" name="amount" value="{$data.amount}" /><br/>
			okUrl:<input type="text" name="okUrl" value="{$data.okUrl}" /><br/>
			failUrl:<input type="text" name="failUrl" value="{$data.failUrl}" /><br/>
			islemtipi:<input type="text" name="islemtipi" value="{$data.islemtipi}" /><br/>
			taksit:<input type="text" name="taksit" value="{$data.taksit}" /><br/>
			rnd:<input type="text" name="rnd" value="{$data.rnd}" /><br/>
			hash:<input type="text" name="hash" value="{$data.hash}" /><br/>
			storetype:<input type="text" name="storetype" value="{$data.storetype}" /><br/>
		</fieldset>
	
		<fieldset>
			<legend>İsteğe bağlı alanlar</legend>
			<!-- İsteğe bağlı alanlar -->
			lang:<input type="text" name="lang" value="{$data.lang}" /><br/>
			currency:<input type="text" name="currency" value="{$data.currency}" /><br/>
			firmaadi:<input type="text" name="firmaadi" value="{$smarty.server.HTTP_HOST}" /><br/>
		</fieldset>
		
		<fieldset>
			<legend>Fatura bilgileri</legend>
			<!-- Fatura bilgileri -->	
			faturaFirma:<input type="text" name="faturaFirma" value="{$data.invoiceaddress.invoiceaddressTitle}" /><br/>
			Fismi:<input type="text" name="Fismi" value="{$data.invoiceaddress.invoiceaddressTitle}" /><br/>
			Fadres:<input type="text" name="Fadres" value="{$data.invoiceaddress.invoiceaddressContent}" /><br/>
			Fadres2:<input type="text" name="Fadres2" value="" /><br/>
			Fil:<input type="text" name="Fil" value="{$data.invoiceaddress.invoiceaddressCity}" /><br/>
			Filce:<input type="text" name="Filce" value="{$data.invoiceaddress.invoiceaddressCounty}" /><br/>
			Fpostakodu:<input type="text" name="Fpostakodu" value="{$data.invoiceaddress.invoiceaddressPostalcode}" /><br/>
			tel:<input type="text" name="tel" value="{$data.invoiceaddress.invoiceaddressPhone}" /><br/>
			fulkekod:<input type="text" name="fulkekod" value="{$data.invoiceaddress.invoiceaddressCountry}" /><br/>
		</fieldset>
	
		<fieldset>
			<legend>Taşıma bilgileri</legend>
			<!-- Taşıma bilgileri -->
			nakliyeFirma:<input type="text" name="nakliyeFirma" value="{$data.transportation.transportationTitle}" /><br/>
			tismi:<input type="text" name="tismi" value="{$data.deliveryaddress.deliveryaddressTitle}" /><br/>
			tadres:<input type="text" name="tadres" value="{$data.deliveryaddress.deliveryaddressContent}" /><br/>
			tadres2:<input type="text" name="tadres2" value="" /><br/>
			til:<input type="text" name="til" value="{$data.deliveryaddress.deliveryaddressCity}" /><br/>
			tilce:<input type="text" name="tilce" value="{$data.deliveryaddress.deliveryaddressCounty}" /><br/>
			tpostakodu:<input type="text" name="tpostakodu" value="{$data.deliveryaddress.deliveryaddressPostalcode}" /><br/>
			tulkekod:<input type="text" name="tulkekod" value="{$data.deliveryaddress.deliveryaddressCountry}" /><br/>
		</fieldset>
		
		<fieldset>
			<legend>Ürün bilgileri</legend>
			<!-- Ürün bilgileri -->
			{foreach from=$data.productattributebasket.aaData item="entry" key="k"}
			itemnumber{$k+1}:<input type="text" name="itemnumber{$k+1}" value="{$k+1}" /><br/>
			productcode{$k+1}:<input type="text" name="productcode{$k+1}" value="{$entry.product.productCode}" /><br/>
			qty{$k+1}:<input type="text" name="qty{$k+1}" value="{$entry.productattributebasketQuantity}" /><br/>
			desc{$k+1}:<input type="text" name="desc{$k+1}" value="{$entry.product.productTitle}" /><br/>
			id{$k+1}:<input type="text" name="id{$k+1}" value="{$entry.productattribute.productattributeId}" /><br/>
			price{$k+1}:<input type="text" name="price{$k+1}" value="{$entry.product.productattributepriceMDV}" /><br/>
			total{$k+1}:<input type="text" name="total{$k+1}" value="{$entry.productattributebasketSubtotal}" /><br/>
			{foreachelse}
			{/foreach}
		</fieldset>
	</div>	
	</form>
</div>