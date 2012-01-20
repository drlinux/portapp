<div id="productDetailOuter" class="casContent">
	<h1 class="subHeader">Sipariş No: {$data.XID}</h1>

	<ul class="fl w500px ultable">
		<li>
			<label>Sipariş No:</label>
			{$data.XID}
		</li>
		<li>
			<label>Sipariş Tarihi:</label>
			{$data.productorderDatetime}
		</li>
		<li>
			<label>Ödeme Şekli:</label>
			{$data.paymentgroupTitle}
		</li>
		<li>
			<label>Kargo:</label>
			{$data.transportation.transportationTitle} ({$data.transportation.transportationPriceCur})
		</li>
		<li>
			<label>Sipariş Durumu:</label>
			{$data.productorderstatusTitle}
		</li>
		<li>
			<label>Teslimat Adresi:</label>
			{$data.deliveryaddress.postaladdressContent}, {$data.deliveryaddress.postaladdressCity}, {$data.deliveryaddress.postaladdressCounty}, {$data.deliveryaddress.postaladdressPostalcode}, {$data.deliveryaddress.postaladdressCountry}
		</li>
		<li>
			<label>Fatura Adresi:</label>
			{$data.invoiceaddress.postaladdressContent}, {$data.invoiceaddress.postaladdressCity}, {$data.invoiceaddress.postaladdressCounty}, {$data.invoiceaddress.postaladdressPostalcode}, {$data.invoiceaddress.postaladdressCountry}
		</li>
	</ul>
	<table class="fl w400px mt20">
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
	{foreach from=$data.productsalesmovement item="productsalesmovement"}
	<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
		<td>{$productsalesmovement.productattributeCode}</td>
		<td>{$productsalesmovement.productTitle}</td>
		<td>{$productsalesmovement.productsalesmovementPrice}</td>
		<td>{$productsalesmovement.productsalesmovementQuantity}</td>
	</tr>
	{/foreach}
	</tbody>
	</table>
</div>