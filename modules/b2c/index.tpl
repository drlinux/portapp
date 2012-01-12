<div id="mainBannerOuter" class="casContent slider-wrapper {$_THEME_B2C_NIVOSLIDER}">
	<div id="mainBanner" cas-js="getBanners" cas:url="{$SCRIPT_NAME}" cas:theme="{$_THEME_B2C_NIVOSLIDER}"></div>
</div>
<div class="casContent">
	<h3 class="subHeader">İNDİRİMLİ ÜRÜNLER</h3>
	<ul class="productsList bigProductList" cas-js="getProductsByProductgroupId" cas:url="{$SCRIPT_NAME}" cas:var="1" cas:limit="{$_THEME_B2C_LIMITPRODUCTS1}" cas-break="{$_THEME_B2C_NUMBEROFPRODUCTSDISPLAYED}">
		<li class="productItem">
			<label class="labelDiscount">
				<span class="discountPercent">%%%s</span>
				<span class="discountCount">%s</span>
				<span class="discountText">İndirimli Ürün</span>
			</label>
			<a href="modules/b2c/product.php?action=show&amp;productId=%s" class="productLogoLink">
				<img src="img/product/3_%s" class="productLogo">
			</a>
			<span class="c-ffffff">%s</span>
			<div class="costsOuter">
				<span class="oldCost">
					%s
					<span class="cross"></span>
				</span>
				<span class="currentCost">%s</span>
			</div>
			<a class="btnAddToBasket" href="">Sepete Ekle</a>
		</li>
	</ul>
</div>