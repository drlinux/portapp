<div class="casContent">
	{if $data.error neq 'no_error'}
		<h2 class="subHeader">Ödeme Gerçekleştirilemedi!</h2>
		<p>
			{$data.error}
		</p>
	{/if}
</div>
<div class="casContent">
	<h1 class="subHeader">Sipariş Ayrıntıları</h1>
	
	<p><b>Ödeme Şekli:</b> {$data.payment.paymentgroup.paymentgroupTitle}</p>
	<p><b>Teslimat Adresi:</b> {$data.deliveryaddress.postaladdressContent}, {$data.deliveryaddress.postaladdressCity}, {$data.deliveryaddress.postaladdressCounty}, {$data.deliveryaddress.postaladdressPostalcode}, {$data.deliveryaddress.postaladdressCountry}</p>
	<p><b>Fatura Adresi:</b> {$data.invoiceaddress.postaladdressContent}, {$data.invoiceaddress.postaladdressCity}, {$data.invoiceaddress.postaladdressCounty}, {$data.invoiceaddress.postaladdressPostalcode}, {$data.invoiceaddress.postaladdressCountry}</p>
	<p><b>Sipariş Tutarı:</b> {$data.productattributebasket.productattributebasketTotalCur}</p>
	<p><b>Hediye Çeki:</b> {$data.voucher.voucherCode} ({$data.voucherDiscountCur})</p>
	<p><b>Taksit Sayısı:</b> {$data.payment.paymentTitle} ({$data.paymentimpactCur})</p>
	<p><b>Taşıma:</b> {$data.transportation.transportationTitle} ({$data.transportation.transportationPriceCur})</p>
	<p><b>Toplam Tutar:</b> {$data.amountRealWC}</p>
</div>
<div class="casContent">
	<h2 class="mb5 subHeader">Ödeme</h2>
	<p class="mb10" style="font-style: italic;">{$data.payment.paymentgroup.paymentgroupContent}</p>
	
	<form method="post" action="{$SCRIPT_NAME}">
	<ul class="ulform">
		<li>
			<label>Kart Sahibinin Adı Soyadı</label>
			<input type="text" name="cardHolderName" required="required" />
		</li>
		<li>
			<label>Kredi Kartı Numarası</label>
			<input type="text" class="ccno" required="required" onkeyup="this.form.ccno.value=this.value.replace(/\-/g, '');" />
		</li>
		<li class="dn">
			<label>Kredi Kartı Numarası</label>
			<input type="text" name="ccno" required="required" />
		</li>
		<li>
			<label>Güvenlik Kodu</label>
			<input type="text" class="cvc" name="cvc" required="required" />
		</li>
		<li>
			<label>Son Kullanma Tarihi</label>
			{html_select_date field_array=expDate field_order=MY month_format='%m' display_days='0' start_year='+5' month_extra='class="month_select"' year_extra='class="year_select"'}
		</li>
		<li class="dn">
			<label>Toplam Tutar</label>
			<input type="text" name="amount" value="{$data.amountReal}" required="required" readonly="readonly" />
		</li>
		<li class="dn">
			<label>Taksit Sayısı</label>
			<input type="text" name="installment" value="{$data.payment.paymentPeriod}" required="required" readonly="readonly" />
		</li>
		<li>
			<button type="submit" name="action" value="provision">Gönder</button>
		</li>
	</ul>
	</form>
</div>