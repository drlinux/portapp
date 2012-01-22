<div class="casContent">
	<h1 class="subHeader">Sipariş Ayrıntıları</h1>
	
	<p><b>Ödeme Şekli:</b> {$data.payment.paymentgroup.paymentgroupTitle}</p>
	<p><b>Teslimat Adresi:</b> {$data.deliveryaddress.postaladdressContent}, {$data.deliveryaddress.postaladdressCity}, {$data.deliveryaddress.postaladdressCounty}, {$data.deliveryaddress.postaladdressPostalcode}, {$data.deliveryaddress.postaladdressCountry}</p>
	<p><b>Fatura Adresi:</b> {$data.invoiceaddress.postaladdressContent}, {$data.invoiceaddress.postaladdressCity}, {$data.invoiceaddress.postaladdressCounty}, {$data.invoiceaddress.postaladdressPostalcode}, {$data.invoiceaddress.postaladdressCountry}</p>
	<p><b>Sipariş Tutarı:</b> {$data.productattributebasket.productattributebasketTotalCur}</p>
	<p><b>Taşıma:</b> {$data.transportation.transportationTitle} ({$data.transportation.transportationPriceCur})</p>
	<p><b>Toplam Tutar:</b> {$data.amountRealWC}</p>
	<p><b>Taksit Sayısı:</b> {$data.payment.paymentTitle}</p>
</div>

<div class="casContent">
	<h2 class="mb5">Ödeme</h2>
	<p class="mb10" style="font-style: italic;">{$data.payment.paymentgroup.paymentgroupContent}</p>
	
	<form method="post" action="{$SCRIPT_NAME}">
	<input type="hidden" name="paymentId" value="{$data.payment.paymentId}" />
	<input type="hidden" name="transportationId" value="{$data.transportation.transportationId}" />
	<input type="hidden" name="deliveryaddressId" value="{$data.deliveryaddress.postaladdressId}" />
	<input type="hidden" name="invoiceaddressId" value="{$data.invoiceaddress.postaladdressId}" />
	<span class="buttonset">
		<button type="submit" onclick="Payment.confirmOrder(this.form);">{#BUTTON_ConfirmOrder#}</button>
	</span>
	</form>
</div>