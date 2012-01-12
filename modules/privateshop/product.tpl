<div id="sidebar">
	<h1>{#LABEL_Product#}</h1>
	<p id="trackingString" >
		<a href="modules/privateshop/index.php">ANA SAYFA</a>
		&gt;
		<a href="modules/privateshop/index.php?type=category&categoryId={$data.category.defaultx.categoryId}">{$data.category.defaultx.categoryTitle}</a>
		&gt;
		{$data.productTitle} ({$data.productCode})
	</p>
	<h2>{$data.productTitle}</h2>
	<div>
		{if $data.pictureFile neq null}
		<a class="jqzoom" href="img/product/{$data.pictureFile}" title="{$data.productTitle}">
			<img src="img/product/{$data.pictureFile}" />
		</a>
		{else}
		<img src="img/no-image.png" />
		{/if}
		<br clear="all" />
		{foreach from=$data.picture.aaData item="entry"}
		<a class="fancyboxThumbnail" href="img/product/{$entry.pictureFile}">
			<img src="img/product/{$entry.pictureFile}" />
		</a>
		{/foreach}
	</div>
	
	<form cas-js="formBasket">
	<ul>
		<li class="dn">
			<input type="text" name="productId" value="{$data.productId}" readonly="readonly"/>
		</li>
		<li class="dn">
			<input type="text" id="productattributeId" name="productattributeId" readonly="readonly"/>
		</li>
		<li id="liProductDetailInfoOuterPrice">
			<label>Fiyatı: </label>
			<span id="productDetailInfoOuterPrice"></span>
		</li>
		<li id="liProductDetailInfoOuterQuantity">
			<label>Stok Durumu: </label>
			<span id="productDetailInfoOuterQuantity"></span>
		</li>
		{foreach from=$data.attributegroups item="entry"}
		<li>
			<label>{$entry.attributegroupTitle}: </label>
			<select name="attributeIds[]" onchange="Productattribute.checkProductattribute();">
			{html_options options=$entry.attributes.options selected=$entry.attributes.selected}
			</select>
		</li>
		{/foreach}
		<li>
			<label>{#LABEL_Quantity#}:</label>
			<input id="productattributebasketQuantity" type="text" name="productattributebasketQuantity" value="1" onkeyup="checkProductattribute();" />
		</li>
		<li class="buttonset">
			<button type="submit" onclick="Productattribute.updateProductattributebasket(this.form);">Sepete Ekle</button>
		</li>
	</ul>
	</form>

	<div class="tabs">
		<ul>
			<li><a href="#tabs-1">Ürün Özellikleri</a></li>
			<li><a href="#tabs-2">Taksit Seçenekleri</a></li>
			<li><a href="#tabs-3">Yorumlar</a></li>
		</ul>
		<div id="tabs-1">
			{$data.productContent}
		</div>
		<div id="tabs-2">
			<div id="paymentPeriodTable"></div>
		</div>
		<div id="tabs-3">
		</div>
	</div>
</div>