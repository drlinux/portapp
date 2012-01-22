<div class="casContent">
	<h1 class="subHeader">Sipariş Ayrıntıları</h1>
	
	<p><b>Ödeme Şekli:</b> {$data.payment.paymentgroup.paymentgroupTitle}</p>
	<p><b>Taşıma:</b> {$data.transportation.transportationTitle}</p>
	<p><b>Teslimat Adresi:</b> {$data.deliveryaddress.postaladdressContent}, {$data.deliveryaddress.postaladdressCity}, {$data.deliveryaddress.postaladdressCounty}, {$data.deliveryaddress.postaladdressPostalcode}, {$data.deliveryaddress.postaladdressCountry}</p>
	<p><b>Fatura Adresi:</b> {$data.invoiceaddress.postaladdressContent}, {$data.invoiceaddress.postaladdressCity}, {$data.invoiceaddress.postaladdressCounty}, {$data.invoiceaddress.postaladdressPostalcode}, {$data.invoiceaddress.postaladdressCountry}</p>
	<p><b>Tutar:</b> {$data.amountRealWC}</p>
	<p><b>Taksit Sayısı:</b> {$data.payment.paymentTitle}</p>
</div>
<div class="casCotent">
	<h2>Ödeme</h2>
	<p class="mb10" style="font-style: italic;">{$data.payment.paymentgroup.paymentgroupContent}</p>
	
	
	<form autocomplete="off" action="{$data.payment.paymentgroup.paymentgroupGate1}" method="post">
	<table class="jtable2 fl">
	<tbody>
		<tr>
			<th>Kredi Kartı Numarası:</th>
			<td>
				<input type="text" name="cardnumber" maxlength="20" title="Kredi Kartı Numarası" onkeyup="Payment.checkBincode(this, '{$data.payment.paymentgroup.bankCode}')" />
			</td>
		</tr>
		<tr>
			<th>Son Kullanma Tarihi (AA-YY):</th>
			<td>
				<input type="text" name="cardexpiredatemonth" size="2" maxlength="2" title="Kredi Kartı Son Kullanma Tarihi (AA)" />
				- 
				<input type="text" name="cardexpiredateyear" size="2" maxlength="2" title="Kredi Kartı Son Kullanma Tarihi (YY)" /> 
			</td>
		</tr>
		<tr>
			<th>Güvenlik kodu (CVV2):</th>
			<td>
				<input type="text" name="cardcvv2" size="3" maxlength="4" title="Kredi Kartı CVV2 Numarası" /> 
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
			secure3dsecuritylevel:<input type="text" name="secure3dsecuritylevel" value="{$data.secure3dsecuritylevel}" /><br/> 
			mode:<input type="text" name="mode" value="{$data.strMode}" /><br/>
			apiversion:<input type="text" name="apiversion" value="{$data.strApiVersion}" /><br/>
			terminalprovuserid:<input type="text" name="terminalprovuserid" value="{$data.strTerminalProvUserID}" /><br/>
			terminaluserid:<input type="text" name="terminaluserid" value="{$data.strTerminalUserID}" /><br/>
			terminalmerchantid:<input type="text" name="terminalmerchantid" value="{$data.strTerminalMerchantID}" /><br/>
			txntype:<input type="text" name="txntype" value="{$data.strType}" /><br/>
			txnamount:<input type="text" name="txnamount" value="{$data.strAmount}" /><br/>
			txncurrencycode:<input type="text" name="txncurrencycode" value="{$data.strCurrencyCode}" /><br/>
			txninstallmentcount:<input type="text" name="txninstallmentcount" value="{$data.strInstallmentCount}" /><br/>
			orderid:<input type="text" name="orderid" value="{$data.strOrderID}" /><br/>
			terminalid:<input type="text" name="terminalid" value="{$data.strTerminalID}" /><br/>
			successurl:<input type="text" name="successurl" value="{$data.strSuccessURL}" /><br/>
			errorurl:<input type="text" name="errorurl" value="{$data.strErrorURL}" /><br/>
			customeripaddress:<input type="text" name="customeripaddress" value="{$data.strCustomeripaddress}" /><br/>
			secure3dhash:<input type="text" name="secure3dhash" value="{$data.HashData}" /><br/>
		</fieldset>
	
		<fieldset>
			<legend>Fatura Bilgileri</legend>
	        orderaddresscount:<input type="text" name="orderaddresscount" value="1" /><br/>
	        orderaddresscity1:<input type="text" name="orderaddresscity1" value="{$data.invoiceaddress.invoiceaddressCity}" /><br/>
	        orderaddresscompany1:<input type="text" name="orderaddresscompany1" value="{$data.invoiceaddress.invoiceaddressTitle}" /><br/>
	        orderaddresscountry1:<input type="text" name="orderaddresscountry1" value="{$data.invoiceaddress.invoiceaddressCountry}" /><br/>
	        orderaddressdistrict1:<input type="text" name="orderaddressdistrict1" value="{$data.invoiceaddress.invoiceaddressCounty}" /><br/>
	        orderaddressfaxnumber1:<input type="text" name="orderaddressfaxnumber1" value="" /><br/>
	        orderaddressgsmnumber1:<input type="text" name="orderaddressgsmnumber1" value="" /><br/>
	        orderaddresslastname1:<input type="text" name="orderaddresslastname1" value="" /><br/>
	        orderaddressname1:<input type="text" name="orderaddressname1" value="" /><br/>
	        orderaddressphonenumber1:<input type="text" name="orderaddressphonenumber1" value="{$data.invoiceaddress.invoiceaddressPhone}" /><br/>
	        orderaddresspostalcode1:<input type="text" name="orderaddresspostalcode1" value="{$data.invoiceaddress.invoiceaddressPostalcode}" /><br/>
	        orderaddresstext1:<input type="text" name="orderaddresstext1" value="{$data.invoiceaddress.invoiceaddressContent}" /><br/>
	        orderaddresstype1:<input type="text" name="orderaddresstype1" value="" /><br/>
		</fieldset>
	
		<fieldset>
			<legend>Ürün bilgileri</legend>
	        orderitemcount:<input type="text" name="orderitemcount" value="{$data.productattributebasket.iTotalRecords}" /><br/>
			{foreach from=$data.productattributebasket.aaData item="entry" key="k"}
			orderitemnumber{$k+1}:<input type="text" name="orderitemnumber{$k+1}" value="{$k+1}" /><br/>
			orderitemproductid{$k+1}:<input type="text" name="orderitemproductid{$k+1}" value="{$entry.productattribute.productattributeId}" /><br/>
			orderitemproductcode{$k+1}:<input type="text" name="orderitemproductcode{$k+1}" value="{$entry.product.productCode}" /><br/>
			orderitemquantity{$k+1}:<input type="text" name="orderitemquantity{$k+1}" value="{$entry.productattributebasketQuantity}" /><br/>
			orderitemprice{$k+1}:<input type="text" name="orderitemprice{$k+1}" value="{$entry.product.productattributepriceMDV}" /><br/>
			orderitemtotalamount{$k+1}:<input type="text" name="orderitemtotalamount{$k+1}" value="{$entry.productattributebasketSubtotal}" /><br/>
			orderitemdescription{$k+1}:<input type="text" name="orderitemdescription{$k+1}" value="{$entry.product.productTitle}" /><br/>
			{/foreach}
		</fieldset>
	</div>
	
	</form>
</div>