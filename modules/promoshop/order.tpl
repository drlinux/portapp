<span class="bandedTitle">Siparişlerim</span>
<div class="pageParagraph">
	<ul id="orderList">
		{foreach from=$data.aaData item="productorder"}
		<li>
			<ul>
				<li><span>Sipariş No:</span>{$productorder.XID}</li>
				<li><span>Sipariş Tarihi:</span>{$productorder.productorderDatetime}</li>
				<li><span>Ödeme Şekli:</span>{$productorder.paymentgroupTitle}</li>
				<li><span>Kargo:</span>{$productorder.transportationTitle}</li>
				<li><span>Sipariş Durumu:</span>{$productorder.productorderstatusTitle}</li>
				<li>
					<span>Teslimat adresi:</span>
					{$productorder.deliveryaddress.postaladdressContent},
					{$productorder.deliveryaddress.postaladdressCity},
					{$productorder.deliveryaddress.postaladdressCounty},
					{$productorder.deliveryaddress.postaladdressPostalcode},
					{$productorder.deliveryaddress.postaladdressCountry}
				</li>
				<li>
					<span>Fatura adresi:</span>
					{$productorder.invoiceaddress.postaladdressContent},
					{$productorder.invoiceaddress.postaladdressCity},
					{$productorder.invoiceaddress.postaladdressCounty},
					{$productorder.invoiceaddress.postaladdressPostalcode},
					{$productorder.invoiceaddress.postaladdressCountry}
				</li>
				<a href="#inline{$productorder.productorderId}" class="fancybox">Sipariş Detayı</a>
				<div class="inline" id="inline{$productorder.productorderId}">
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
				</div>
			</ul>
		</li>
		{foreachelse}
		<li>Henüz siparişiniz yok</li>
		{/foreach}
	</ul>
</div>

<style>
#orderList .inline {
	display: none;
}
</style>

<script type="text/javascript">
jQuery(document).ready(function() {
	$(".fancybox").fancybox();
});
</script>