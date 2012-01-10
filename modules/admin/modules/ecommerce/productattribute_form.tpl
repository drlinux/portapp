<h2>Ürün Stok Yönetimi</h2>

Ürün Kodu:{$data.productattribute.productattributeCode}<br/>

<form method="post" action="{$SCRIPT_NAME}">
<ul class="ultable">
	<li class="dn">
		<label>productattributeId</label>
		<input type="text" name="productattributeId" value="{$data.productattribute.productattributeId}" readonly="readonly" required="required" />
	</li>
	<li>
		<label>{#LABEL_Supplier#}</label>
		<!-- {html_options name=supplierId options=$data.supplier.options} -->
		<select name="supplierId" required="required">
		<option value="">-----</option>
		{html_options options=$data.supplier.options}
		</select>
	</li>
	<li>
		<label>{#LABEL_Datetime#}</label>
		<input type="text" name="productattributemovementDate" class="datepicker" required="required" />
	</li>
	<li>
		<label>{#LABEL_Quantity#}</label>
		<input type="text" name="productattributemovementQuantity" size="3" required="required" />
	</li>
	<li>
		<label>{#LABEL_Cost#}</label>
		<input type="text" name="productattributemovementPriceOC" size="3" required="required" />
	</li>
	<li>
		<button type="submit" onclick="Productattributemovement.saveProductattributemovement(this.form);">{#BUTTON_Add#}</button>
	</li>
</ul>
</form>

<div cas-js="getProductattributemovementByProductattributeId" cas:var="{$data.productattribute.productattributeId}" cas:url="modules/admin/modules/ecommerce/productattribute.php"></div>

<!--
<strong>Toplam Stok Miktarı</strong>: {$data.product.productattribute.movement.productattributemovementQuantityTotal}<br/>
<strong>Toplam Satış Miktarı</strong>: {$data.product.productsalesmovement.productsalesmovementQuantityTotal}<br/>
<strong>Mevcut Stok Miktarı</strong>: {$data.product.productattributeQuantity}<br/>
<strong>Average Unit Price</strong>: {$data.product.productattributepriceMDVCur}<br/>
<strong>Toplam giriş</strong>: {$data.product.productattribute.movement.iTotalRecords}<br/>
-->
