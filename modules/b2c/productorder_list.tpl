<div class="casContent">
	<h1 class="subHeader">Siparişlerim</h1>

	<table class="fl w100p" style="border-spacing: 0;">
	<tbody>
		{foreach from=$data.aaData item="productorder"}
		<tr>
			<td style="border-bottom: 2px solid #cccccc; vertical-align: top;">
				<ul class="fl w500px ultable">
					<li>
						<label>Sipariş No:</label>
						<a href="{$SCRIPT_NAME}?action=showProductorder&productorderId={$productorder.productorderId}">{$productorder.XID}</a>
					</li>
					<li>
						<label>Sipariş Tarihi:</label>
						{$productorder.productorderDatetime}
					</li>
					<li>
						<label>Ödeme Şekli:</label>
						{$productorder.paymentgroupTitle}
					</li>
					<li>
						<label>Kargo:</label>
						{$productorder.transportationTitle}
					</li>
					<li>
						<label>Sipariş Durumu:</label>
						{$productorder.productorderstatusTitle}
					</li>
					<li>
						<label>Teslimat Adresi:</label>
						{$productorder.deliveryaddress.postaladdressContent}, {$productorder.deliveryaddress.postaladdressCity}, {$productorder.deliveryaddress.postaladdressCounty}, {$productorder.deliveryaddress.postaladdressPostalcode}, {$productorder.deliveryaddress.postaladdressCountry}
					</li>
					<li>
						<label>Fatura Adresi:</label>
						{$productorder.invoiceaddress.postaladdressContent}, {$productorder.invoiceaddress.postaladdressCity}, {$productorder.invoiceaddress.postaladdressCounty}, {$productorder.invoiceaddress.postaladdressPostalcode}, {$productorder.invoiceaddress.postaladdressCountry}
					</li>
				</ul>
				<table id="productOrdersList" class="fr w400px">
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
				{foreach from=$productorder.productsalesmovement item="productsalesmovement"}
				<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
					<td>{$productsalesmovement.productattributeCode}</td>
					<td>{$productsalesmovement.productTitle}</td>
					<td>{$productsalesmovement.productsalesmovementPrice}</td>
					<td>{$productsalesmovement.productsalesmovementQuantity}</td>
				</tr>
				{/foreach}
				</tbody>
				</table>
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td>Henüz siparişiniz yok</td>
		</tr>
		{/foreach}
	</tbody>
	</table>
</div>