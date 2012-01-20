<table class="fl">
<caption>Sipariş Bilgileri</caption>
<tbody>
	<tr>
		<td style="width: 150px;">Sipariş No</td>
		<td>{$data.model.XID}</td>
	</tr>
	<tr>
		<td>Sipariş Tarihi</td>
		<td>{$data.model.productorderDatetime}</td>
	</tr>
	<tr>
		<td>Adı Soyadı</td>
		<td>{$data.model.userFirstname} {$data.model.userLastname}</td>
	</tr>
	<tr>
		<td>TCKN</td>
		<td>{$data.model.userTckn}</td>
	</tr>
	<tr>
		<td>Kullanıcı Adı</td>
		<td>{$data.model.userName}</td>
	</tr>
	<tr>
		<td>Kullanıcı E-mail Adresi</td>
		<td><a href="mailto:{$data.model.userEmail}">{$data.model.userEmail}</a></td>
	</tr>
	<tr>
		<td>Kullanıcı Telefon Numarası</td>
		<td>{$data.model.userPhone}</td>
	</tr>
	<tr>
		<td>Teslimat Adresi</td>
		<td>
			{$data.model.deliveryaddress.postaladdressContent},
			{$data.model.deliveryaddress.postaladdressCity},
			{$data.model.deliveryaddress.postaladdressCounty},
			{$data.model.deliveryaddress.postaladdressPostalcode},
			{$data.model.deliveryaddress.postaladdressCountry}
		</td>
	</tr>
	<tr>
		<td>Fatura Adresi</td>
		<td>
			{$data.model.invoiceaddress.postaladdressContent},
			{$data.model.invoiceaddress.postaladdressCity},
			{$data.model.invoiceaddress.postaladdressCounty},
			{$data.model.invoiceaddress.postaladdressPostalcode},
			{$data.model.invoiceaddress.postaladdressCountry}
		</td>
	</tr>
	<tr>
		<td>Ödeme</td>
		<td>{$data.model.paymentgroupTitle}</td>
	</tr>
	<tr>
		<td>Taşıma</td>
		<td>{$data.model.transportation.transportationTitle} ({$data.model.transportation.transportationPriceCur})</td>
	</tr>
	<tr>
		<td class="vat">Siparişler</td>
		<td>
			<table>
			<caption>Sipariş edilen ürün(ler)</caption>
			<thead>
				<tr>
					<th>Stok kodu</th>
					<th>Stok adı</th>
					<th>Satış birim fiyatı</th>
					<th>Miktar</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$data.model.productsalesmovement item="entry"}
				<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
					<td>{$entry.productattributeCode}</td>
					<td>{$entry.productTitle}</td>
					<td>{$entry.productsalesmovementPrice}</td>
					<td>{$entry.productsalesmovementQuantity}</td>
				</tr>
				{foreachelse}
				<tr>
					<td>{#ALERT_NoRecords#}</td>
				</tr>
				{/foreach}
			</tbody>
			</table>
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Status#}</td>
		<td>
			<form method="post">
			<input type="hidden" name="productorderId" value="{$data.model.productorderId}" readonly="readonly" />
			{html_options name=productorderstatusId options=$data.productorderstatus.options selected=$data.model.productorderstatusId}
			<!--
			<select name="productorderstatusId">
			<option value="">------</option>
			{html_options options=$data.productorderstatus.options selected=$data.model.productorderstatusId}
			</select>
			-->
			<button type="submit" onclick="Productorder.saveStatus(this.form);">Kaydet</button>
			</form>
		</td>
	</tr>
</tbody>
</table>


<form method="post" class="fr">
<h2>Mesaj Gönder</h2>
<ul class="ulform">
	<li>
		<label>Kime:</label>
		<input type="email" name="to" value="{$data.model.userEmail}" readonly="readonly" required="required" />
	</li>
	<li>
		<label>Gizli:</label>
		<input type="email" name="bcc" />
	</li>
	<li>
		<label>Konu:</label>
		<input type="text" name="subject" value="{$data.model.XID} numaralı siparişiniz" style="width: 100%;" required="required" />
	</li>
	<li>
		<label>Mesaj</label>
		<textarea name="message" style="width: 300px; height: 100px;" required="required" >Sayın {$data.model.userName};

{$data.model.XID} numaralı siparişinizin durumu "{$data.model.productorderstatusTitle}" olarak değişmiştir.</textarea>
	</li>
	<li>
		<button type="submit" onclick="Productorder.sendStatusMessage(this.form);">Gönder</button>
	</li>
</ul>
</form>