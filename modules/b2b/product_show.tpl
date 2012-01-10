<div id="productDetailOuter" class="casContent">
	<h1 class="subHeader">{#LABEL_Product#}</h1>
	<div id="productPictureFilesOuter" class="fl margin_right_10px">
		
		<a id="productBigImageOuter" class="" href="img/product/{$data.pictureFile}" title="{$data.productTitle}">
			<img src="img/product/3_{$data.pictureFile}" />
		</a>
		<div id="productMiniImagesListOuter" class="cb jcarousel-skin-black">
			<ul>
			</ul>
		</div>
	</div>
	<div id="productInfoOuter" class="fl">
		<h1 class="productTitle">Ürün Adı: {$data.productTitle}</h1>
		<p style="float:left;">
			<span class="productattributePrice">
				Fiyatı: <span id="productDetailInfoOuterPrice"></span>
			</span>
			<br>
			Stok Durumu: <span id="productDetailInfoOuterQuantity"></span>
			<br>
			<br>
		</p>
		<form name="productForm" cas-js="formBasket" autocomplete="off" method="post" action="modules/b2b/sales.php">
			<ul id="productInfoSelectList" class="ulFormBasket productInfoList">
				
				<li>
					<p class="productCode">Ürün Kodu: {$data.productCode}</p>
				</li>
				<li class="dn">
					<label>productId:</label>
					<input type="text" name="productId" value="{$data.productId}" readonly="readonly"/>
				</li>
				<li class="dn">
					<label>productattributeId:</label>
					<input type="text" id="productattributeId" name="productattributeId" readonly="readonly"/>
				</li>
				<!--<li id="liProductDetailInfoOuterPrice">
					<label>Fiyatı: </label>
					<span id="productDetailInfoOuterPrice"></span>
				</li>
				<li id="liProductDetailInfoOuterQuantity">
					<label>Stok Durumu: </label>
					<span id="productDetailInfoOuterQuantity"></span>
				</li>-->
				{foreach from=$data.attributegroups item="entry"}
				<li>
					<label>{$entry.attributegroupTitle}: </label>
					<select name="attributeIds[]" onchange="Productattribute.checkProductattribute();">
					{html_options options=$entry.attributes.options selected=$entry.attributes.selected}
					</select>
				</li>
				{/foreach}
				<li id="liProductattributebasketQuantity">
					<label>{#LABEL_Quantity#}:</label>
					<input id="productattributebasketQuantity" type="text" name="productattributebasketQuantity" value="1" onkeyup="Productattribute.checkProductattribute();" />
				</li>
				<li>
					<button type="submit" onclick="Productattribute.updateProductattributebasket(this.form);">Sepete Ekle</button>
				</li>
			</ul>
		</form>
	</div>
	<div id="productTabMenuOuter" class="tabs cb">
		<ul>
			<li><a href="#tabs-1">Ürün Özellikleri</a></li>
			{if $data.productVideo neq null}
			<li><a href="#tabs-2">Ürün Videosu</a></li>
			{/if}
			<li><a href="#tabs-3">Taksit Seçenekleri</a></li>
			<li><a href="#tabs-4">Yorumlar</a></li>
		</ul>
		<div id="tabs-1">
			{$data.productContent}
		</div>
		<div id="tabs-2">
			{if $data.productVideo neq null}
			<!-- https://www.youtube.com/embed/7765e0QcF88?rel=0 -->
			<iframe width="640" height="360" src="{$data.productVideo}" frameborder="0" allowfullscreen></iframe>
			{/if}
		</div>
		<div id="tabs-3">
			<div id="paymentOptionsOuter"></div>
		</div>
		<div id="tabs-4">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/tr_TR/all.js#xfbml=1&appId=294608807247890";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
					
			<div class="fb-comments" data-href="https://www.bedenozgurlugu.com{$data.request_url}" data-num-posts="10" data-width="630"></div>
		</div>
	</div>
</div>
<div class="casContent">
	<h3 class="subHeader">BENZER ÜRÜNLER</h3>
	<ul class="productsList bigProductList" cas-js="getProductsSimilar" cas:url="modules/b2b/index.php" cas:var="{$data.category.defaultx.categoryId}" cas:loopstyle="loop2" cas:limit="5" cas-break="{$_THEME_NUMBEROFPRODUCTSDISPLAYED}">
		<li class="productItem">
			<label class="labelDiscount">%s</label>
			<a class="productLogoLink" href="modules/b2b/product.php?action=show&productId=%s">
				<img class="productLogo" src="img/product/2_%s">
			</a>
			<a class="productName" href="modules/b2b/product.php?action=show&productId=%s">%s</a>
			<div class="costsOuter">
				<span class="oldCost">
					%s<span class="scratch"></span>
				</span>
				<span class="currentCost">%s</span>
				<span class="btnAddToBasket" onclick="Productattribute.updateProductattributebasket_withoutForm(%s,1);" title="Sepete Ekle">Sepete Ekle</span>										
			</div>
		</li>
	</ul>
</div>