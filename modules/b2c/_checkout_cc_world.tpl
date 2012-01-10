<div class="casContent">
	<h1 class="subHeader">Sipariş Ayrıntıları</h1>
	
	<p><b>Ödeme Şekli:</b> {$data.payment.paymentgroup.paymentgroupTitle}</p>
	<p><b>Taşıma:</b> {$data.transportation.transportationTitle}</p>
	<p><b>Teslimat Adresi:</b> {$data.deliveryaddress.postaladdressContent}, {$data.deliveryaddress.postaladdressCity}, {$data.deliveryaddress.postaladdressCounty}, {$data.deliveryaddress.postaladdressPostalcode}, {$data.deliveryaddress.postaladdressCountry}</p>
	<p><b>Fatura Adresi:</b> {$data.invoiceaddress.postaladdressContent}, {$data.invoiceaddress.postaladdressCity}, {$data.invoiceaddress.postaladdressCounty}, {$data.invoiceaddress.postaladdressPostalcode}, {$data.invoiceaddress.postaladdressCountry}</p>
	<p><b>Tutar:</b> {$data.amountRealWC}</p>
	<p><b>Taksit Sayısı:</b> {$data.payment.paymentPeriod}</p>
</div>	
<div class="casContent">
	<h2>Ödeme</h2>
	<p class="mb10" style="font-style: italic;">{$data.payment.paymentgroup.paymentgroupContent}</p>
	
	
	<form autocomplete="off" action="assets/bank/ykb/Moduler/posnettds.php" method="post">
	<table class="jtable2 fl">
	<tbody class="dn">
		<tr>
			<th width="25%">Müşterinizin Adı:</th>
			<td width="35%"><input name="custName" id="custName" value="Müşteri adı" size="25" maxlength="30" title="Kredi kartı sahibinin ismi" /></td>
		</tr>
		<tr>
			<th>Sipariş No:</th>
			<td><input name="XID" id="XID" value="{$data.XID}" size="25" maxlength="20" title="Herbir alışveriş işlemi için üye işyeri tarafından oluşturulan 20 karakterli alfa-numerik sipariş numarası" /></td>
		</tr>
		<!--
		<tr>
			<th rowspan="3">Kredi Kart Bilgileri</th>
			<td>KK No:
				<input name="ccno" id="ccno" value="5400637500005263" size="22" maxlength="16" title="Kredi Kartı Numarası" onkeyup="checkBincode(this, '{$data.payment.paymentgroup.bankCode}')" />
			</td>
		</tr>
		<tr>
			<td>SKT:
				<input name="expdate" id="expdate" value="0607" size="6" maxlength="4" title="Kredi Kartı Son Kullanma Tarihi (YYAA)" />
			</td>
		</tr>
		<tr>
			<td>CVV2:
				<input name="cvv" id="cvv" value="XXX" size="5" maxlength="3" title="Kredi Kartı CVV2 Numarası" />
			</td>
		</tr>
		-->
		<tr>
			<th>Tutar (x100)</th>
			<td><input name="amount" id="amount" value="{$data.amount}" maxlength="13" title="Alışveriş tutarı (14,8 TL için 1480 giriniz.)" /></td>
		</tr>
		<tr>
			<th>Taksit sayısı:</th>
			<td><input name="instalment" id="instalment" value="{$data.instalment}" size="2" maxlength="2" title="Taksit Sayısı" /></td>
		</tr>
		<tr>
			<th>İşlem Tipi:</th>
			<td>
				<select name="tranType" id="tranType" title="Yapılması istenilen işlem tipi">
					<option value="Auth">Provizyon</option>
					<option value="Sale" selected>Satış</option>
					<option value="WP">Puan</option>
					<option value="SaleWP">Puan + Satış</option>
					<option value="Vft">Vade Farklı Satış</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>Para Birimi:</th>
			<td>
				<select name="currency" id="currency" title="Para Birimi">
					<option value="TL" selected>TL</option>
					<option value="US">US</option>
					<option value="EU">EU</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>VFT Kampanya Kodu:</th>
			<td><input name="vftCode" id="vftCode" value="K001" SIZE="8" maxlength="4" title="Vade Farklı işlem kampanya kodu" /></td>
		</tr>
	</tbody>
	<tbody>	
		<tr>
			<th>Kredi Kartı Numarası:</th>
			<td>
				<input type="text" name="ccno" maxlength="20" title="Kredi Kartı Numarası" onkeyup="Payment.checkBincode(this, '{$data.payment.paymentgroup.bankCode}')" />
			</td>
		</tr>
		<tr>
			<th>Son Kullanma Tarihi (YYAA):</th>
			<td>
				<input type="text" name="expdate" id="expdate" value="" size="6" maxlength="4" title="Kredi Kartı Son Kullanma Tarihi (YYAA)" />
			</td>
		</tr>
		<tr>
			<th>Güvenlik kodu (CVV2):</th>
			<td>
				<input type="text" name="cvv" size="3" maxlength="4" title="Kredi Kartı CVV2 Numarası" />
			</td>
		</tr>
		<tr>
			<th>Tutar:</th>
			<td>{$data.amountRealWC}</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>
				<span class="buttonset">
					<button name="action" value="order">{#BUTTON_Checkout#}</button>
				</span>
			</td>
		</tr>
	</tfoot>
	</table>
	</form>
</div>